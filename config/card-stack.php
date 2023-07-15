<?php

return [

	/**
	 * If you want to display a chart, then make it true.
	 * For statistics perpose
	 */
	'enable_chart' => false,

	'models' => [

		'category' => Spatie\Permission\Models\Permission::class,

	],

	'table_names' => [

		/**
		 * Table Name, it will use in the migration
		 */
		'cards' => 'cards',

	],

	'table_column_names' => [

		/**
		 * "cards" table schema
		 */
		'cards' => [
			'user_id' => 'user_id',

			'name' => 'name',

			'color' => 'color',

			'position' => 'position',
		],

	],

];
