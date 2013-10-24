<?
	namespace app;

	/* @var $theme ThemeView */
	/* @var $lang  Lang */

	$h1 = HH::raise($h);
?>

<<?= $h1 ?>>Assets</<?= $h1 ?>>

<hr/>

<table class="table">
	<thead>
		<tr>
			<th>Asset Category</th>
			<th>Description</th>
		</tr>
	</thead>
	<tbody>
		<? foreach ($context->assets() as $asset): ?>
			<tr>
				<td>
					<a href="<?= \app\URL::href($asset['relay']) ?>">
						<?= $asset['title'] ?>
					</a>
				</td>
				<td><?= $asset['description'] ?></td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>