<?php return array
	(
		'ibidem-demos-acctg' => array
			(
				'1.0.0' => \app\Pdx::gate
					(
						'ibidem-demos-acctg/install',
						[
							// depends on...
							'mjolnir-access' => '1.0.0',
							'mjolnir-accounting' => '1.0.0',
						]
					),
			),

	); # config
