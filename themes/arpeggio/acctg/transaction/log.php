<?
	namespace app;

	/* @var $context Controller_TransactionLog */
	/* @var $control Controller_TransactionLog */
	/* @var $errors  array */
	/* @var $theme   ThemeView */
	/* @var $lang    Lang */

	$h1 = HH::raise($h);
	$transaction_method = CFS::config('mjolnir/types/acctg')['transaction-method'];
?>

<<?= $h1 ?>>Transaction Log</<?= $h1 ?>>

<hr/>

<table class="table">
	<thead>
		<tr>
			<th>#</th>
			<th>journal</th>
			<th>method</th>
			<th>user</th>
			<th>timestamp</th>
			<th>description</th>
		</tr>
	</thead>
	<tbody>
		<? foreach ($context->acctgtransactionlog() as $transaction): ?>
			<tr>
				<td>
					<a href="<?= URL::href('acctg-transaction.public', ['id' => $transaction['journal']]) ?>"><!--
						--><?= \sprintf('%010s', $transaction['id']) ?><!--
					--></a>
				</td>
				<td>
					<a href="<?= URL::href('acctg-journal.public', ['id' => $transaction['journal']]) ?>">
						<?= $context->acctgjournal($transaction['journal'])['title'] ?>
					</a>
				</td>
				<td><?= $transaction_method[$transaction['method']] ?></td>
				<td><?= $transaction['user'] === null ? '<i>guest</i>' : '<b>'.$context->user($transaction['user'])['nickname'].'</b>' ?></td>
				<td><?= \date_create($transaction['timestamp'])->format('Y-m-d H:i:s') ?></td>
				<td><?= $transaction['description'] ?></td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>