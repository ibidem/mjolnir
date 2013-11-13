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

	); # config
