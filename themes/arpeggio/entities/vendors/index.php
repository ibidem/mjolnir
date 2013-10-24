<?
	namespace app;

	/* @var $theme ThemeView */
	/* @var $lang  Lang */

	$h1 = HH::raise($h);
?>

<<?= $h1 ?>>Vendors</<?= $h1 ?>>

<hr/>

<table class="table">
	<thead>
		<tr>
			<th>title</th>
		</tr>
	</thead>
	<tbody>
		<? foreach ($context->vendors() as $vendor): ?>
			<tr>
				<td><?= $vendor['title'] ?></td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>
