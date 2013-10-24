<?
	namespace app;

	/* @var $context Controller_AcctgProcedures */
	/* @var $control Controller_AcctgProcedures */
	/* @var $errors  array */
	/* @var $theme   ThemeView */
	/* @var $lang    Lang */

	$h1 = HH::raise($h);
?>

<<?= $h1 ?>>Procedures</<?= $h1 ?>>

<table class="table">
	<thead>
		<tr>
			<th>Operation</th>
			<th>Description</th>
		</tr>
	</thead>
	<tbody>
		<? foreach ($context->procedures() as $procedure): ?>
			<tr>
				<td>
					<a href="<?= \app\URL::href($procedure['relay']) ?>">
						<?= $procedure['title'] ?>
					</a>
				</td>
				<td><?= $procedure['description'] ?></td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>
