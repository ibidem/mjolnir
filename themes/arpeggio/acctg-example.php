<?
	namespace app;
?>

<h1>accountinginfo</h1>

<h2>TAccount Types</h2>

	<table>
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

<h2>TAccounts</h2>

<h3>Add TAccount</h3>

	<?= $f = HTML::form($control->action('add-taccount'), 'mjolnir:twitter') ?>

	<?= $f->select('TAccount Type', 'type')
		->optgroups_array($context->acctgtypes_optgroups()) ?>

	<?= $f->text('Title', 'title') ?>
	<?= $f->text('Nested Set Left Index', 'lft') ?>
	<?= $f->text('Nested Set Right Index', 'rgt') ?>

	<button class="btn" type="submit" <?= $f->mark() ?>>
		Create TAccount
	</button>

<h3>Raw TAccount View</h3>

	<table>
		<thead>
			<tr>
				<th>#</th>
				<th>type</th>
				<th>account</th>
				<th>lft</th>
				<th>rgt</th>
				<th>depth</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<? $taccounts = $context->acctgtaccounts() ?>
			<? if ( ! empty($taccounts)): ?>
				<? $typesmap = $context->acctgtypesmap(); ?>
				<? foreach ($context->acctgtaccounts() as $taccount): ?>
					<tr>
						<td><?= $taccount['id'] ?></td>
						<td><?= $typesmap[$taccount['type']]['title'] ?></td>
						<td><?= $taccount['title'] ?></td>
						<td><?= $taccount['lft'] ?></td>
						<td><?= $taccount['rgt'] ?></td>
						<td><?= $taccount['depth'] ?></td>
						<td>
							<? if (Access::can('taccount.public', ['action' => 'delete'])): ?>
								<?= $f = HTML::form($taccount['action']('delete'), 'mjolnir:inline') ?>
								<?= $f->hidden('id')->value_is($taccount['id']) ?>
								<button type="submit" <?= $f->mark() ?>>
									Delete
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

<h3>Hierarchical Listing</h3>

	<?
	#
	# It should be noted that true hierarchies aren't always necesary if you
	# just need the accounts to show indented in you would just multiply a
	# padding or &nbsp; by the depth to obtain the desired effect.
	#
	# For all the other cases where you nead true hierarchies...
	#
	?>

	<? function ibidem_theme_taccount_li($entry) { ?>
		<li>
			<strong><?= $entry['title'] ?></strong>
			<? var_dump($entry); die ?>
			<? foreach ($entry['subtaccounts'] as $taccount): ?>
				<? ibidem_theme_taccount_li($taccount) ?>
			<? endforeach; ?>
		</li>
	<? } # endfunction ?>

	<? foreach ($context->acctgtaccounts_hierarchy() as $taccount): ?>
		<? ibidem_theme_taccount_li($taccount) ?>
	<? endforeach; ?>
