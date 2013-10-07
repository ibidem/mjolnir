<?
	namespace app;

	/* @var $lang Lang */
?>

<%
	var months = {
		1: 'Jan',
		2: 'Feb',
		3: 'Mar',
		4: 'Apr',
		5: 'May',
		6: 'Jun',
		7: 'Jul',
		8: 'Aug',
		9: 'Sep',
		10: 'Oct',
		11: 'Nov',
		12: 'Dec'
	};

	var first_operation = true;
%>

<% if (inline_style) { %>
	<?= \app\View::instance('mjolnir/accounting/partials/journal-inline-style')
		->inherit($theme)
		->render() ?>
<% } /* endif */ %>

<tbody class="acctg-journal-table--transaction-tbody">
	<% _.each(transaction['operations'], function (operation) { %>
		<tr>
			<% if (first_operation) { %>
				<% first_operation = false; %>
				<td class="acctg-journal-table--transaction-month">
					<%= month %>
				</td>
				<td class="acctg-journal-table--transaction-day">
					<%= day %>
				</td>
				<td class="acctg-journal-table--transaction-id">
					#<a href="<%= transaction_base_url + transaction_id %>"><!--
						--><%= transaction_id %><!--
					--></a>
				</td>
			<% } else { /* not first row */ %>
				<td colspan="3">&nbsp;</td>
			<% } /* endif */ %>

			<% if (operation['type'] == +1) { %>
				<td class="acctg-journal-table--debit-acct">
					<? # guarantee correct alignment; alignment has meaning ?>
					<div style="text-align: left;">
						<a href="<%= taccount_base_url + taccount['id'] %>">
							<%= taccount['title'] %>
						</a>
					</div>
				</td>
				<td>
					<%= operation['amount']['value'] %>
					<%= operation['amount']['type'] %>
				</td>
				<td>&nbsp;</td>
			<% } else { /* operation['type'] == -1, ie. credit */ %>
				<td class="acctg-journal-table--credit-acct">
					<? # guarantee correct alignment; alignment has meaning ?>
					<div style="text-align: right">
						<a href="<%= taccount_base_url + taccount['id'] %>">
							<%= taccount['title'] %>
						</a>
					</div>
				</td>
				<td>&nbsp;</td>
				<td>
					<%= operation['amount']['value'] %>
					<%= operation['amount']['type'] %>
				</td>
			<% } /* endif */ %>
			<td class="acctg-journal-table--operation-note">
				<%= operation['note'] %>
			</td>
			<td>&nbsp;</td>
		</tr>
	<% }); /* end operation */ %>
	<tr class="acctg-journal-table--description-row">
		<td colspan="3">&nbsp;</td>
		<td><i><%= $transaction['description'] %></i></td>
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr class="acctg-journal-table--delimiter-row">
		<td colspan="8">&nbsp;</td>
	</tr>
</tbody>
