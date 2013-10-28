<?
	namespace app;

	/* @var $context Controller_AcctgReports_CashFlowStatement */
	/* @var $control Controller_AcctgReports_CashFlowStatement */
	/* @var $errors  array */
	/* @var $theme   ThemeView */
	/* @var $lang    Lang */

	echo '[disabled]'; return;

	$report = $context->acctgreport_cashflowstatement($_GET);
?>

<?= $theme->partial('acctg/reports/base/template')
	->pass('report', $report)
	->pass('h', $h)
	->render() ?>
