<?
	namespace app;

	/* @var $theme ThemeView */
	/* @var $lang  Lang */

	$twbs3 = HTML::formfield('mjolnir:twbs3');
?>

<div class="form-horizontal">

	<?= $twbs3->select('Bank Account', 'bankaccount')
		->add('class', 'app-check-taccount')
		->options_logical($context->options_bankaccounts()) ?>

	<?= $twbs3->date('Date', 'date')
		->add('class', 'app-check-date')
		->value_is(\date('Y-m-d')); ?>

	<?= $twbs3->text('Pay the order of', 'orderof')
		->add('class', 'app-check-orderof')
		->set('placeholder', 'Who the check is addressed to...') ?>

	<?= $twbs3->currency('Amount', 'amount')
		->add('class', 'app-check-amount')
		->value_is('0.00') ?>

	<?= $twbs3->textarea('Description', 'description')
		->add('class', 'app-check-description')
		->value_is('') ?>

	<table class="table">
		<thead>
			<tr>
				<th>account</th>
				<th>amount</th>
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
					<button class="app-add-check-expense btn btn-large btn-default">
						Add Expense
					</button>
				</td>
			</tr>
		</tbody>
	</table>

	<div class="form-actions">
		<hr/>
		<button class="app-save-check btn btn-primary" disabled>
			Record
		</button>
		&nbsp;
		<span class="app-check-integrity-error">
			<!-- js context -->
		</span>
	</div>

</div>
