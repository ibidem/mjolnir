<?
	namespace app;

	/* @var $theme ThemeView */
	/* @var $lang  Lang */

	$twbs = HTML::formfield('mjolnir:twbs3');
	$line = HTML::formfield('mjolnir:inline');
?>

<div class="form-horizontal" data-journal-id="<?= $context->journal_id() ?>">

	<?= $twbs->textarea('Description', 'description')
		->add('class', 'app-transaction-description') ?>

	<?= $twbs->date('Date', 'date')
		->add('class', 'app-transaction-date')
		->value_is(\date('Y-m-d')) ?>

	<table class="table">
		<thead>
			<tr>
				<th>account</th>
				<th>debit</th>
				<th>credit</th>
				<th>note</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody class="app-operations">
			<!-- js context -->
		</tbody>
		<tbody>
			<tr>
				<td colspan="5">
					<button class="app-add-operation btn btn-large btn-default">
						Add Operation
					</button>
				</td>
			</tr>
		</tbody>
	</table>

	<div class="form-actions">
		<hr/>
		<button class="app-save-transaction btn btn-primary" disabled>
			Record
		</button>
		&nbsp;
		<span class="app-transaction-integrity-error">
			<!-- js context -->
		</span>
	</div>

</div>
