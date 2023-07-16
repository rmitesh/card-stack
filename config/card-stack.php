<?php

return [
	'models' => [
		'card' => Rmitesh\CardStack\Models\Card::class,
	],

	'table_names' => [
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
