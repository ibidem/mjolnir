<?
	namespace app;

	/* @var $context Controller_AcctgReports */
	/* @var $control Controller_AcctgReports */
	/* @var $errors  array */
	/* @var $theme   ThemeView */
	/* @var $lang    Lang */

	$h1 = HH::raise($h);
?>

<<?= $h1 ?>>Reports</<?= $h1 ?>>

<hr/>

<table class="table">

	<thead>
		<tr>
			<th colspan="2">Financial Statements</th>
		</tr>
	</thead>

	<tbody>
		<? foreach ($context->financial_statements() as $report): ?>
			<tr>
				<td>
					<a href="<?= \app\URL::href($report['relay']) ?>">
						<?= $report['title'] ?>
					</a>
				</td>
				<td><?= $report['description'] ?></td>
			</tr>
		<? endforeach; ?>
	</tbody>

	<thead>
		<tr>
			<th colspan="2">Analysis Reports</th>
		</tr>
	</thead>

	<tbody>
		<? foreach ($context->analysis_reports() as $report): ?>
			<tr>
				<td>
					<a href="<?= \app\URL::href($report['relay']) ?>">
						<?= $report['title'] ?>
					</a>
				</td>
				<td><?= $report['description'] ?></td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>