<?php return array
	(
		'version' => '1.0.0',

		// configure theme drivers
		'loaders' => array
			(
				'style' => ['default.style' => 'allegro'],
				'javascript' => null,
				'bootstrap' => null,
			),

		// target-to-file mapping
		'mapping' => array
			(
				'frontend' => array
					(
						'acctg-index',
					),

				'taccount' => array
					(
						'acctg-taccount',
					),

			# ---- Errors -----------------------------------------------------

				'exception-Unknown' => array
					(
						'errors/unknown',
					),
			),

	); # config
