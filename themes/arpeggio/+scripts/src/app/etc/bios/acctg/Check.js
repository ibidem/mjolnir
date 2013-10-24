;(function (app) {

	app.acctg.Check.bootup = function (conf) {
		console.log('bootup: acctg.Check');
		var Check = app.acctg.Check;

		var $form = app.$(conf.form);
		var $preview = app.$(conf.preview);
		var bootup = function () {
			var cm = new Check.Model({
				date: app.moment().format('YYYY-MM-DD'),
				amount_value: 0.00,
				amount_type: 'USD'
			});

			cm.on('out:entry', function (payload) {
				// @todo generate preview
				console.log('PREVIEW', payload);
				$preview.append('<div class="alert alert-success">Succesfully recorded check under transaction #'+payload['id']+'</div>');
			});

			var cv = new Check.Model.View({ model: cm });

			$form.html('');
			$form.append(cv.render().el);

			cm.on('reboot', function () {
				cv.remove();
				bootup();
			});
		};

		bootup();

	};

	$(function () {

		app.acctg.Check.bootup({
			form: '.app-procedures-Check-form',
			preview: '.app-procedures-Check-preview'
		});

	});

}(window.App));
