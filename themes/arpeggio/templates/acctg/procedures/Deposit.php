<?
	namespace app;

	/* @var $theme ThemeView */
	/* @var $lang  Lang */

	$twbs3 = HTML::formfield('mjolnir:twbs3');
?>

<div class="form-horizontal">

	<?= $twbs3->select('Bank Account', 'bankaccount')
		->add('class', 'app-deposit-taccount')
		->options_logical($context->options_bankaccounts()) ?>

	<?= $twbs3->date('Date', 'date')
		->add('class', 'app-deposit-date')
		->value_is(\date('Y-m-d')); ?>

	<?= $twbs3->text('Description', 'description')
		->add('class', 'app-deposit-description')
		->set('placeholder', 'Details on the deposit...') ?>

	<?= $twbs3->currency('Amount', 'amount')
		->add('class', 'app-deposit-amount')
		->value_is('0.00') ?>

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
					<button class="app-add-deposit-payment btn btn-large btn-default">
						Add Payment
					</button>
				</td>
			</tr>
		</tbody>
	</table>

	<div class="form-actions">
		<hr/>
		<button class="app-save-deposit btn btn-primary" disabled>
			Record
		</button>
		&nbsp;
		<span class="app-deposit-integrity-error">
			<!-- js context -->
		</span>
	</div>

</div>
