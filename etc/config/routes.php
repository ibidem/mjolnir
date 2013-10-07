<?php

	$target_regex = '[0-9A-Za-z]+';
	$target = ['target' => $target_regex ];

	$id_regex = '[0-9]+';
	$id = ['id' => $id_regex];

	$apimethods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];

return array
	(

		'/'
			=> [ 'frontend.public' ],

	# ---- acctg module -------------------------------------------------------

		'/taccounts(/<action>)'
			=> [ 'acctg-taccounts.public', ['action' => '(add|move)'] ],

		'/taccount/<id>(/<action>)'
			=> [ 'acctg-taccount.public', ['action' => '(edit|remove)'] + $id ],

		'/journals(/<action>)'
			=> [ 'acctg-journals.public', ['action' => '(add)'] ],

		'/journal/<id>(/<action>)'
			=> [ 'acctg-journal.public', ['action' => '(edit|delete|add-transactions)'] + $id ],

		'/transactions(/<action>)'
			=> [ 'acctg-transaction.public', ['action' => '(add)'] ],

		'/transaction/<id>(/<action>)'
			=> [ 'acctg-transaction.public', ['action' => '(edit|delete)'] + $id ],

		# API

		'/api/v1/acctg-transactions/<id>'
			=> [ 'v1-acctg-transaction.api', $id, $apimethods],

		'/api/v1/acctg-transactions'
			=> [ 'v1-acctg-transactions.api', [], $apimethods],

	); # config
