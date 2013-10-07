;(function (app, _) {

	var ens = '.acctg_Transaction';

////////////////////////////////////////////////////////////////////////////////

	app.acctg.Transaction.Model = app.Model.extend({

		urlRoot: app.api + 'acctg-transactions',

		allow_save: false,
		integrity_error: null,

		initialize: function () {
			var self = this;
			self.operations = new app.acctg.TransactionOperation.Collection();
			self.operations.on('all', function (event, model) {
				self.save_integrity_check();
			});
		},

		remove_operation: function (operation) {
			this.operations.remove(operation);
			return this;
		},

		add_operation: function (operation) {
			this.operations.push(operation);
			return this;
		},

		save_integrity_check: function () {
			var integrity_error = null;
			var total = 0.00,
				non_zero = false;

			this.operations.each(function (operation) {
				// skip if already found an error
				if (integrity_error !== null) {
					return;
				}

				var value = operation.get('amount_value'),
					type = operation.get('type'),
					taccount = operation.get('taccount');

				if (value < 0) {
					integrity_error = 'You may not place negative values. Please use contra accounts.';
				}

				if (taccount == null) {
					integrity_error = 'One or more operations are missing an account.';
				}

				total += type * value;

				if (value != 0) {
					non_zero = true;
				}
			});

			if (integrity_error == null && total != 0.00) {
				integrity_error = 'Please balance the entry (total debit must equal total credit).'
			}

			// transaction fields
			if (app.$.trim(this.get('description')).length == 0) {
				integrity_error = 'Please add a description.'
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

		save_transaction: function () {
			var self = this;
			self.save_integrity_check();

			if ( ! this.allow_save) {
				return; // save not allowed
			}

			var payload = {
				journal: self.get('journal'),
				description: self.get('description'),
				date: self.get('date'),
				operations: []
			};

			this.operations.each(function (operation) {
				payload.operations.push({
					note: operation.get('note'),
					amount_type: operation.get('amount_type'),
					amount_value: operation.get('amount_value'),
					taccount: operation.get('taccount'),
					type: operation.get('type')
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

	app.acctg.Transaction.Model.View = app.View.extend({

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
			var $errors = this.$('.app-transaction-errors'),
				errorinfo = this.model.errorinfo;

			$errors.html('');
			_.each(errorinfo, function (i, val) {
				$errors.append('<li>'+val+'</li>');
			});

			$errors.slideDown();
		},


		// -- Rendering -------------------------------------------------------

		template: app.template('acctg-Transaction'),

		render: function () {
			var self = this;
			console.log('render: acctg.Transaction.Model');
			self.markup(self.template(self));
			self.setupcontrols();
			return self;
		},

		setupcontrols: function () {
			var self = this;

			self.model.set('journal', self.$el.data('journal-id'));

			self.$('.app-transaction-integrity-error')
				.html('<small>Please fill in the form.</small>');

			self.$('.app-add-operation')
				.on('click'+ens, function () {
					self.add_operation();
				});

			self.$('.app-save-transaction')
				.on('click'+ens, function () {
					self.model.save_transaction();
				});

			self.$('.app-transaction-description')
				.on('input'+ens, function () {
					self.model.set('description', $(this).val());
					self.model.save_integrity_check();
				});

			self.$('.app-transaction-date')
				.on('input'+ens, function () {
					self.model.set('date', $(this).val());
					self.model.save_integrity_check();
				});
		},

		integrity_update: function () {
			var self = this,
				$save = self.$('.app-save-transaction'),
				$error = self.$('.app-transaction-integrity-error')

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

		add_operation: function () {
			var Operation = app.acctg.TransactionOperation;

			this.$('.app-transaction-errors').slideUp()

			var op = new Operation.Model(
					{
						taccount: null,
						amount_type: 'USD',
						amount_value: 0.00,
						type: 0, // = neither Dr nor Cr
						note: ''
					},
					{
						collection: this.model
					}
				),
				op_view = new Operation.Model.View({model: op});

			this.model.add_operation(op);
			this.$('.app-operations').append(op_view.render().el);
		}

	});

}(window.App, window._));