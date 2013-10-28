;(function (app, _) {

	var ens = '.acctg_Deposit';

////////////////////////////////////////////////////////////////////////////////

	app.acctg.Deposit.Model = app.Model.extend({

		urlRoot: app.api + 'acctg-procedures-deposits',

		allow_save: false,
		integrity_error: null,

		initialize: function () {
			var self = this;
			self.payments = new app.acctg.DepositPayment.Collection();
			self.payments.on('all', function (event, model) {
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

		save_integrity_check: function () {
			var integrity_error = null;
			var total = 0.00,
				non_zero = false,
				deposit_amount_value = this.get('amount_value');

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

				if (value != 0) {
					non_zero = true;
				}
			});

			var diff = deposit_amount_value - total;

			if (integrity_error == null && diff != 0.00) {
				integrity_error = 'Please balance the payments (total payments must equal to amount, missing '+diff+').'
			}

			if (app.$.trim(this.get('description')).length == 0) {
				integrity_error = 'Please fill in a description.'
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

		save_deposit: function () {
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
				description: self.get('description'),
				payments: []
			};

			this.payments.each(function (payment) {
				payload.payments.push({
					note: payment.get('note'),
					amount_type: payment.get('amount_type'),
					amount_value: payment.get('amount_value'),
					taccount: payment.get('taccount')
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

	app.acctg.Deposit.Model.View = app.View.extend({

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
			var $errors = this.$('.app-deposit-errors'),
				errorinfo = this.model.errorinfo;

			$errors.html('');
			_.each(errorinfo, function (i, val) {
				$errors.append('<li>'+val+'</li>');
			});

			$errors.slideDown();
		},

		// -- Rendering -------------------------------------------------------

		template: app.template('acctg-procedures-Deposit'),

		render: function () {
			var self = this;
			console.log('render: acctg.Deposit.Model');
			self.markup(self.template(self));
			self.setupcontrols();
			return self;
		},

		setupcontrols: function () {
			var self = this;

			self.model.set('journal', self.$el.data('journal-id'));

			self.$('.app-deposit-integrity-error')
				.html('<small>Please fill in the form.</small>');

			self.$('.app-add-deposit-payment')
				.on('click'+ens, function () {
					self.add_payment();
				});

			self.$('.app-save-deposit')
				.on('click'+ens, function () {
					self.model.save_deposit();
				});

			self.$('.app-deposit-taccount')
				.on('change'+ens, function () {
					self.model.set('taccount', $(this).val());
					self.model.save_integrity_check();
				});

			self.$('.app-deposit-date')
				.on('input'+ens, function () {
					self.model.set('date', $(this).val());
					self.model.save_integrity_check();
				});

			self.$('.app-deposit-description')
				.on('input'+ens, function () {
					self.model.set('description', $(this).val());
					self.model.save_integrity_check();
				});

			self.$('.app-deposit-amount')
				.on('input'+ens, function () {
					self.model.set('amount_value', $(this).val());
					self.model.save_integrity_check();
				});
		},

		integrity_update: function () {
			var self = this,
				$save = self.$('.app-save-deposit'),
				$error = self.$('.app-deposit-integrity-error')

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
			var Payment = app.acctg.DepositPayment;

			this.$('.app-deposit-errors').slideUp()

			var py = new Payment.Model(
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
				py_view = new Payment.Model.View({model: py});

			this.model.add_payment(py);
			this.$('.app-payments').append(py_view.render().el);
		}

	});

}(window.App, window._));