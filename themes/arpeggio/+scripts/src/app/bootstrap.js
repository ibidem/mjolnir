window.IbidemDemosAcctg = {};
window.App = window.IbidemDemosAcctg; // alias

;(function (app, Backbone, $, mj, mjb, pusher, moment, _) {

	// setup jQuery
	app.$ = Backbone.$ = $;

	// name
	app.name = 'IbidemDemosAcctg';
	app.shortname = 'ida';

	// [E]vent [N]ame[s]pace
	app.ens = '.' + app.name + '.';

	// class namespace
	app.ns = '.' + app.shortname;

	// setup temp rendering
	app.$tmp = mj.$tmp;

	// color manager
	app.pusher = pusher;

	// date manager
	app.moment = moment;

	// setup windows handler object
	app.windows = mj.windows;

	// when_futures
	app.when_futures = mj.when_futures;

	// setup memory
	app.memory = {};

	// setup api root
	app.api = mjb.mjolnir.config.base.urlbase + 'api/v1/';

	// internal formats
	app.formats = {
		date: 'DD.MM.YYYY'
	};

	// update mj formats to use app formats
	mj.formats = $.extend({}, mj.formats, app.formats);

	// singleton function for collections
	app.single = mj.single;

	// setup templating functions
	app.template = mj.template = function (template) {
		try {
			return _.template($('#' + template + '-template').html());
		}
		catch (e) {
			console.log('failed to compile ' + template);
			throw e;
		}
	};

	// extentions
	app.macros = mj.macros;
	app.Router = mj.Router;
	app.View = mj.View;
	app.Model = mj.Model;
	app.Field = mj.Field;
	app.Collection = mj.Collection.extend({model: app.Model});
	app.Loader = mj.Loader;
	app.Exception = mj.Exception;
	app.Instantiatable = mj.Instantiatable;
	app.Renderable = mj.Renderable;
	app.Popover = mj.Popover;

	// misc extentions
	app.Color = mj.Color;
	app.Currency = mj.Currency;
	app.Date = mj.Date;
	app.Select = mj.Select;
	app.Text = mj.Text;

	// namespaces
	app.acctg = {};
	app.acctg.Transaction = {};
	app.acctg.TransactionOperation = {};
	app.acctg.Check = {};
	app.acctg.CheckExpense = {};
	app.acctg.Deposit = {};
	app.acctg.DepositPayment = {};
	app.acctg.Invoice = {};
	app.acctg.InvoicePayment = {};
	app.acctg.InvoiceExpense = {};
	app.acctg.Report = {};
	app.acctg.ReportOptions = {};
}(
	window.App,
	window.Backbone,
	window.jQuery,
	window.Mjolnir,
	window.mjb,
	window.pusher,
	window.moment,
	window._
));
