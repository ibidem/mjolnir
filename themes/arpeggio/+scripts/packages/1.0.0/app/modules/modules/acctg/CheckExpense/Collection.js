;(function (app, _) {

	var ens = '.acctg_CheckExpense';

////////////////////////////////////////////////////////////////////////////////

	app.acctg.CheckExpense.Collection = app.Collection.extend({
		url: app.api + 'acctg-check-expenses'
	});

}(window.App, window._));