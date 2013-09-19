<?php return array
	(
		// this special file is used when generating classes and other resources
		// via overlord. The file is special in that if present in a module it
		// will be read as is and not cascade, to allow you to have mix'ed
		// license modules with out worrying about the class legal boilerplate

		// you do not need to specify it for every module, when not present this
		// global version will be used


	// for closed source software you might want something like this

		'disclaimer' => 'This file is property of YOURCOMPANY. You may NOT copy,'
			. ' or redistribute it. Please see the license that came with your '
			. 'copy for more information.',
		'author' => 'YOURCOMPANY Team',
	    'group'  => 'YOURCOMPANY',
		'license' => null,



	// for more open projects something like this should do
	/*
		'author' => 'ORGANIZATION Team',
		'group' => 'ORGANIZATION',
		'license' => 'https://url/to/my/permissive/license',
	*/

	); # config
