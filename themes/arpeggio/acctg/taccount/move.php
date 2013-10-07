<?
	namespace app;

	/* @var $context Controller_TAccount */
	/* @var $control Controller_TAccount */
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
		->options_logical($context->acctgtaccounts_options_hierarchy(null, null, null, '- select account -')) ?>

	<?= $f->select('New Parent TAccount', 'new_parent')
		->options_logical($context->acctgtaccounts_options_hierarchy()) ?>

	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<button class="btn btn-primary" type="submit" <?= $f->mark() ?>>
				Move TAccount
			</button>
		</div>
	</div>

</div>