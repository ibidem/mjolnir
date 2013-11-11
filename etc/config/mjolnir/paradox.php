<?php return array
	(
		// project channel
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

		// overwrites and tables for extra accounting features such as custom
		// project specific procedures
		'ibidem-mjolnir-accounting' => array
			(
				#
				# In the case of overwrite channels such as this the version
				# number should "stick" to the version number of the channel
				# you are overwriting. ie. changes to mjolnir-accounting 1.2.3
				# would go in as ibidem-mjolnir-accounting 1.2.3 with
				# dependency to 1.2.3
				#

				'1.0.0' => \app\Pdx::gate
					(
						'ibidem-mjolnir-accounting/install',
						[
							'mjolnir-accounting' => '1.0.0',
							'ibidem-demos-acctg' => '1.0.0',
						]
					),
			),

	); # config
