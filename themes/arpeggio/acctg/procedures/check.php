<?
	namespace app;

	/* @var $context Controller_AcctgProcedures_Check */
	/* @var $control Controller_AcctgProcedures_Check */
	/* @var $errors  array */
	/* @var $theme   ThemeView */
	/* @var $lang    Lang */

	$h1 = HH::raise($h);

	$twbs3 = HTML::formfield('mjolnir:twbs3');
?>

<<?= $h1 ?>>Record Check</<?= $h1 ?>>

<hr/>

<div class="app-procedures-Check-preview">
	<!-- js context -->
</div>

<div class="app-procedures-Check-form">
	<em>Loading, please wait...</em>
	<!-- js context -->
</div>

<?= $theme->partial('template-loader')
	->render(); ?>