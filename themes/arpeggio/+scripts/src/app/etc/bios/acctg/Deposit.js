;(function (app) {

	app.acctg.Deposit.bootup = function (conf) {
		console.log('bootup: acctg.Deposit');
		var Deposit = app.acctg.Deposit;

		var $form = app.$(conf.form);
		var $preview = app.$(conf.preview);
		var bootup = function () {
			var dm = new Deposit.Model({
				date: app.moment().format('YYYY-MM-DD'),
				amount_value: 0.00,
				amount_type: 'USD'
			});

			dm.on('out:entry', function (payload) {
				// @todo generate preview
				console.log('PREVIEW', payload);
				$preview.append('<div class="alert alert-success">Succesfully recorded deposit under transaction #'+payload['id']+'</div>');
			});

			var dv = new Deposit.Model.View({ model: dm });

			$form.html('');
			$form.append(dv.render().el);

			dm.on('reboot', function () {
				dv.remove();
				bootup();
			});
		};

		bootup();

	};

	$(function () {

		app.acctg.Deposit.bootup({
			form: '.app-procedures-Deposit-form',
			preview: '.app-procedures-Deposit-preview'
		});

	});

}(window.App));
