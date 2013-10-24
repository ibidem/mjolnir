<?
	namespace app;

	/* @var $context Controller_AcctgProcedures_Invoice */
	/* @var $control Controller_AcctgProcedures_Invoice */
	/* @var $errors  array */
	/* @var $theme   ThemeView */
	/* @var $lang    Lang */

	$h1 = HH::raise($h);
?>

<<?= $h1 ?>>Record Invoice</<?= $h1 ?>>

<hr/>

<div class="app-procedures-Invoice-preview">
	<!-- js context -->
</div>

<div class="app-procedures-Invoice-form">
	<em>Loading, please wait...</em>
	<!-- js context -->
</div>

<?= $theme->partial('template-loader')
	->render(); ?>
