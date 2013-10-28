;(function (app, _) {

	var ens = '.acctg_TransactionOperation';

////////////////////////////////////////////////////////////////////////////////

	app.acctg.TransactionOperation.Collection = app.Collection.extend({
		url: app.api + 'acctg-transaction-operations'
	});

}(window.App, window._));