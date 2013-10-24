<?
	namespace app;

	/* @var $context Controller_AcctgTransaction */
	/* @var $control Controller_AcctgTransaction */
	/* @var $errors  array */
	/* @var $theme   ThemeView */
	/* @var $lang    Lang */

	$extratemplates = array
		(
			'app-acctg-Transaction-partial'
				=> 'templates/acctg/Transaction-partial',
		);

	$h1 = HH::raise($h);
?>

<<?= $h1 ?>>Add Transactions</<?= $h1 ?>>

<div class="app-acctg-Transaction-preview">
	<!-- js context -->
</div>

<hr/>

<div class="app-acctg-Transaction-form">
	<em>Loading, please wait...</em>
	<!-- js context -->
</div>

<?= $theme->partial('template-loader')
	->pass('extratemplates', $extratemplates)
	->render() ?>
