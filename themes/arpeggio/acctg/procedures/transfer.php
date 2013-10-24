<?
	namespace app;

	/* @var $context Controller_AcctgProcedures_Transfer */
	/* @var $control Controller_AcctgProcedures_Transfer */
	/* @var $errors  array */
	/* @var $theme   ThemeView */
	/* @var $lang    Lang */

	$h1 = HH::raise($h);
?>

<<?= $h1 ?>>Record Transfer</<?= $h1 ?>>

<hr/>

<?= $f = HTML::form($control->action('record'), 'mjolnir:twbs3') ?>

<div class="form-horizontal">

	<?= $f->date('Date', 'date')
		->value_is(\date('Y-m-d')); ?>

	<?= $f->hidden('amount_type')
		->value_is('USD') ?>

	<?= $f->currency('Amount', 'amount_value')
		->value_is('0.00') ?>

	<?= $f->select('From Account', 'fromaccount')
		->options_liefhierarchy($context->options_bankaccounts())
		->render() ?>

	<?= $f->select('To Account', 'toaccount')
		->options_liefhierarchy($context->options_bankaccounts())
		->render() ?>

	<?= $f->text('Note', 'note')
		->set('placeholder', 'Details on the transfer...') ?>

	<div class="form-actions">
		<hr/>
		<button class="btn btn-primary" <?= $f->mark() ?>>
			Record
		</button>
	</div>

</div>
