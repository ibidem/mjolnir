<?php return array
	(
		'version' => '1.0.0',

		// configure theme drivers
		'loaders' => array
			(
				'bootstrap' => null,
				'style' => ['default.style' => 'spiritus'],
				'javascript' => null,
			),

		// target-to-file mapping
		'mapping' => array
			(
				'frontend.index' => array
					(
						'base/foundation',
						'index',
					),

				'testbench.index' => array
					(
						'testbench',
					),

			# Demo

				'transaction-log.index' => array
					(
						'base/foundation',
						'acctg/transaction/log',
					),

				'demo-assets.index' => array
					(
						'base/foundation',
						'assets/index',
					),

				'demo-assets-inventory.index' => array
					(
						'base/foundation',
						'assets/inventory/index',
					),

				'demo-entities.index' => array
					(
						'base/foundation',
						'entities/index',
					),

				'demo-entities-vendors.index' => array
					(
						'base/foundation',
						'entities/vendors/index',
					),

				'demo-entities-customers.index' => array
					(
						'base/foundation',
						'entities/customers/index',
					),

				'demo-entities-employees.index' => array
					(
						'base/foundation',
						'entities/employees/index',
					),

				'acctg-settings.index' => array
					(
						'base/foundation',
						'acctg/settings',
					),

			# TAccounts

				'acctg-taccounts.index' => array
					(
						'base/foundation',
						'acctg/taccount/index',
					),

				'acctg-taccounts.add' => array
					(
						'base/foundation',
						'acctg/taccount/add',
					),

				'acctg-taccounts.move' => array
					(
						'base/foundation',
						'acctg/taccount/move',
					),

				'acctg-taccount.index' => array
					(
						'base/foundation',
						'acctg/taccount/entry',
					),

				'acctg-taccount.edit' => array
					(
						'base/foundation',
						'acctg/taccount/edit',
					),

			# Journals

				'acctg-journals.index' => array
					(
						'base/foundation',
						'acctg/journal/index',
					),

				'acctg-journals.add' => array
					(
						'base/foundation',
						'acctg/journal/add',
					),

				'acctg-journal.index' => array
					(
						'base/foundation',
						'acctg/journal/entry',
					),

				'acctg-journal.edit' => array
					(
						'base/foundation',
						'acctg/journal/edit',
					),

			# Transactions

				'acctg-journal.add-transactions' => array
					(
						'base/foundation',
						'acctg/transaction/add',
					),

				'acctg-transaction.index' => array
					(
						'base/foundation',
						'acctg/transaction/entry',
					),

			# Procedures

				'acctg-procedures.index' => array
					(
						'base/foundation',
						'acctg/procedures/index',
					),

				'acctg-procedures-check.index' => array
					(
						'base/foundation',
						'acctg/procedures/check',
					),

				'acctg-procedures-transfer.index' => array
					(
						'base/foundation',
						'acctg/procedures/transfer',
					),

				'acctg-procedures-transfer.record' => array
					(
						'base/foundation',
						'acctg/procedures/transfer',
					),

				'acctg-procedures-deposit.index' => array
					(
						'base/foundation',
						'acctg/procedures/deposit',
					),

				'acctg-procedures-invoice.index' => array
					(
						'base/foundation',
						'acctg/procedures/invoice',
					),

				'acctg-procedures-invoice-payment.index' => array
					(
						'base/foundation',
						'acctg/procedures/invoice-payment',
					),

			# Reports

				'acctg-reports.index' => array
					(
						'base/foundation',
						'acctg/reports/index',
					),

				'acctg-reports-balance-sheet.index' => array
					(
						'base/foundation',
						'acctg/reports/statements/balance-sheet',
					),

				'acctg-reports-cash-flow-statement.index' => array
					(
						'base/foundation',
						'acctg/reports/statements/cash-flow-statement',
					),

				'acctg-reports-income-statement.index' => array
					(
						'base/foundation',
						'acctg/reports/statements/income-statement',
					),

				'acctg-reports-expenses-by-vendor.index' => array
					(
						'base/foundation',
						'acctg/reports/expenses-by-vendor',
					),

				'acctg-reports-revenue-by-customer.index' => array
					(
						'base/foundation',
						'acctg/reports/revenue-by-customer',
					),

			# ---- Errors -----------------------------------------------------

				'exception-Unknown' => array
					(
						'errors/unknown',
					),

				'exception-NotImplemented' => array
					(
						'errors/not-implemented',
					),

				'exception-NotFound' => array
					(
						'errors/not-found',
					),

				'exception-NotAllowed' => array
					(
						'errors/not-allowed',
					),

				'exception-NotApplicable' => array
					(
						'errors/not-applicable',
					),

			),

	); # config
