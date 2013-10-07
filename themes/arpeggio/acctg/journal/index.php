<?
	namespace app;

	/* @var $context Controller_Journals */
	/* @var $control Controller_Journals */
	/* @var $errors  array */
	/* @var $theme   ThemeView */
	/* @var $lang    Lang */

	$h1 = HH::raise($h);
?>

<<?= $h1 ?>>Journals</<?= $h1 ?>>

<hr/>

<table class="table">
	<thead>
		<tr>
			<th>#</th>
			<th>title</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<? $journals = $context->acctgjournals() ?>
		<? if ( ! empty($journals)): ?>
			<? foreach ($journals as $journal): ?>
				<tr>
					<td><?= $journal['id'] ?></td>
					<td>
						<strong>
							<a href="<?= $journal['action'](null) ?>">
								<?= $journal['title'] ?>
							</a>
						</strong>
					</td>
					<td>

						<? if ($journal['can']('edit')): ?>
							<a class="btn btn-default" href="<?= $journal['action']('edit') ?>">
								Edit
							</a>
						<? endif; ?>

						<? if ($journal['can']('remove')): ?>
							<?= $f = HTML::form($journal['action']('delete'), 'mjolnir:inline') ?>
							<?= $f->hidden('id')->value_is($journal['id']) ?>
							<button class="btn btn-warning" type="submit" <?= $f->mark() ?>>
								Remove
							</button>
						<? endif; ?>

					</td>
				</tr>
			<? endforeach; ?>
		<? else: # empty journals ?>
			<tr><td colspan="5"><em>No Journals available.</em></td></tr>
		<? endif; ?>
	</tbody>
</table>
