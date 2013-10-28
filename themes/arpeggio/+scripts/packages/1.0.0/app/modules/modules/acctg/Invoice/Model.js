;(function (app, _) {

	var ens = '.acctg_Invoice';

////////////////////////////////////////////////////////////////////////////////

	app.acctg.Invoice.Model = app.Model.extend({

		urlRoot: app.api + 'acctg-procedures-invoices',

		allow_save: false,
		integrity_error: null,

		initialize: function () {
			var self = this;
			self.payments = new app.acctg.InvoicePayment.Collection();
			self.payments.on('all', function (event, model) {
				self.save_integrity_check();
			});
			self.expenses = new app.acctg.InvoiceExpense.Collection();
			self.expenses.on('all', function (event, model) {
				self.save_integrity_check();
			});
		},

		remove_payment: function (payment) {
			this.payments.remove(payment);
			return this;
		},

		add_payment: function (payment) {
			this.payments.push(payment);
			return this;
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
				invoice_amount_value = this.total_expenses();

			this.payments.each(function (payment) {
				// skip if already found an error
				if (integrity_error !== null) {
					return;
				}

				var value = payment.get('amount_value'),
					taccount = payment.get('taccount');

				if (value < 0) {
					integrity_error = 'You may not place negative values. Please use contra accounts.';
				}

				if (taccount == null) {
					integrity_error = 'One or more payments are missing an account.';
				}

				total += value;
			});

			this.expenses.each(function (expense) {
				// skip if already found an error
				if (integrity_error !== null) {
					return;
				}

				var value = expense.total(),
					quantity = expense.get('quantity'),
					description = expense.get('description');

				if (description.length == 0) {
					integrity_error = 'One or more expenses are missing a description.';
				}

				if (quantity == 0) {
					integrity_error = 'One or more expenses have 0 for quantity.';
				}

				if (value != 0) {
					non_zero = true;
				}
			})

			var diff = total - invoice_amount_value;

			if (integrity_error == null && diff > 0.00) {
				integrity_error = 'Payments may not exceed total amount (over by '+diff+').'
			}

			if (app.$.trim(this.get('description')).length == 0) {
				integrity_error = 'Please fill in a description.'
			}

			var dateinput = app.moment(this.get('duedate'), 'YYYY-MM-DD');
			if ( ! dateinput.isValid()) {
				integrity_error = 'The due date you have entered is not valid.';
			}

			dateinput = app.moment(this.get('date'), 'YYYY-MM-DD');
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

		save_invoice: function () {
			var self = this;
			self.save_integrity_check();

			if ( ! this.allow_save) {
				return; // save not allowed
			}

			var payload = {
				date: self.get('date'),
				duedate: self.get('duedate'),
				description: self.get('description'),
				payments: [],
				expenses: []
			};

			this.payments.each(function (payment) {
				payload.payments.push({
					note: payment.get('note'),
					amount_type: payment.get('amount_type'),
					amount_value: payment.get('amount_value'),
					taccount: payment.get('taccount')
				});
			});

			this.expenses.each(function (expense) {
				console.log('DEBUG', expense);
				payload.expenses.push({
					note: expense.get('note'),
					quantity: expense.get('quantity'),
					unit_type: expense.get('unit_type'),
					unit_value: expense.get('unit_value'),
					description: expense.get('description')
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
		},

		total_expenses: function () {
			var total = 0.00;
			this.expenses.each(function (exepnse) {
				total += exepnse.total();
			})
			return total;
		}

	});

////////////////////////////////////////////////////////////////////////////////

	app.acctg.Invoice.Model.View = app.View.extend({

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
			var $errors = this.$('.app-invoice-errors'),
				errorinfo = this.model.errorinfo;

			$errors.html('');
			_.each(errorinfo, function (i, val) {
				$errors.append('<li>'+val+'</li>');
			});

			$errors.slideDown();
		},

		// -- Rendering -------------------------------------------------------

		template: app.template('acctg-procedures-Invoice'),

		render: function () {
			var self = this;
			console.log('render: acctg.Invoice.Model');
			self.markup(self.template(self));
			self.setupcontrols();
			return self;
		},

		setupcontrols: function () {
			var self = this;

			self.model.set('journal', self.$el.data('journal-id'));

			self.$('.app-invoice-integrity-error')
				.html('<small>Please fill in the form.</small>');

			self.$('.app-add-invoice-payment')
				.on('click'+ens, function () {
					self.add_payment();
				});

			self.$('.app-add-invoice-expense')
				.on('click'+ens, function () {
					self.add_expense();
				});

			self.$('.app-save-invoice')
				.on('click'+ens, function () {
					self.model.save_invoice();
				});

			self.$('.app-invoice-date')
				.on('input'+ens, function () {
					self.model.set('date', $(this).val());
					self.model.save_integrity_check();
				});

			self.$('.app-invoice-duedate')
				.on('input'+ens, function () {
					self.model.set('duedate', $(this).val());
					self.model.save_integrity_check();
				});

			self.$('.app-invoice-description')
				.on('input'+ens, function () {
					self.model.set('description', $(this).val());
					self.model.save_integrity_check();
				});
		},

		integrity_update: function () {
			var self = this,
				$save = self.$('.app-save-invoice'),
				$error = self.$('.app-invoice-integrity-error')

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

		add_payment: function () {
			var Payment = app.acctg.InvoicePayment;

			this.$('.app-invoice-errors').slideUp()

			var py = new Payment.Model(
					{
						taccount: null,
						amount_value: 0.00,
						amount_type: 'USD',
						note: ''
					},
					{
						collection: this.model
					}
				),
				py_view = new Payment.Model.View({model: py});

			this.model.add_payment(py);
			this.$('.app-payments').append(py_view.render().el);
		},

		add_expense: function () {
			var self = this;
			var Expense = app.acctg.InvoiceExpense;

			this.$('.app-invoice-errors').slideUp()

			var ex = new Expense.Model(
					{
						description: '',
						quantity: 0,
						unit_value: 0.00,
						unit_type: 'USD',
						note: ''
					},
					{
						collection: this.model
					}
				),
				ex_view = new Expense.Model.View({model: ex});

			ex.on('all', function () {
				self.refresh_total_amount();
				self.model.save_integrity_check();
			});

			self.model.add_expense(ex);
			self.$('.app-expenses').append(ex_view.render().el);
		},

		refresh_total_amount: function () {
			this.$('.app-invoice-amount').val(this.model.total_expenses());
		}

	});

}(window.App, window._));