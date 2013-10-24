;(function (app, _) {

	var ens = '.acctg_Check';

////////////////////////////////////////////////////////////////////////////////

	app.acctg.Check.Model = app.Model.extend({

		urlRoot: app.api + 'acctg-procedures-checks',

		allow_save: false,
		integrity_error: null,

		initialize: function () {
			var self = this;
			self.expenses = new app.acctg.CheckExpense.Collection();
			self.expenses.on('all', function (event, model) {
				self.save_integrity_check();
			});
		},

		remove_expense: function (expense) {
			this.expenses.remove(expense);
			return this;
		},

		add_expense: function (expense) {
			this.expenses.push(expense);
			return this;
		},

		save_integrity_check: function () {
			var integrity_error = null;
			var total = 0.00,
				non_zero = false,
				check_amount_value = this.get('amount_value');

			this.expenses.each(function (expense) {
				// skip if already found an error
				if (integrity_error !== null) {
					return;
				}

				var value = expense.get('amount_value'),
					taccount = expense.get('taccount');

				if (value < 0) {
					integrity_error = 'You may not place negative values. Please use contra accounts.';
				}

				if (taccount == null) {
					integrity_error = 'One or more expenses are missing an account.';
				}

				total += value;

				if (value != 0) {
					non_zero = true;
				}
			});

			var diff = check_amount_value - total;

			if (integrity_error == null && diff != 0.00) {
				integrity_error = 'Please balance the expenses (total expenses must equal to amount, missing '+diff+').'
			}

			if (app.$.trim(this.get('orderof')).length == 0) {
				integrity_error = 'Please fill in order of.'
			}

			var dateinput = app.moment(this.get('date'), 'YYYY-MM-DD');
			if ( ! dateinput.isValid()) {
				integrity_error = 'The date you have entered is not valid.';
			}

			if (integrity_error == null) {
				if ( ! non_zero) {
					this.allow_save = false;
				}
				else { // there is a non-zero value
					this.allow_save = true;
				}
				this.integrity_error = null;
			}
			else { // invalid
				this.allow_save = false;
				this.integrity_error = integrity_error;
			}

			this.trigger('integrity:update', this);
		},

		save_check: function () {
			var self = this;
			self.save_integrity_check();

			if ( ! this.allow_save) {
				return; // save not allowed
			}

			var payload = {
				taccount: self.get('taccount'),
				date: self.get('date'),
				amount_type: self.get('amount_type'),
				amount_value: self.get('amount_value'),
				orderof: self.get('orderof'),
				expenses: []
			};

			this.expenses.each(function (expense) {
				payload.expenses.push({
					note: expense.get('note'),
					amount_type: expense.get('amount_type'),
					amount_value: expense.get('amount_value'),
					taccount: expense.get('taccount')
				});
			});

			console.log(payload);

			// send payload
			self.clear({silent: true});
			self.save(payload)
				.done(function (payload) {
					if ( ! ('error' in payload)) {
						self.trigger('out:entry', payload);
						self.trigger('reboot');
					}
					else if ('validation' in payload) {
						if ('+info' in payload['validation']) {
							self.errorinfo = payload['validation']['+info'];
							self.trigger('updated:errors');
						}
					}
				});
		}

	});

////////////////////////////////////////////////////////////////////////////////

	app.acctg.Check.Model.View = app.View.extend({

		options: {
			// window manager
			windows: app.windows
		},

		initialize: function () {
			var self = this;

			self.model.on('integrity:update', function () {
				self.integrity_update();
			});

			self.model.on('updated:errors', function () {
				self.updated_errors();
			});
		},

		updated_errors: function () {
			var $errors = this.$('.app-check-errors'),
				errorinfo = this.model.errorinfo;

			$errors.html('');
			_.each(errorinfo, function (i, val) {
				$errors.append('<li>'+val+'</li>');
			});

			$errors.slideDown();
		},

		// -- Rendering -------------------------------------------------------

		template: app.template('acctg-procedures-Check'),

		render: function () {
			var self = this;
			console.log('render: acctg.Check.Model');
			self.markup(self.template(self));
			self.setupcontrols();
			return self;
		},

		setupcontrols: function () {
			var self = this;

			self.model.set('journal', self.$el.data('journal-id'));

			self.$('.app-check-integrity-error')
				.html('<small>Please fill in the form.</small>');

			self.$('.app-add-check-expense')
				.on('click'+ens, function () {
					self.add_expense();
				});

			self.$('.app-save-check')
				.on('click'+ens, function () {
					self.model.save_check();
				});

			self.$('.app-check-taccount')
				.on('change'+ens, function () {
					self.model.set('taccount', $(this).val());
					self.model.save_integrity_check();
				});

			self.$('.app-check-date')
				.on('input'+ens, function () {
					self.model.set('date', $(this).val());
					self.model.save_integrity_check();
				});

			self.$('.app-check-orderof')
				.on('input'+ens, function () {
					self.model.set('orderof', $(this).val());
					self.model.save_integrity_check();
				});

			self.$('.app-check-amount')
				.on('input'+ens, function () {
					self.model.set('amount_value', $(this).val());
					self.model.save_integrity_check();
				});
		},

		integrity_update: function () {
			var self = this,
				$save = self.$('.app-save-check'),
				$error = self.$('.app-check-integrity-error')

			if (self.model.allow_save) {
				$save.removeAttr('disabled');
				$error.fadeOut('slow', function () {
					$error.html('');
				});
			}
			else { // save not allowed
				$save.attr('disabled', 'disabled');
				if (self.model.integrity_error != null) {
					$error.html('<span class="label label-danger">'+self.model.integrity_error+'</span>');
					$error.fadeIn('slow');
				}
				else { // soft disable; ie. user is still working...
					$error.html('<small>Please fill in the form.</small>');
					$error.fadeIn('slow');
				}
			}
		},

		add_expense: function () {
			var Expense = app.acctg.CheckExpense;

			this.$('.app-check-errors').slideUp()

			var ex = new Expense.Model(
					{
						taccount: null,
						amount_type: 'USD',
						amount_value: 0.00,
						note: ''
					},
					{
						collection: this.model
					}
				),
				ex_view = new Expense.Model.View({model: ex});

			this.model.add_expense(ex);
			this.$('.app-expenses').append(ex_view.render().el);
		}

	});

}(window.App, window._));