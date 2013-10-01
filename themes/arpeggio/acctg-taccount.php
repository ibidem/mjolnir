<?
	namespace app;

	/* @var $context Controller_Frontend */
	/* @var $control Controller_Frontend */
	/* @var $errors  array */

	// store entry for easier displaying
	$entry = $context->entry();
?>

<h1>TAccount #<?= $entry['id'] ?> "<?= $entry['title'] ?>"</h1>

<?= $f = HTML::form($control->action('update'), 'mjolnir:twitter')
	->autocomplete($entry)
	->errors_are($errors['update']) ?>

<?= $f->text('Title', 'title'); ?>

<button type="submit" <?= $f->mark() ?>>
	Update
</button>

<hr/>
<small><a href="<?= \app\URL::href('frontend.public') ?>">Back to Index</a></small>
