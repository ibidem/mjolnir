<?
	namespace app;

	/* @var $context Controller_AcctgTAccounts */
	/* @var $control Controller_AcctgTAccounts */
	/* @var $errors  array */
	/* @var $theme   ThemeView */
	/* @var $lang    Lang */

	$h1 = HH::raise($h);
	$h2 = HH::raise($h1);
?>

<<?= $h1 ?>>TAccounts</<?= $h1 ?>>

<hr/>

<div class="row-fluid">

	<div class="col-md-8">

		<?
		#
		# It should be noted that true hierarchies aren't always necesary if
		# you just need the accounts to show indented in you would just
		# multiply a padding or &nbsp; by the depth to obtain the
		# desired effect.
		#
		# For all the other cases where you just nead true hierarchies...
		#
		?>

		<? function ibidem_theme_taccount_li($entry, $level) { ?>
			<? if ($entry['entrytype'] == 'taccount'): ?>
				<li class="acctg-coa--taccount lvl-<?= $level ?>">
					<span class="acctg-coa--taccount-wrapper">
						<strong class="acctg-coa--taccount-title"><!--
							--><a href="<?= $entry['action'](null) ?>"><!--
								--><?= $entry['title'] ?><!--
							--></a><!--
						--></strong>
						<? if (empty($entry['subentries'])): ?>
							&mdash; <?= \number_format($entry['balance'], 2) ?>
						<? endif; ?>

						<span class="acctg-coa--taccount-controls">

							&nbsp; |

							<? if ($entry['can']('edit')): ?>
								<a class="btn-link btn-xs" href="<?= $entry['action']('edit') ?>">Edit</a>
							<? endif; ?>

							<? if ($entry['can']('remove')): ?>
								<?= $f = HTML::form($entry['action']('remove'), 'mjolnir:inline') ?>
								<?= $f->hidden('id')->value_is($entry['id']) ?>
								<button type="submit" class="btn-link btn-xs" <?= $f->mark() ?>>Remove</button>
							<? endif; ?>

						</span>
					</span>

					<? if ( ! empty($entry['subentries'])): ?>
						<ul class="acctg-coa--subentries">
							<? foreach ($entry['subentries'] as $subentry): ?>
								<? ibidem_theme_taccount_li($subentry, $level + 1) ?>
							<? endforeach; ?>
						</ul>
					<? endif; ?>
				</li>
			<? elseif ($entry['entrytype'] == 'taccount-type'): ?>
				<li class="acctg-coa--taccount-type lvl-<?= $level ?>">
					<em class="acctg-coa--taccount-type-title"><?= $entry['title'] ?></em>
					<? if ( ! empty($entry['subentries'])): ?>
						<ul class="acctg-coa--subtypes">
							<? foreach ($entry['subentries'] as $subentry): ?>
								<? ibidem_theme_taccount_li($subentry, $level + 1) ?>
							<? endforeach; ?>
						</ul>
					<? endif; ?>
					<? if ( ! empty($entry['taccounts'])): ?>
						<ul class="acctg-coa--taccounts">
							<? foreach ($entry['taccounts'] as $subentry): ?>
								<? ibidem_theme_taccount_li($subentry, $level + 1) ?>
							<? endforeach; ?>
						</ul>
					<? endif; ?>
				</li>
			<? else: # unknown type ?>
				<? throw new \app\Exception('Unknown entry type.') ?>
			<? endif; ?>
		<? } # endfunction ?>

		<? $accts = $context->acctgtaccounts_hierarchy() ?>

		<? if (\count($accts) > 0): ?>
			<ul class="acctg-coa">
				<? foreach ($accts as $taccount): ?>
					<? ibidem_theme_taccount_li($taccount, 0) ?>
				<? endforeach; ?>
			</ul>
		<? else: # no accounts ?>
			<p>There are currently no accounts on the system.</p>
		<? endif; ?>

	</div>

	<div class="col-md-4">

		<<?= $h2 ?>>TAccount Types</<?= $h2 ?>>

		<table class="table">
			<thead>
				<tr>
					<th>type</th>
					<th>accounts</th>
				</tr>
			</thead>
			<tbody>
				<? foreach ($context->acctgtypes() as $type): ?>
					<tr>
						<td><?= \str_repeat(' &nbsp; &nbsp; ', $type['depth']).$type['title'] ?></td>
						<td>
							<? if ($type['usable']): ?>
								<?= $type['taccountcount'] ?>
							<? endif; ?>
						</td>
					</tr>
				<? endforeach; ?>
			</tbody>
		</table>

		<hr/>

		<p>
			<em>
				The above types may not be changed and are used to resolve formulas that involve accounts.
				Please ensure all accounts are in the correct account type, or computational errors will occur.
			</em>
		</p>

	</div>

</div>
