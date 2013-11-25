<?php namespace app; return array
/////// Access Protocol Configuration //////////////////////////////////////////
(
	'whitelist' => array # allow
		(
			/**
			 * All access within the application is dictated by this (and
			 * related) configuration files. If checkbox style access control is
			 * required then simply create a protocol that implements something
			 * like an access list or some other structure and pass in here as
			 * to the apropriate role.
			 *
			 * Since protocols are programatic any type of access control logic
			 * can be done. Including "has access if is member of and X happens
			 * while Y is false", which is tricky if not sometimes impossible
			 * with ACLs.
			 *
			 * Allow::relays, Allow::backend, or Ban::relays, etc can be used to
			 * create basic protocols for common access requirements.
			 */

			'+common' => array
				(
					// @todo move access rights to apropriate protocols & roles

					Allow::relays
						(
							'frontend.public',
							'testbench.public',
						# demo
							'demo-assets.public',
							'demo-assets--inventory.public',
							'demo-entities.public',
							'demo-entities--customers.public',
							'demo-entities--vendors.public',
							'demo-entities--employees.public',
							'transaction-log.public',
						# acctg module
							'acctg-taccounts.public',
							'acctg-taccount.public',
							'acctg-journals.public',
							'acctg-journal.public',
							'acctg-transactions.public',
							'acctg-transaction.public',
							'acctg-procedures.public',
							'acctg-procedures--check.public',
							'acctg-procedures--transfer.public',
							'acctg-procedures--deposit.public',
							'acctg-procedures--invoice.public',
							'acctg-procedures--invoice-payment.public',
							'acctg-reports.public',
							'acctg-reports--income-statement.public',
							'acctg-reports--owner-equity.public',
							'acctg-reports--balance-sheet.public',
							'acctg-reports--cash-flow-statement.public',
							'acctg-reports--expenses-by-vendor.public',
							'acctg-reports--revenue-by-customer.public',
							'acctg-settings.public',
							# --API--------------------------------------------
							'v1-acctg-transactions.api',
							'v1-acctg-transaction.api',
							'v1-acctg-procedures--checks.api',
							'v1-acctg-procedures--check.api',
							'v1-acctg-procedures--deposits.api',
							'v1-acctg-procedures--deposit.api',
							'v1-acctg-procedures--invoices.api',
							'v1-acctg-procedures--invoice.api'
						)
						->unrestricted(),
				),
		),

	'blacklist' => array # disallow! (no matter what)
		(
			// empty
		),

	'aliaslist' => array # alias list
		(
			/**
			 * If something is allowed for the alias it will be allowed for
			 * the permission category as well. Does not apply for
			 * exceptions. If there is an exception for an alias the
			 * exception will not apply for the permission category.
			 */

			// examples
			Auth::Guest => [ '+common' ],
			'member'    => [ '+common', '+member' ],
			'admin'     => [ '+common', '+member', '+admin' ],
		),

	'roles' => array # roles in system
		(
			'admin' => 1,
			'member' => 2,
		),

); # access config
