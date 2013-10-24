;(function (app) {

	app.acctg.Transaction.bootup = function (conf) {
		console.log('bootup: acctg.Transaction');
		var Transaction = app.acctg.Transaction;

		var $form = app.$(conf.form);
		var $preview = app.$(conf.preview);
		var bootup = function () {
			var tm = new Transaction.Model({
				date: app.moment().format('YYYY-MM-DD'),
				description: ''
			});

			tm.on('out:entry', function (payload) {
				// @todo generate preview
				console.log('PREVIEW', payload);
				$preview.append('<div class="alert alert-success">Succesfully recorded transaction #'+payload['id']+'</div>');
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

	};

	$(function () {

		app.acctg.Transaction.bootup({
			preview: '.app-acctg-Transaction-preview',
			form: '.app-acctg-Transaction-form'
		});

	});


}(window.App));
