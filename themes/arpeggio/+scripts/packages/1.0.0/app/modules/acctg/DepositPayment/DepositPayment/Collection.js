;(function (app, _) {

	var ens = '.acctg_DepositPayment';

////////////////////////////////////////////////////////////////////////////////

	app.acctg.DepositPayment.Collection = app.Collection.extend({
		url: app.api + 'acctg-deposit-payments'
	});

}(window.App, window._));