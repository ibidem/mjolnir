<?php return array
	(

		'/(<action>)'
			=> [ 'frontend.public', ['action' => '(add-taccount)'] ],

	# ---- acctg module -------------------------------------------------------

		'/taccount/<id>(/<action>)'
			=> [ 'taccount.public', ['action' => '(delete)'] ],

	); # config
