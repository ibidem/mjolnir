;(function (app, _) {

	var ens = '.acctg_TransactionOperation';

////////////////////////////////////////////////////////////////////////////////

	app.acctg.TransactionOperation.Model = app.Model.extend({

		urlRoot: app.api + 'acctg-transaction-operations',

		attributes: {
			taccount: null,
			amount_value: 0.00,
			amount_type: 'USD',
			type: 0, // ie. neither Dr nor Cr
			note: ''
		},

		remove: function () {
			this.collection.remove_operation(this);
		}

	});

////////////////////////////////////////////////////////////////////////////////

	app.acctg.TransactionOperation.Model.View = app.View.extend({

		options: {
			// window manager
			windows: app.windows,
			// parent transaction
			transaction: null,
			// TransactionOperation.Model
			model: null
		},

		// -- Rendering -------------------------------------------------------

		template: app.template('acctg-TransactionOperation'),

		render: function () {
			var self = this;
			console.log('render: acctg.TransactionOperation.Model.View');
			self.markup(self.template(self));
			self.setupcontrols();
			return self;
		},

		setupcontrols: function () {
			var self = this,
				$taccount = self.$('.app-taccount'),
				$debit = self.$('.app-debit'),
				$credit = self.$('.app-credit'),
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

			$debit
				.on('input'+ens, function () {
					var new_debit = $debit.val();
					if (self.empty_or_invalid(new_debit)) {
						$debit.val('');
						self.model.set('amount_value', 0.00);
						self.model.set('type', 0);
						$credit.css('visibility', 'visible');
						$credit.val('');
					}
					else { // got a valid value
						self.model.set('type', +1);
						self.model.set('amount_value', parseFloat(new_debit));
						$credit.css('visibility', 'hidden');
					}
				});

			$credit
				.on('input'+ens, function () {
					var new_credit = $credit.val();
					if (self.empty_or_invalid(new_credit)) {
						$credit.val('');
						self.model.set('amount_value', 0.00);
						self.model.set('type', 0);
						$debit.css('visibility', 'visible');
						$debit.val('');
					}
					else { // got a valid value
						self.model.set('type', -1);
						self.model.set('amount_value', parseFloat(new_credit));
						$debit.css('visibility', 'hidden');
					}
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