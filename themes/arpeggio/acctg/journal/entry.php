<?
	namespace app;

	/* @var $context Controller_AcctgJournal */
	/* @var $control Controller_AcctgJournal */
	/* @var $errors  array */
	/* @var $theme   ThemeView */
	/* @var $lang    Lang */

	$h1 = HH::raise($h);

	$journal = $context->entry();
	$records = $context->acctgtransactions_hierarchical($journal['id']);
?>

<<?= $h1 ?>>Journal: <?= $journal['title'] ?></<?= $h1 ?>>

<hr/>

<?= View::instance('mjolnir/accounting/partials/journal-hierarchical-table')
	->pass('context', $context)
	->pass('journal', $journal)
	->pass('records', $records)
	->render() ?>
