<?php return array
	(
		'frontpage' => '/',
		
		'homepage' => function (array &$user)
			{
				// customized signin redirect
				if ($user['roletitle'] == 'admin')
				{
					return \app\URL::href('mjolnir:access/auth.route');
				}
				else # not member
				{
					return \app\URL::href('home.public');
				}
			},

	); # config
