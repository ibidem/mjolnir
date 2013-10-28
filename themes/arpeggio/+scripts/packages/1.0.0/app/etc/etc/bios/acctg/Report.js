;(function (app) {

	app.acctg.Report.bootup = function (conf) {
		console.log('bootup: acctg.Report');
		var Report = app.acctg.Report;
		var bootup = function () {
			var bsm = new Report.Model(),
			    bsv = new Report.Model.View({
					model: bsm,
					el: conf.el
				});

			bsv.render();

			bsm.on('reboot', function () {
				bsv.remove();
				bootup();
			});
		};

		bootup();

	};

	$(function () {

		app.acctg.Report.bootup({
			el: '.app-reports-Report'
		});

	});

}(window.App));
