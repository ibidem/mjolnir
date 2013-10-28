;(function (app, _) {

	var ens = '.acctg_InvoiceExpense';

////////////////////////////////////////////////////////////////////////////////

	app.acctg.InvoiceExpense.Model = app.Model.extend({

		urlRoot: app.api + 'acctg-invoice-expenses',

		remove: function () {
			this.collection.remove_expense(this);
		},

		total: function () {
			return this.get('unit_value') * this.get('quantity');
		}

	});

////////////////////////////////////////////////////////////////////////////////

	app.acctg.InvoiceExpense.Model.View = app.View.extend({

		options: {
			// window manager
			windows: app.windows,
			// parent invoice
			invoice: null,
			// InvoiceExpense.Model
			model: null
		},

		// -- Rendering -------------------------------------------------------

		template: app.template('acctg-procedures-InvoiceExpense'),

		render: function () {
			var self = this;
			console.log('render: acctg.InvoiceExpense.Model.View');
			self.markup(self.template(self));
			self.setupcontrols();
			return self;
		},

		setupcontrols: function () {
			var self = this,
				$description = self.$('.app-description'),
				$quantity = self.$('.app-quantity'),
				$amount = self.$('.app-amount'),
				$total = self.$('.app-total-amount'),
				$remove = self.$('.app-remove'),
				$note = self.$('.app-note');

			$description
				.on('input'+ens, function () {
					self.model.set('description', $description.val());
				});

			$quantity
				.on('input'+ens, function () {
					var new_amount = $quantity.val();
					if (new_amount.length != 0) {
						self.model.set('quantity', parseInt(new_amount));
					}
					else { // quantity is empty
						self.model.set('quantity', 0);
					}
					$total.val(self.model.total());
				});

			$amount
				.on('input'+ens, function () {
					var new_amount = $amount.val();
					if (new_amount.length != 0) {
						self.model.set('unit_value', parseFloat(new_amount));
					}
					else { // amount is empty
						self.model.set('unit_value', 0.00);
					}
					$total.val(self.model.total());
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