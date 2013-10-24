<?
	namespace app;

	/* @var $context Controller_AcctgTAccount */
	/* @var $control Controller_AcctgTAccount */
	/* @var $errors  array */
	/* @var $theme   ThemeView */
	/* @var $lang    Lang */

	$h1 = HH::raise($h);
?>

<<?= $h1 ?>>Add TAccount</<?= $h1 ?>>

<hr/>

<div class="form-horizontal">

	<?= $f = HTML::form($control->action('add'), 'mjolnir:twbs3')
		->errors_are($errors['add']) ?>

	<?= $f->select('TAccount Type', 'type')
		->options_logical($context->acctgtypes_options_hierarchy())
		->render() ?>

	<?= $f->select('Parent TAccount', 'parent')
		->options_logical($context->acctgtaccounts_options_hierarchy(null, null, null, '[ no parent account ]'))
		->render() ?>

	<?= $f->checkbox('Contra TAccount?', 'sign')
		->value_is(-1)
		->unchecked() ?>

	<?= $f->text('Title', 'title') ?>

	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<button class="btn btn-primary" type="submit" <?= $f->mark() ?>>
				Create TAccount
			</button>
		</div>
	</div>

</div>