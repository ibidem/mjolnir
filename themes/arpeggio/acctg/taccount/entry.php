<?
	namespace app;

	/* @var $context Controller_AcctgTAccount */
	/* @var $control Controller_AcctgTAccount */
	/* @var $errors  array */
	/* @var $theme   ThemeView */
	/* @var $lang    Lang */

	$h1 = HH::raise($h);

	// store entry for easier displaying
	$entry = $context->entry();
?>

<<?= $h1 ?>>TAccount #<?= $entry['id'] ?> "<?= $entry['title'] ?>"</<?= $h1 ?>>

<hr/>

[placeholder entry view]

<hr/>
<small><a href="<?= \app\URL::href('frontend.public') ?>">Back to Index</a></small>


