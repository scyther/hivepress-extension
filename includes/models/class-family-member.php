<?php
namespace HivePress\Models;

use HivePress\Helpers as hp;

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Model class.
 */
class Family_Member extends Post
{

	/**
	 * Class constructor.
	 *
	 * @param array $args Model arguments.
	 */
	public function __construct($args = [])
	{
		$args = hp\merge_arrays(
			[
				'fields' => [
					'age' => [
						'type' => 'number',
						'required' => true,
						'_alias' => 'age',
						'_model' => 'family_member',
					],
					'name' => [
						'type' => 'string',
						'required' => true,
						'_alias' => 'name',
						'_model' => 'family_member',
					],
					'family_owner' => [
						'type' => 'id',
						'required' => true,
						"_alias" => "family_owner_ID",
						"_model" => "user",
					],
				]
			],
			$args
		);

		parent::__construct($args);
	}
}