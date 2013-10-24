<?php namespace app;

    $packages = array
        (
            'packages/jquery',
            'packages/jquery-ui-position',
            'packages/json2',
            'packages/underscore',
            'packages/backbone',
            'packages/supermodel',
            'packages/moment',
            'packages/big',
            'packages/pusher.color',
            'packages/accounting',
#           'packages/money', // money conversion
        );

    $mjolnir_required_widgets = array
        (
            // Date.Field
                'widgets/pikaday',
        );

    $plugins = Arr::index
        (
            $mjolnir_required_widgets
            // ...your application plugins...
        );

	$mjolnir = array
		(
			// extentions: Mjolnir
			'app/extentions/mjolnir/bootstrap',
			// ---Types----------------------------------------
			'app/extentions/mjolnir/Instantiatable',
			'app/extentions/mjolnir/Renderable',
			'app/extentions/mjolnir/Exception',
			// ---Components-----------------------------------
			'app/extentions/mjolnir/backbone/Router',
			'app/extentions/mjolnir/backbone/View',
			'app/extentions/mjolnir/backbone/Model',
			'app/extentions/mjolnir/Auditor',
			'app/extentions/mjolnir/backbone/Collection',
			'app/extentions/mjolnir/Field',
			'app/extentions/mjolnir/Popover',
			'app/extentions/mjolnir/Loader',
			// ---Macros---------------------------------------
			'app/extentions/mjolnir/macros/inlineEditing',
			'app/extentions/mjolnir/macros/newInlineEntry',
			'app/extentions/mjolnir/macros/field/getters',
			'app/extentions/mjolnir/macros/field/placeholders',

			// ---Color----------------------------------------
			'mjolnir-Color-Field'    => 'app/extentions/mjolnir/modules/Color/Field',
			// ---Date-----------------------------------------
			'mjolnir-Date-Field'     => 'app/extentions/mjolnir/modules/Date/Field',
			// ---Text-----------------------------------------
			'mjolnir-Text-Field'     => 'app/extentions/mjolnir/modules/Text/Field',
			// ---Select---------------------------------------
			'mjolnir-Select-Field'   => 'app/extentions/mjolnir/modules/Select/Field',
			// ---Currency-------------------------------------
			'app/extentions/mjolnir/modules/Currency/Model',
			'mjolnir-Currency-Field' => 'app/extentions/mjolnir/modules/Currency/Field',
		);

return array
	(
		'version' => '1.0.0',
		'sources' => 'src/',
		'root' => 'root/',
		'mode' => 'targeted',

		'closure.flags' => array
			(
				'--process_jquery_primitives',
				'--warning_level QUIET',
				'--third_party',
				'--compilation_level WHITESPACE_ONLY',
			),

	# Complete mode

		'complete-mapping' => array
			(
				// empty
			),

	# Targeted mode

		'targeted-common' => array
			(
				// empty
			),

		'targeted-mapping' => array
			(
				'acctg-journal.add-transactions' => Arr::index
					(
						$packages,
						$plugins,
						$mjolnir,
						[
							'app/bootstrap',

							// ---Transaction----------------------------------
							'app/modules/acctg/TransactionOperation/Collection',
							'app-acctg-TransactionOperation' => 'app/modules/acctg/TransactionOperation/Model',
							'app-acctg-Transaction' => 'app/modules/acctg/Transaction/Model',

							// initialize
							'app/etc/bios/acctg/Transaction',
						]
					),

				// Procedures =================================================

				'acctg-procedures-check.index' => Arr::index
					(
						$packages,
						$plugins,
						$mjolnir,
						[
							'app/bootstrap',

							// ---Check----------------------------------------
							'app/modules/acctg/CheckExpense/Collection',
							'app-acctg-procedures-CheckExpense' => 'app/modules/acctg/CheckExpense/Model',
							'app-acctg-procedures-Check' => 'app/modules/acctg/Check/Model',

							// initialize
							'app/etc/bios/acctg/Check',
						]
					),

				'acctg-procedures-deposit.index' => Arr::index
					(
						$packages,
						$plugins,
						$mjolnir,
						[
							'app/bootstrap',

							// ---Check----------------------------------------
							'app/modules/acctg/DepositPayment/Collection',
							'app-acctg-procedures-DepositPayment' => 'app/modules/acctg/DepositPayment/Model',
							'app-acctg-procedures-Deposit' => 'app/modules/acctg/Deposit/Model',

							// initialize
							'app/etc/bios/acctg/Deposit',
						]
					),

				'acctg-procedures-invoice.index' => Arr::index
					(
						$packages,
						$plugins,
						$mjolnir,
						[
							'app/bootstrap',

							// ---Check----------------------------------------
							'app/modules/acctg/InvoicePayment/Collection',
							'app-acctg-procedures-InvoicePayment' => 'app/modules/acctg/InvoicePayment/Model',
							'app/modules/acctg/InvoiceExpense/Collection',
							'app-acctg-procedures-InvoiceExpense' => 'app/modules/acctg/InvoiceExpense/Model',
							'app-acctg-procedures-Invoice' => 'app/modules/acctg/Invoice/Model',

							// initialize
							'app/etc/bios/acctg/Invoice',
						]
					),

				// Reports ====================================================

				'+report' => Arr::index
					(
						$packages,
						$plugins,
						$mjolnir,
						[
							'app/bootstrap',

							// ---Report---------------------------------------
							'app-acctg-reports-ReportOptions' => 'app/modules/acctg/ReportOptions/Model',
							'app/modules/acctg/Report/Model',

							// initialize
							'app/etc/bios/acctg/ReportOptions',
							'app/etc/bios/acctg/Report',
						]
					),

				'acctg-reports-balance-sheet.index' => '+report',
				'acctg-reports-income-statement.index' => '+report',
				'acctg-reports-cash-flow-statement.index' => '+report',
				'acctg-reports-expenses-by-vendor.index' => '+report',
				'acctg-reports-expenses-by-customer.index' => '+report',


			# ---- Errors -----------------------------------------------------

				'+error' => array
					(
						// empty, just inherit common
					),

				'exception-Unknown'        => '+error',
				'exception-NotImplemented' => '+error',
				'exception-NotFound'       => '+error',
				'exception-NotAllowed'     => '+error',
				'exception-NotApplicable'  => '+error',

			),

	); # config
