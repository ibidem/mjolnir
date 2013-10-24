<?php return array
	(
		'check' => array
			(
				'title' => 'Record Check',
				'description' => 'Record bank check.',
				'relay' => 'acctg-procedures--check.public',
			),

		'transfer' => array
			(
				'title' => 'Record Transfer',
				'description' => 'Record money transfer.',
				'relay' => 'acctg-procedures--transfer.public',
			),

		'deposit' => array
			(
				'title' => 'Record Deposit',
				'description' => 'Record bank deposit on a payment or otherwise (ie. recieved a check, etc).',
				'relay' => 'acctg-procedures--deposit.public',
			),

		'invoice' => array
			(
				'title' => 'Record Invoice',
				'description' => 'Record invoice; may also records payments on the invoice.',
				'relay' => 'acctg-procedures--invoice.public',
			),

		'invoice-payment' => array
			(
				'title' => 'Record Invoice Payment',
				'description' => 'Record invoice payment.',
				'relay' => 'acctg-procedures--invoice-payment.public',
			),

	); # config
