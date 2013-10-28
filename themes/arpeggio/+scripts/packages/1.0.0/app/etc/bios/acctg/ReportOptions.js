;(function (app) {

	app.acctg.ReportOptions.bootup = function (conf) {
		console.log('bootup: acctg.ReportOptions');
		var ReportOptions = app.acctg.ReportOptions;

		var $view = app.$(conf.el);
		var bootup = function () {
			var rom = new ReportOptions.Model(),
			    rov = new ReportOptions.Model.View({ model: rom });

			$view.html('');
			$view.append(rov.render().el);

			rom.on('reboot', function () {
				rov.remove();
				bootup();
			});
		};

		bootup();
	};

	$(function () {

		app.acctg.ReportOptions.bootup({
			el: '.app-reports-Report-Options'
		});

	});

}(window.App));
