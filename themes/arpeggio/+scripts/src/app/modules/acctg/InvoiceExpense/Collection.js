;(function (app, _) {

	var ens = '.acctg_InvoiceExpense';

////////////////////////////////////////////////////////////////////////////////

	app.acctg.InvoiceExpense.Collection = app.Collection.extend({
		url: app.api + 'acctg-invoice-expenses'
	});

}(window.App, window._));