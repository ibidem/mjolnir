<?php return array
	(
		'description'
			=> 'Install for basic demo inventory table, Customers, Vendors and Employees.',

		'configure' => array
			(
				'tables' => array
					(
						\app\InventoryLib::table(),
						\app\CustomerLib::table(),
						\app\VendorLib::table(),
						\app\EmployeeLib::table()
					),
			),

		'tables' => array
			(
				\app\InventoryLib::table() =>
					'
						`id`     :key_primary,
						`group`  :key_foreign,
						`title`  :title                                  comment "Item name as displayed to the user.",
						`slugid` :slugid                                 comment "URL & internal item name",
						`serial` :identifier                             comment "Manufacturer provided identification number",

						PRIMARY KEY (id)
					',
				\app\CustomerLib::table() =>
					'
						`id`    :key_primary,
						`group` :key_foreign,
						`title` :title,

						PRIMARY KEY (id)
					',
				\app\VendorLib::table() =>
					'
						`id`    :key_primary,
						`group` :key_foreign,
						`title` :title,

						PRIMARY KEY (id)
					',
				\app\EmployeeLib::table() =>
					'
						`id`    :key_primary,
						`group` :key_foreign,
						`title` :title,

						PRIMARY KEY (id)
					',
			),

	); # config
