;(function (app, _) {

	var ns  = '.app-report-',
		ens = '.acctg_Report';

////////////////////////////////////////////////////////////////////////////////

	app.acctg.Report.Model = app.Model.extend({
		// empty
	});

////////////////////////////////////////////////////////////////////////////////

	app.acctg.Report.Model.View = app.View.extend({

		options: {
			// window manager
			windows: app.windows
		},

		// -- Rendering -------------------------------------------------------

		render: function () {
			var self = this;
			console.log('render: acctg.Report.Model');
			self.setupcontrols();
			return self;
		},

		setupcontrols: function () {
			var self = this;
			// empty
		}

	});

}(window.App, window._));
