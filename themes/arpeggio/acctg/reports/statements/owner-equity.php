<?
	namespace app;

	/* @var $context Controller_AcctgReports_IncomeStatement */
	/* @var $control Controller_AcctgReports_IncomeStatement */
	/* @var $errors  array */
	/* @var $theme   ThemeView */
	/* @var $lang    Lang */

	$report = $context->acctgreport_ownerequity($_GET);
?>

<?= $theme->partial('acctg/reports/base/template')
	->pass('report', $report)
	->pass('h', $h)
	->render() ?>
