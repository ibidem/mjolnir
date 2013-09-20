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

<h2>Select Box Rendering</h2>

<?= HTML::formfield('mjolnir:twitter')->select('TAccount Type', 'example')
	->optgroups_array($context->acctgtypes_optgroups()) ?>

<h2>TAccounts</h2>

<h3>Raw TAccount View</h3>

<table>
	<thead>
		<tr>
			<th>#</th>
			<th>type</th>
			<th>account</th>
			<th>lft</th>
			<th>rgt</th>
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
				</tr>
			<? endforeach; ?>
		<? else: # empty taccounts ?>
			<tr><td colspan="5"><em>No TAccounts available.</em></td></tr>
		<? endif; ?>
	</tbody>
</table>

<h3>Add TAccount</h3>

<?= $f = HTML::form($control->action('add-taccount'), 'mjolnir:twitter') ?>

<?= $f->select('TAccount Type', 'type')
	->optgroups_array($context->acctgtypes_optgroups()) ?>

<?= $f->text('Title', 'title') ?>

<button class="btn" type="submit" <?= $f->mark() ?>>
	Create TAccount
</button>
