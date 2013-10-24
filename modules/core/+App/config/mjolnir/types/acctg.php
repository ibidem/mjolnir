<?php return array
	(
		'transaction-method' => array
			(
				\app\CheckLib::transaction_method() => 'Recorded Check',
				\app\DepositLib::transaction_method() => 'Recorded Deposit',
				\app\TransferLib::transaction_method() => 'Recorded Transfer',
				\app\InvoiceLib::transaction_method() => 'Recorded Invoice',
				\app\InvoicePaymentLib::transaction_method() => 'Recorded Invoice Payment',
			),

	); # config
