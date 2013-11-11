<?php return array
	(
		'description' => 'Install for main accounting processes.',

		'configure' => array
			(
				'tables' => array
					(
						\app\CheckLib::table(),
						\app\DepositLib::table(),
						\app\TransferLib::table(),
						\app\InvoiceLib::table(),
						\app\InvoiceExpenseLib::table(),
						\app\InvoicePaymentLib::table(),
					),
			),

		'tables' => array
			(
				\app\CheckLib::table() =>
					'
						`id`          :key_primary,
						`group`       :key_foreign,
						`transaction` :key_foreign                       comment "The transaction responsible for the operation.",
						`orderof`     :title,

						PRIMARY KEY (id)
					',
				\app\DepositLib::table() =>
					'
						`id`          :key_primary,
						`group`       :key_foreign,
						`transaction` :key_foreign                       comment "The transaction responsible for the operation.",
						`description` :block,

						PRIMARY KEY (id)
					',
				\app\TransferLib::table() =>
					'
						`id`          :key_primary,
						`group`       :key_foreign,
						`transaction` :key_foreign                       comment "The transaction responsible for the operation.",
						`note`        :block,

						PRIMARY KEY (id)
					',
				\app\InvoiceLib::table() =>
					'
						`id`          :key_primary,
						`group`       :key_foreign,
						`duedate`     :datetime_required                 comment "End term for the reciet from the date it was issued (transaction date).",
						`description` :block,

						PRIMARY KEY (id)
					',
				\app\InvoiceExpenseLib::table() =>
					'
						`id`          :key_primary,
						`invoice`     :key_foreign,
						`description` :title                             comment "What the unit represents (ie. product, hours, days, etc)",
						`quantity`    :counter                           comment "Number of units.",
						`unit_value`  :currency                          comment "The cost of a individual unit. Total being quantity * unitcost.",
						`unit_type`   varchar(3) DEFAULT "USD"           comment "Currency type for the represented unit cost.",

						PRIMARY KEY (id)
					',
				\app\InvoicePaymentLib::table() =>
					'
						`id`          :key_primary,
						`invoice`     :key_foreign,
						`transaction` :key_foreign                       comment "The transaction responsible for the operation.",
						`note`        :block,

						PRIMARY KEY (id)
					',
			),

		'bindings' => array
			(
				// field => [ table, on_delete, on_update ]

				\app\CheckLib::table() => array
					(
						'transaction' => [\app\AcctgTransactionLib::table(), 'RESTRICT', 'CASCADE'],
					),
				\app\DepositLib::table() => array
					(
						'transaction' => [\app\AcctgTransactionLib::table(), 'RESTRICT', 'CASCADE'],
					),
				\app\TransferLib::table() => array
					(
						'transaction' => [\app\AcctgTransactionLib::table(), 'RESTRICT', 'CASCADE'],
					),
				\app\InvoiceExpenseLib::table() => array
					(
						'invoice' => [\app\InvoiceLib::table(), 'RESTRICT', 'CASCADE'],
					),
				\app\InvoicePaymentLib::table() => array
					(
						'invoice' => [\app\InvoiceLib::table(), 'RESTRICT', 'CASCADE'],
						'transaction' => [\app\AcctgTransactionLib::table(), 'RESTRICT', 'CASCADE'],
					),
			),

		'populate' => function (\mjolnir\types\SQLDatabase $db)
			{
				\app\AcctgTAccountLib::install_taccounts(null, \app\CFS::config('ibidem/acctg/data/default.taccounts'));
			},

	/*
		'populate' => function (\mjolnir\types\SQLDatabase $db)
			{
				$keyprefix = 'pdx:ibidem-demos-acctg-install-';

				// Calculate the root offset
				// -------------------------

				$maxrgt = $db->prepare
					(
						$keyprefix.'find-offset',
						'
							SELECT MAX(rgt)
							  FROM `'.\app\AcctgTAccountLib::table().'`
						'
					)
					->run()
					->fetch_calc();

				$offset = $maxrgt !== null or $maxrgt = 0;

				// Inject default system taccounts
				// -------------------------------

				$typestable = $db->prepare
					(
						$keyprefix.'all-types',
						'
							SELECT *
							FROM `'.\app\AcctgTAccountTypeLib::table().'`
						'
					)
					->run()
					->fetch_all();

				$types = \app\Arr::gatherkeys($typestable, 'slugid', 'id');

				// create general purpose sales account

				$general_revenue_account = \app\Pdx::insert
					(
						$keyprefix.'sales-taccount', $db,
						\app\AcctgTAccountLib::table(),
						[
							'type' => $types['revenue'],
							'title' => 'General Revenue',
							'sign' => +1,
							'lft' => $offset + 1,
							'rgt' => $offset + 2,
						]
					);

				// create general purpose recievables account

				$accounts_recievables_account = \app\Pdx::insert
					(
						$keyprefix.'accounts-recieables-taccount', $db,
						\app\AcctgTAccountLib::table(),
						[
							'type' => $types['current-assets'],
							'title' => 'Accounts Recievables',
							'sign' => +1,
							'lft' => $offset + 3,
							'rgt' => $offset + 4,
						]
					);

				\app\Pdx::insert
					(
						$keyprefix.'configure-invoice-revenue-taccount', $db,
						\app\AcctgSettingsLib::table(),
						[
							'taccount' => $general_revenue_account,
							'slugid' => 'invoice:revenue.acct'
						]
					);

				\app\Pdx::insert
					(
						$keyprefix.'lock-general-revenue-taccount', $db,
						\app\AcctgTAccountLockLib::table(),
						[
							'taccount' => $general_revenue_account,
							'issuer' => \app\AcctgSettingsLib::taccountlock_issuer(),
							'cause' => \app\AcctgSettingsLib::taccountlock_cause(),
						]
					);

				\app\Pdx::insert
					(
						$keyprefix.'configure-invoice-recievables-taccount', $db,
						\app\AcctgSettingsLib::table(),
						[
							'taccount' => $accounts_recievables_account,
							'slugid' => 'invoice:recievables.acct'
						]
					);

				\app\Pdx::insert
					(
						$keyprefix.'lock-accounts-recievables-taccount', $db,
						\app\AcctgTAccountLockLib::table(),
						[
							'taccount' => $accounts_recievables_account,
							'issuer' => \app\AcctgSettingsLib::taccountlock_issuer(),
							'cause' => \app\AcctgSettingsLib::taccountlock_cause(),
						]
					);
			},
	 */

	); # config
