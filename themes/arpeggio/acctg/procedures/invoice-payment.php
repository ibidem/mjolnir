<?
	namespace app;

	/* @var $context Controller_AcctgProcedures_Invoice */
	/* @var $control Controller_AcctgProcedures_Invoice */
	/* @var $errors  array */
	/* @var $theme   ThemeView */
	/* @var $lang    Lang */

	$h1 = HH::raise($h);
?>

<<?= $h1 ?>>Record Invoice Payment</<?= $h1 ?>>

<hr/>

<?= $f = HTML::form($control->action('record'), 'mjolnir:twbs3') ?>

<div class="form-horizontal">

	<?= $f->date('Date', 'date')
		->value_is(\date('Y-m-d')) ?>

	<?= $f->hidden('amount_type')
		->value_is('USD') ?>

	<?= $f->currency('Amount', 'amount_value')
		->value_is('0.00') ?>

	<?= $f->select('TAccount', 'taccount')
		->add('class', 'app-taccount')
		->add('class', 'form-control')
		->options_logical($context->acctgtaccounts_options_liefs(['entry.type' => $context->acctgtype('assets')])) ?>

	<?= $f->select('Invoice', 'invoice')
		->options_array($context->invoices())
		->render() ?>

	<?= $f->text('Note', 'note')
		->set('placeholder', 'Details on payment') ?>

	<div class="form-actions">
		<hr/>
		<button class="btn btn-primary" <?= $f->mark() ?>>
			Record
		</button>
	</div>

</div>
