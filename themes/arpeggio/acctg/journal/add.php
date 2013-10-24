<?
	namespace app;

	/* @var $context Controller_AcctgJournal */
	/* @var $control Controller_AcctgJournal */
	/* @var $errors  array */
	/* @var $theme   ThemeView */
	/* @var $lang    Lang */

	$h1 = HH::raise($h);
?>

<<?= $h1 ?>>Add Journal</<?= $h1 ?>>

<hr/>

<div class="form-horizontal">

	<?= $f = HTML::form($control->action('add'), 'mjolnir:twbs3')
		->errors_are($errors['add'])?>

	<?= $f->text('Title', 'title') ?>

	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<button class="btn btn-primary" type="submit" <?= $f->mark() ?>>
				Create Journal
			</button>
		</div>
	</div>

</div>

