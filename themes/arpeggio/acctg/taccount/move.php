<?
	namespace app;

	/* @var $context Controller_AcctgTAccount */
	/* @var $control Controller_AcctgTAccount */
	/* @var $errors  array */
	/* @var $theme   ThemeView */
	/* @var $lang    Lang */

	$h1 = HH::raise($h);
?>

<<?= $h1 ?>>Move TAccount</<?= $h1 ?>>

<hr/>

<div class="form-horizontal">

	<?= $f = HTML::form($control->action('move'), 'mjolnir:twbs3')
		->errors_are($errors['move'])?>

	<?= $f->select('TAccount', 'taccount')
		->options_logical($context->acctgtaccounts_options_hierarchy(null, null, null, false)) ?>

	<?= $f->select('New Parent TAccount', 'new_parent')
		->options_logical($context->acctgtaccounts_options_hierarchy(null, null, null, '[ no parent account ]')) ?>

	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<button class="btn btn-primary" type="submit" <?= $f->mark() ?>>
				Move TAccount
			</button>
		</div>
	</div>

</div>