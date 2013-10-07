<?
	namespace app;

	/* @var $theme ThemeView */
	/* @var $lang  Lang */

	$twbs = HTML::formfield('mjolnir:twbs3');
	$line = HTML::formfield('mjolnir:inline');
?>

<tr>
	<td>
		<?= $line->select(null, 'taccount')
			->add('class', 'app-taccount')
			->add('class', 'form-control')
			->options_liefhierarchy($context->acctgtaccounts_options_liefhierarchy()) ?>
	</td>
	<td>
		<input class="app-debit form-control" type="text" placeholder="0.00"/>
	</td>
	<td>
		<input class="app-credit form-control" type="text" placeholder="0.00"/>
	</td>
	<td>
		<input class="app-note form-control" type="text" placeholder="note"/>
	</td>
	<td>
		<button class="app-remove btn btn-default">Remove</button>
	</td>
</tr>
