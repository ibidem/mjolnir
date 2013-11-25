<?php return \app\Arr::merge
	(
		[
			'development' => true,
			'key.path' => \app\Env::key('key.path'),
		],
		\app\Env::key('www.config', [])
		
	); # special config
