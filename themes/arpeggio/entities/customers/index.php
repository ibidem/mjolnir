<?
	namespace app;

	/* @var $theme ThemeView */
	/* @var $lang  Lang */

	$h1 = HH::raise($h);
?>

<<?= $h1 ?>>Customers</<?= $h1 ?>>

<hr/>

<table class="table">
	<thead>
		<tr>
			<th>title</th>
		</tr>
	</thead>
	<tbody>
		<? foreach ($context->customers() as $vendor): ?>
			<tr>
				<td><?= $vendor['title'] ?></td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>
