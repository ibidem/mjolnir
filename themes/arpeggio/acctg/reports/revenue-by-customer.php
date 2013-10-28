<?
	namespace app;

	/* @var $context Controller_AcctgReports_RevenueByCustomer */
	/* @var $control Controller_AcctgReports_RevenueByCustomer */
	/* @var $errors  array */
	/* @var $theme   ThemeView */
	/* @var $lang    Lang */

	echo '[disabled]'; return;

	$report = $context->acctgreport_revenuebycustomer($_GET);
?>

<?= $theme->partial('acctg/reports/base/template')
	->pass('report', $report)
	->pass('h', $h)
	->render() ?>
