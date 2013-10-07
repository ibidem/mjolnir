;(function (app) {

	app.acctg.Transaction.bootup = function (conf) {
		console.log('bootup: acctg.Transaction.Model');
		var Transaction = app.acctg.Transaction;

		var $form = app.$(conf.form);

		if ($form.length != 0) {
			var bootup = function () {
				var tm = new Transaction.Model({
					date: app.moment().format('YYYY-MM-DD'),
					description: ''
				});

				tm.on('out:entry', function (payload) {
					// @todo generate preview
					console.log('PREVIEW', payload);
				});

				var tv = new Transaction.Model.View({ model: tm });

				$form.html('');
				$form.append(tv.render().el);

				tm.on('reboot', function () {
					tv.remove();
					bootup();
				});
			};

			bootup();
		}
		else { // element not found
			console.log('skipped: acctg.Transaction form rendering')
		}
	};

}(window.App));
