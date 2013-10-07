<?php return array
	(
		'version' => '1.0.0',
		'sources' => 'src/',
		'root' => 'root/',
		'mode' => 'complete',

	# Complete mode

		'complete-mapping' => array
			(
				'vendor/bootstrap',
			),

	# Targeted mode

		'targeted-common' => array
			(
				// empty
			),

		'targeted-mapping' => array
			(

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
