<?
	namespace app;

	/* @var $theme ThemeView */
	/* @var $lang  Lang */

	$line = HTML::formfield('mjolnir:inline');
?>

<tr>
	<td>
		<input class="app-description form-control"
			   placeholder=""
			   type="text"/>
	</td>
	<td>
		<input class="app-quantity form-control"
			   placeholder="0"
			   type="number"/>
	</td>
	<td>
		<input class="app-amount form-control"
			   placeholder="0.00"
			   type="text"/>
	</td>
	<td>
		<input class="app-total-amount form-control"
			   placeholder="0.00"
			   disabled
			   type="text"/>
	</td>
	<td>
		<input class="app-note form-control"
			   placeholder="note"
			   type="text"/>
	</td>
	<td>
		<button class="app-remove btn btn-default">
			Remove
		</button>
	</td>
</tr>
