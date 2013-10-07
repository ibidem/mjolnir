<?
	namespace app;

	/* @var $context Controller_TAccounts */
	/* @var $control Controller_TAccounts */
	/* @var $errors  array */
	/* @var $theme   ThemeView */
	/* @var $lang    Lang */

	$h1 = HH::raise($h);
	$h2 = HH::raise($h1);
?>

<div class="row-fluid">

	<div class="col-md-8">
		<<?= $h1 ?>>TAccounts</<?= $h1 ?>>

		<<?= $h2 ?>>Raw TAccount View</<?= $h2 ?>>

		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>type</th>
					<th>account</th>
					<th>lft</th>
					<th>rgt</th>
					<th>depth</th>
					<th>contra acct?</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<? $taccounts = $context->acctgtaccounts() ?>
				<? if ( ! empty($taccounts)): ?>
					<? $typesmap = $context->acctgtypesmap(); ?>
					<? foreach ($taccounts as $taccount): ?>
						<tr>
							<td><?= $taccount['id'] ?></td>
							<td><?= $typesmap[$taccount['type']]['title'] ?></td>
							<td>
								<strong>
									<a href="<?= $taccount['action'](null) ?>">
										<?= $taccount['title'] ?>
									</a>
								</strong>
							</td>
							<td><?= $taccount['lft'] ?></td>
							<td><?= $taccount['rgt'] ?></td>
							<td><?= $taccount['depth'] ?></td>
							<td><?= $taccount['sign'] == -1 ? 'yes' : 'no' ?></td>
							<td>

								<? if ($taccount['can']('edit')): ?>
									<a class="btn btn-default" href="<?= $taccount['action']('edit') ?>">
										Edit
									</a>
								<? endif; ?>

								<? if ($taccount['can']('remove')): ?>
									<?= $f = HTML::form($taccount['action']('remove'), 'mjolnir:inline') ?>
									<?= $f->hidden('id')->value_is($taccount['id']) ?>
									<button type="submit" class="btn btn-warning" <?= $f->mark() ?>>
										Remove
									</button>
								<? endif; ?>

							</td>
						</tr>
					<? endforeach; ?>
				<? else: # empty taccounts ?>
					<tr><td colspan="5"><em>No TAccounts available.</em></td></tr>
				<? endif; ?>
			</tbody>
		</table>

		<<?= $h2 ?>>Hierarchical Listing</<?= $h2 ?>>

		<?
		#
		# It should be noted that true hierarchies aren't always necesary if you
		# just need the accounts to show indented in you would just multiply a
		# padding or &nbsp; by the depth to obtain the desired effect.
		#
		# For all the other cases where you nead true hierarchies...
		#
		?>

		<? function ibidem_theme_taccount_li($taccount) { ?>
			<li>
				<strong>
					<a href="<?= $taccount['action'](null) ?>">
						<?= $taccount['title'] ?>
					</a>
				</strong>
				<? if ( ! empty($taccount['subtaccounts'])): ?>
					<ul>
						<? foreach ($taccount['subtaccounts'] as $taccount): ?>
							<? ibidem_theme_taccount_li($taccount) ?>
						<? endforeach; ?>
					</ul>
				<? endif; ?>
			</li>
		<? } # endfunction ?>

		<ul>
			<? foreach ($context->acctgtaccounts_hierarchy() as $taccount): ?>
				<? ibidem_theme_taccount_li($taccount) ?>
			<? endforeach; ?>
		</ul>

		<<?= $h2 ?>>Leaf TAccounts</<?= $h2 ?>>

		<p>ie. the usable accounts</p>

		<? $leafs = $context->acctgtaccounts_leafs() ?>
		<? if ( ! empty($leafs)): ?>
			<ul>
				<? foreach ($leafs as $leaftaccount): ?>
					<li>
						<a href="<?= $taccount['action'](null) ?>">
							<?= $leaftaccount['title'] ?>
						</a>
					</li>
				<? endforeach; ?>
			</ul>
		<? else: # blank state ?>
			<p><em>No leaf accounts</em></p>
		<? endif; ?>
	</div>

	<div class="col-md-4">

		<<?= $h1 ?>>TAccount Types</<?= $h1 ?>>

		<table class="table">
			<thead>
				<tr>
					<th>type</th>
					<th>count</th>
				</tr>
			</thead>
			<tbody>
				<? foreach ($context->acctgtypes() as $type): ?>
					<tr>
						<th><?= $type['title'] ?></th>
						<td><?= $type['taccountcount'] ?></td>
					</tr>
				<? endforeach; ?>
			</tbody>
		</table>

	</div>

</div>
