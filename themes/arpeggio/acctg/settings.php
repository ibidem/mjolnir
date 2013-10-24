<?
	namespace app;

	/* @var $context Controller_AcctgSettings */
	/* @var $control Controller_AcctgSettings */
	/* @var $errors  array */
	/* @var $theme   ThemeView */
	/* @var $lang    Lang */

	$h1 = HH::raise($h);
	$h2 = HH::raise($h1);

	$current_values = array
		(
			'invoice_recievables' => $context->invoice_recievables_account(),
			'invoice_revenue' => $context->invoice_revenue_account()
		);
?>

<<?= $h1 ?>>Accounting Settings</<?= $h1 ?>>

<hr/>

<?= $f = HTML::form($control->action('save'), 'mjolnir:twbs3')
	->errors_are($errors[$context->actionkey()])
	->autocomplete_array($current_values) ?>

<div class="form-horizontal">

	<<?= $h2 ?>>Invoices</<?= $h2 ?>>

	<?= $f->select('Recievables Account', 'invoice_recievables')
		->options_logical($context->options_current_assets())
		->hint('The assets account where to place funds.') ?>

	<?= $f->select('Liabilities Account', 'invoice_revenue')
		->options_logical($context->options_revenue())
		->hint('The revenue account where to record the operation.') ?>

	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<button class="btn btn-primary" type="submit" <?= $f->mark() ?>>
				Save Settings
			</button>
		</div>
	</div>

</div>
