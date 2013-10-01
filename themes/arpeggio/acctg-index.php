<?
	namespace app;

	/* @var $context Controller_Frontend */
	/* @var $control Controller_Frontend */
	/* @var $errors  array */
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

	<?= $f = HTML::form($control->action('add-taccount'), 'mjolnir:twitter')
		->errors_are($errors['add-taccount'])?>

	<?= $f->select('TAccount Type', 'type')
		->optgroups_array($context->acctgtypes_optgroups()) ?>

	<?= $f->select('Parent TAccount', 'parent')
		->options_logical($context->acctgtaccounts_options_hierarchy())
		->render() ?>

	<?= $f->checkbox('Contra TAccount?', 'sign')
		->value_is(-1)
		->unchecked() ?>

	<?= $f->text('Title', 'title') ?>

	<button class="btn" type="submit" <?= $f->mark() ?>>
		Create TAccount
	</button>

<h3>Move TAccount</h3>

	<?= $f = HTML::form($control->action('move-taccount'), 'mjolnir:twitter')
		->errors_are($errors['move-taccount'])?>

	<?= $f->select('TAccount', 'taccount')
		->options_logical($context->acctgtaccounts_options_hierarchy(null, null, null, '- select account -')) ?>

	<?= $f->select('New Parent TAccount', 'new_parent')
		->options_logical($context->acctgtaccounts_options_hierarchy())
		->render() ?>

	<button class="btn" type="submit" <?= $f->mark() ?>>
		Move TAccount
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
				<th>contra acct?</th>
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
						<td><strong><?= $taccount['title'] ?></strong></td>
						<td><?= $taccount['lft'] ?></td>
						<td><?= $taccount['rgt'] ?></td>
						<td><?= $taccount['depth'] ?></td>
						<td><?= $taccount['sign'] == -1 ? 'yes' : 'no' ?></td>
						<td>

							<? if ($taccount['can']('update')): ?>
								<a class="btn" href="<?= $taccount['action']('update') ?>">
									Update
								</a>
							<? endif; ?>

							<? if ($taccount['can']('remove')): ?>
								<?= $f = HTML::form($taccount['action']('remove'), 'mjolnir:inline') ?>
								<?= $f->hidden('id')->value_is($taccount['id']) ?>
								<button type="submit" <?= $f->mark() ?>>
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
			<? if ( ! empty($entry['subtaccounts'])): ?>
				<ul>
					<? foreach ($entry['subtaccounts'] as $taccount): ?>
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

<h3>Leaf TAccounts</h3>

	<p>ie. the usable accounts</p>

	<? $leafs = $context->acctgtaccounts_leafs() ?>
	<? if ( ! empty($leafs)): ?>
		<ul>
			<? foreach ($leafs as $leaftaccount): ?>
				<li><?= $leaftaccount['title'] ?></li>
			<? endforeach; ?>
		</ul>
	<? else: # blank state ?>
		<p><em>No leaf accounts</em></p>
	<? endif; ?>
