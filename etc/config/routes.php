<?php return array
	(

		'/(<action>)'
			=> [ 'frontend.public', ['action' => '(add-taccount|move-taccount)'] ],

	# ---- acctg module -------------------------------------------------------

		'/taccount/<id>(/<action>)'
			=> [ 'taccount.public', ['action' => '(update|remove)'] ],

	); # config
