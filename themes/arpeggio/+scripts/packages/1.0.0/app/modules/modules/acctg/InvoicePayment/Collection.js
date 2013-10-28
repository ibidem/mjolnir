;(function (app, _) {

	var ens = '.acctg_InvoicePayment';

////////////////////////////////////////////////////////////////////////////////

	app.acctg.InvoicePayment.Collection = app.Collection.extend({
		url: app.api + 'acctg-invoice-payments'
	});

}(window.App, window._));