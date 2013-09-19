<?php namespace app;

return Arr::merge
	(
		[
			'development' => true,
			'key.path' => Env::key('key.path'),
		],
		Env::key('www.config', [])
		
	); # special config
