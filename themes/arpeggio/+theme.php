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
						[
							'templates',
							'acctg/transaction/add',
						]
					),

				'acctg-transaction.index' => array
					(
						'base/foundation',
						'acctg/transaction/entry',
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
