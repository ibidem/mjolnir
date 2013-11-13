<?php return array
	(
		// --------------------------------------------------------------------
		// Assets

		'current-assets' => array
			(
#				'accts-recv' => 'Accounts Receivable', # set internally
				'doubtful-accounts' => 'Allowance for Doubtful Accounts',
				'inventory' => 'Inventory',
				'supplies' => 'Supplies',
				'prepaid-insurance' => 'Prepaid Insurance'
			),

			'bank' => array
				(
					'petty-cash' => 'Petty Cash Fund',
				),

			'cash' => array
				(
					'cash' => 'Cash',
				),

		'long-term-assets' => array
			(
				'land' => 'Land',
				'buildings' => 'Buildings',
				'equipment' => 'Equipment',
				'vehicles' => 'Vehicles',
			),

			'depreciation' => array
				(
					'building-depreciation' => 'Accumulated Depreciation - Buildings',
					'equipment-depreciation' => 'Accumulated Depreciation - Equipment',
					'vehicle-depreciation' => 'Accumulated Depreciation - Vehicles',
				),

		// --------------------------------------------------------------------
		// Equity

		'current-liabilities' => array
			(
				'notes-payable' => 'General Notes Payable',
				'accts-payable' => 'Accounts Payable',
				'wages-payable' => 'Wages Payable',
				'interest-payable' => 'Interest Payable',
				'unearned-revenue' => 'Unearned Revenues'
			),

		'long-term-liabilities' => array
			(
				'mortgage-loan-payable' => 'Mortgage Loan Payable',
				'bonds-payable' =>'Bonds Payable',
				'discount-bonds-payable' =>'Discount on Bonds Payable'
			),

		'capital-stock' => array
			(
				'common-stock' => 'Common Stock, No Par',
				'treasury-stock' => 'Treasury Stock'
			),

			'retained-earnings' => array
				(
					'retained-earnings' => 'Retained Earnings',
				),

			'investments' => array
				(
					'investments' => 'Investments',
				),

			'withdraws' => array
				(
					'draws' => 'Withdraws',
				),

		'revenue' => array
			(
#				'general-revenue' => 'General Revenue', # set internally
				'general-sales' => 'General Sales'
			),

		'general-expenses' => array
			(
				'marketing' => 'Marketing',
				'salaries' => 'Salaries',
				'taxes' => 'Taxes',
				'supplies' => 'Supplies',
			),

		'depreciation-expenses' => array
			(
				'depreciation-expense' => 'Depreciation Expense',
			),

	); # config
