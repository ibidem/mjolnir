<?
	namespace app;

	/* @var $context Controller_AcctgReports_ExpensesByVendor */
	/* @var $control Controller_AcctgReports_ExpensesByVendor */
	/* @var $errors  array */
	/* @var $theme   ThemeView */
	/* @var $lang    Lang */

	echo '[placeholder]'; return;

	$report = $context->acctgreport_expensebyvendor($_GET);
?>

<?= $theme->partial('acctg/reports/base/template')
	->pass('report', $report)
	->pass('h', $h)
	->render() ?>
