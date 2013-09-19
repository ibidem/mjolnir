<?php return array
	(
		// if you need to test set the driver to debug and the system will
		// output the message raw to screen so you can it's working as intended
		'default.driver' => 'file', # debug, file, native, sendmail, smtp

	# -- Driver Configuration ------------------------------------------------ #

		'smtp:driver' => array
			(
				'hostname' => null,
				'port' => 25,
				'encryption' => null,
				'username' => null,
				'password' => null,
				'timeout' => 10,
			),
	);