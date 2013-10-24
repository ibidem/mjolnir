<?
	namespace app;

	/* @var $context Controller_AcctgReports_BalanceSheet */
	/* @var $control Controller_AcctgReports_BalanceSheet */
	/* @var $errors  array */
	/* @var $theme   ThemeView */
	/* @var $lang    Lang */

	$report = $context->acctgreport_balancesheet($_GET);
?>

<?= $theme->partial('acctg/reports/base/template')
	->pass('report', $report)
	->pass('h', $h)
	->render() ?>
