<?
	namespace app;

	/* @var $theme ThemeView */
	/* @var $lang  Lang */

	isset($currentpage) or $currentpage = '';
?>

<div class="acctg-report-options">

	<?= $f = HTML::queryform($currentpage, 'mjolnir:inline')
		->autocomplete_array($_GET) ?>

	<?= $f->select('Interval', 'interval')
		->options_array($context->acctg_supporter_reportintervals()) ?>

	<?= $f->date('From', 'from_date')
		->add('class', 'app-form-date') ?>

	<?= $f->date('To', 'to_date')
		->add('class', 'app-to-date') ?>

	<?= $f->select('Breakdown', 'breakdown')
		->options_array($context->acctg_supporter_reportbreakdowns()) ?>

	<button class="btn btn-primary" <?= $f->mark() ?>>
		Generate
	</button>

</div>
