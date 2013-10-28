;(function (app, _) {

	var ens = '.acctg_DepositPayment';

////////////////////////////////////////////////////////////////////////////////

	app.acctg.DepositPayment.Model = app.Model.extend({

		urlRoot: app.api + 'acctg-deposit-payments',

		attributes: {
			taccount: null,
			amount_value: 0.00,
			amount_type: 'USD',
			note: ''
		},

		remove: function () {
			this.collection.remove_payment(this);
		}

	});

////////////////////////////////////////////////////////////////////////////////

	app.acctg.DepositPayment.Model.View = app.View.extend({

		options: {
			// window manager
			windows: app.windows,
			// parent deposit
			deposit: null,
			// DepositPayment.Model
			model: null
		},

		// -- Rendering -------------------------------------------------------

		template: app.template('acctg-procedures-DepositPayment'),

		render: function () {
			var self = this;
			console.log('render: acctg.DepositPayment.Model.View');
			self.markup(self.template(self));
			self.setupcontrols();
			return self;
		},

		setupcontrols: function () {
			var self = this,
				$taccount = self.$('.app-taccount'),
				$amount = self.$('.app-amount'),
				$remove = self.$('.app-remove'),
				$note = self.$('.app-note');

			$taccount
				.on('change'+ens, function () {
					var taccount = $taccount.val();
					if ( ! self.empty_or_invalid_taccount(taccount)) {
						self.model.set('taccount', parseInt(taccount));
					}
					else { // empty or invalid
						self.model.set('taccount', null);
					}
				});

			$amount
				.on('input'+ens, function () {
					var new_amount = $amount.val();
					self.model.set('amount_value', parseFloat(new_amount));
				});

			$note
				.on('input'+ens, function () {
					self.model.set('note', $note.val());
				});

			$remove
				.on('click'+ens, function () {
					self.remove();
				});
		},

		empty_or_invalid_taccount: function (val) {
			return val.length == 0
				|| ! val.match(/[0-9]+/g)
				|| isNaN(parseInt(val));
		},

		empty_or_invalid: function (val) {
			return val.length == 0
				|| ! val.match(/[0-9,.]+/g)
				|| isNaN(parseFloat(val))
				|| parseFloat(val) == 0;
		},

		remove: function () {
			this.model.remove();
			this.$el.remove();
		}

	});

}(window.App, window._));