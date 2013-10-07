<?
	namespace app;

	/* @var $context Controller_Journal */
	/* @var $control Controller_Journal */
	/* @var $errors  array */
	/* @var $theme   ThemeView */
	/* @var $lang    Lang */

	$h1 = HH::raise($h);

	$entry = $context->entry();
?>

<<?= $h1 ?>>Update Journal #<?= $entry['id'] ?> "<?= $entry['title'] ?>"</<?= $h1 ?>>

<hr/>

<div class="form-horizontal">

	<?= $f = HTML::form($control->action('edit'), 'mjolnir:twbs3')
		->autocomplete($entry)
		->errors_are($errors['edit']) ?>

	<?= $f->text('Title', 'title'); ?>

	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<button class="btn btn-primary" type="submit" <?= $f->mark() ?>>
				Update
			</button>
		</div>
	</div>

</div>
