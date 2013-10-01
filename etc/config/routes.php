<?php return array
	(

		'/(<action>)'
			=> [ 'frontend.public', ['action' => '(bruteforce-taccount|add-taccount|move-taccount)'] ],

	# ---- acctg module -------------------------------------------------------

		'/taccount/<id>(/<action>)'
			=> [ 'taccount.public', ['action' => '(delete|remove)'] ],

	); # config
