;(function (app) {

	app.acctg.Invoice.bootup = function (conf) {
		console.log('bootup: acctg.Invoice');
		var Invoice = app.acctg.Invoice;

		var $form = app.$(conf.form);
		var $preview = app.$(conf.preview);
		var bootup = function () {
			var im = new Invoice.Model({
				date: app.moment().format('YYYY-MM-DD'),
				duedate: app.moment().add('days', 30).format('YYYY-MM-DD'),
				description: '',
				expenses: [],
				payments: []
			});

			im.on('out:entry', function (payload) {
				// @todo generate preview
				console.log('PREVIEW', payload);
				$preview.append('<div class="alert alert-success">Succesfully recorded invoice under transaction #'+payload['id']+'</div>');
			});

			var iv = new Invoice.Model.View({ model: im });

			$form.html('');
			$form.append(iv.render().el);

			im.on('reboot', function () {
				iv.remove();
				bootup();
			});
		};

		bootup();

	};

	$(function () {

		app.acctg.Invoice.bootup({
			form: '.app-procedures-Invoice-form',
			preview: '.app-procedures-Invoice-preview'
		});

	});

}(window.App));
