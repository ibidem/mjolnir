<?
	namespace app;

	/* @var $theme ThemeView */
	/* @var $lang  Lang */

	$h1 = HH::raise($h);
?>

<<?= $h1 ?>>Inventory</<?= $h1 ?>>

<hr/>

<table class="table">
	<thead>
		<tr>
			<th>title</th>
		</tr>
	</thead>
	<tbody>
		<? foreach ($context->inventory() as $item): ?>
			<tr>
				<td><?= $item['title'] ?></td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>
