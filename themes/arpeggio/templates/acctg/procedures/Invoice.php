<?
	namespace app;

	/* @var $theme ThemeView */
	/* @var $lang  Lang */

	$twbs3 = HTML::formfield('mjolnir:twbs3');
?>

<div class="form-horizontal">

	<?= $twbs3->date('Date', 'date')
		->add('class', 'app-invoice-date')
		->value_is(\date('Y-m-d')); ?>

	<?= $twbs3->date('Due Date', 'duedate')
		->add('class', 'app-invoice-duedate')
		->value_is($context->default_duedate()->format('Y-m-d')); ?>

	<?= $twbs3->textarea('Description', 'description')
		->add('class', 'app-invoice-description')
		->set('placeholder', 'Details on the invoice...') ?>

	<?= $twbs3->currency('Total Amount', 'amount')
		->add('class', 'app-invoice-amount')
		->set('disabled', 'disabled')
		->value_is('0.00') ?>

	<table class="table">
		<thead>
			<tr>
				<th>description</th>
				<th>quantity</th>
				<th>amount</th>
				<th>total</th>
				<th>note</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody class="app-expenses">
			<!-- js context -->
		</tbody>
		<tbody>
			<tr>
				<td colspan="5">
					<button class="app-add-invoice-expense btn btn-large btn-default">
						Add Expense
					</button>
				</td>
			</tr>
		</tbody>
	</table>

	<table class="table">
		<thead>
			<tr>
				<th>account</th>
				<th>amount</th>
				<th>note</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody class="app-payments">
			<!-- js context -->
		</tbody>
		<tbody>
			<tr>
				<td colspan="5">
					<button class="app-add-invoice-payment btn btn-large btn-default">
						Add Payment
					</button>
				</td>
			</tr>
		</tbody>
	</table>

	<div class="form-actions">
		<hr/>
		<button class="app-save-invoice btn btn-primary" disabled>
			Record
		</button>
		&nbsp;
		<span class="app-invoice-integrity-error">
			<!-- js context -->
		</span>
	</div>

</div>
