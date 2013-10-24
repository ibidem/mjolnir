<?
	namespace app;

	/* @var $report  \mjolnir\accounting\AcctgReportInterface */
	/* @var $errors  array */
	/* @var $theme   ThemeView */
	/* @var $lang    Lang */

	$h1 = HH::raise($h);
?>

<? if ($report->validator()->check()): ?>

	<?
		$report->run(); # generate the report
		$time = $report->timestamp();
	?>

	<<?= $h1 ?>><?= $report->title() ?></<?= $h1 ?>>
	<p><small>Generated <?= \date('M d, Y', $time).' at '.\date('H:i:s', $time) ?></small></p>
	<hr/>

	<div class="app-reports-Report">
		<?= $report->render() ?>
		<!-- js context -->
	</div>

<? else: # errors ?>

	<p>
		The options you have selected for the report can not be used to
		generate the report at this time. Please choose different options.
	</p>

<? endif; ?>

<hr/>

<div class="app-reports-Report-Options">
	Loading, please wait...
	<!-- js context -->
</div>

<?= $theme->partial('template-loader')
	->render(); ?>
