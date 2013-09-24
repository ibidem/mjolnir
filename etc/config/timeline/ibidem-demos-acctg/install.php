<?php return array
	(
		'description'
			=> 'Install for basic demo inventory table.',

		'configure' => array
			(
				'tables' => array
					(
						\app\InventoryLib::table(),
					),
			),

		'tables' => array
			(
				\app\InventoryLib::table() =>
					'
						`id`     :key_primary,
						`title`  :title                                  comment "Item name as displayed to the user.",
						`slugid` :slugid                                 comment "URL & internal item name",
						`serial` :identifier                             comment "Manufacturer provided identification number",

						PRIMARY KEY (id)
					',
			),

	); # config
