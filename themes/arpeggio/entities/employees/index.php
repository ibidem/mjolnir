<?
	namespace app;

	/* @var $theme ThemeView */
	/* @var $lang  Lang */

	$h1 = HH::raise($h);
?>

<<?= $h1 ?>>Employees</<?= $h1 ?>>

<hr/>

<table class="table">
	<thead>
		<tr>
			<th>title</th>
		</tr>
	</thead>
	<tbody>
		<? foreach ($context->employees() as $employee): ?>
			<tr>
				<td><?= $employee['title'] ?></td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>
