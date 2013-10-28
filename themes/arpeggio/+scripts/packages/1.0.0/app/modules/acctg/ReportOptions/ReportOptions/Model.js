;(function (app, _) {

	var ns  = '.app-report-options-',
		ens = '.acctg_ReportOptions';

////////////////////////////////////////////////////////////////////////////////

	app.acctg.ReportOptions.Model = app.Model.extend({
		// empty
	});

////////////////////////////////////////////////////////////////////////////////

	app.acctg.ReportOptions.Model.View = app.View.extend({

		options: {
			// window manager
			windows: app.windows
		},

		// -- Rendering -------------------------------------------------------

		template: app.template('acctg-reports-ReportOptions'),

		render: function () {
			var self = this;
			console.log('render: acctg.ReportOptions.Model');
			self.markup(self.template(self));
			self.setupcontrols();
			return self;
		},

		setupcontrols: function () {
			var self = this;
			self.$(ns+'dates')
				.on('click'+ens, function () {
					self.add_expense();
				});
		}

	});

}(window.App, window._));
