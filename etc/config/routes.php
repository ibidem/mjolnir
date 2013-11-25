<?php

	$slugid_regex = '[0-9a-zA-Z-]+';
	$driver = ['driver' => $slugid_regex];

	$id_regex = '[0-9]+';
	$id = ['id' => $id_regex];

	$apimethods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];

return array
	(

		'/'
			=> [ 'frontend.public' ],

		'/testbench'
			=> [ 'testbench.public' ],

	# ---- demo ---------------------------------------------------------------

		'/assets'
			=> [ 'demo-assets.public' ],

		'/assets/inventory(/<action>)'
			=> [ 'demo-assets--inventory.public', ['action' => '(add)'] ],

		'/entities'
			=> [ 'demo-entities.public' ],

		'/entities/vendors(/<action>)'
			=> [ 'demo-entities--vendors.public', ['action' => '(add)'] ],

		'/entities/customers(/<action>)'
			=> [ 'demo-entities--customers.public', ['action' => '(add)'] ],

		'/entities/employees(/<action>)'
			=> [ 'demo-entities--employees.public', ['action' => '(add)'] ],

		'/transaction-log'
			=> [ 'transaction-log.public' ],


	# ---- acctg module -------------------------------------------------------

		'/taccounts(/<action>)'
			=> [ 'acctg-taccounts.public', ['action' => '(add|move)'] ],

		'/taccount/<id>(/<action>)'
			=> [ 'acctg-taccount.public', ['action' => '(edit|remove)'] + $id ],

		'/journals(/<action>)'
			=> [ 'acctg-journals.public', ['action' => '(add)'] ],

		'/journal/<id>(/<action>)'
			=> [ 'acctg-journal.public', ['action' => '(edit|delete|add-transactions)'] + $id ],

		'/transactions(/<action>)'
			=> [ 'acctg-transactions.public', ['action' => '(add)'] ],

		'/transaction/<id>(/<action>)'
			=> [ 'acctg-transaction.public', ['action' => '(edit|delete)'] + $id ],

		# Custom Procedures

		'/procedures'
			=> [ 'acctg-procedures.public' ],

		'/procedures/record-check'
			=> [ 'acctg-procedures--check.public' ],

		'/procedures/record-transfer(/<action>)'
			=> [ 'acctg-procedures--transfer.public', ['action' => '(record)'] ],

		'/procedures/record-deposit'
			=> [ 'acctg-procedures--deposit.public' ],

		'/procedures/record-invoice'
			=> [ 'acctg-procedures--invoice.public' ],

		'/procedures/record-invoice-payment(/<action>)'
			=> [ 'acctg-procedures--invoice-payment.public', ['action' => '(record)'] ],

		'/reports'
			=> [ 'acctg-reports.public' ],

		'/reports/income-statement'
			=> [ 'acctg-reports--income-statement.public' ],

		'/reports/owner-equity'
			=> [ 'acctg-reports--owner-equity.public' ],

		'/reports/balance-sheet'
			=> [ 'acctg-reports--balance-sheet.public' ],

		'/reports/cash-flow-statement'
			=> [ 'acctg-reports--cash-flow-statement.public' ],

		'/reports/expenses-by-vendor'
			=> [ 'acctg-reports--expenses-by-vendor.public' ],

		'/reports/revenue-by-customer'
			=> [ 'acctg-reports--revenue-by-customer.public' ],

		# Settings

		'/settings(/<action>)'
			=> [ 'acctg-settings.public', ['action' => '(save)'] ],

		# API

		'/api/v1/acctg-transactions/<id>'
			=> [ 'v1-acctg-transaction.api', $id, $apimethods ],

		'/api/v1/acctg-transactions'
			=> [ 'v1-acctg-transactions.api', [], $apimethods ],

		'/api/v1/acctg-procedures-checks/<id>'
			=> [ 'v1-acctg-procedures--check.api', $id, $apimethods ],

		'/api/v1/acctg-procedures-checks'
			=> [ 'v1-acctg-procedures--checks.api', [], $apimethods ],

		'/api/v1/acctg-procedures-deposits/<id>'
			=> [ 'v1-acctg-procedures--deposit.api', $id, $apimethods ],

		'/api/v1/acctg-procedures-deposits'
			=> [ 'v1-acctg-procedures--deposits.api', [], $apimethods ],

		'/api/v1/acctg-procedures-invoices/<id>'
			=> [ 'v1-acctg-procedures--invoice.api', $id, $apimethods ],

		'/api/v1/acctg-procedures-invoices'
			=> [ 'v1-acctg-procedures--invoices.api', [], $apimethods ],

	); # config
