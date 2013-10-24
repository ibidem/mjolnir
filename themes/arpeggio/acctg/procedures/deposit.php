<?
	namespace app;

	/* @var $context Controller_AcctgProcedures_Deposit */
	/* @var $control Controller_AcctgProcedures_Deposit */
	/* @var $errors  array */
	/* @var $theme   ThemeView */
	/* @var $lang    Lang */

	$h1 = HH::raise($h);
?>

<<?= $h1 ?>>Record Deposit</<?= $h1 ?>>

<hr/>

<div class="app-procedures-Deposit-preview">
	<!-- js context -->
</div>

<div class="app-procedures-Deposit-form">
	<em>Loading, please wait...</em>
	<!-- js context -->
</div>

<?= $theme->partial('template-loader')
	->render(); ?>
