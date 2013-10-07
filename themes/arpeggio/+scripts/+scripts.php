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
				'+apps' => Arr::index
					(
						$packages,
						$plugins,
						[
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

						// == Application =====================================

							'app/bootstrap',

							// ---Accounting-----------------------------------
							'app/modules/acctg/TransactionOperation/Collection',
							'app-acctg-TransactionOperation' => 'app/modules/acctg/TransactionOperation/Model',
							'app-acctg-Transaction' => 'app/modules/acctg/Transaction/Model',

							// initialize
							'app/etc/bios/acctg/Transaction',
							'app/main',
						]
					),

				'acctg-journal.add-transactions' => '+apps',

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
