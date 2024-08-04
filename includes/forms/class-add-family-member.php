<?php
namespace HivePress\Forms;

use HivePress\Helpers as hp;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Form class.
 */
class Add_Family_Member extends Form {

	/**
	 * Class constructor.
	 *
	 * @param array $args Form arguments.
	 */
	public function __construct( $args = [] ) {
		$args = hp\merge_arrays(
			[
				'description' => esc_html__( 'Are you sure you want to add this member?', 'Event-Register' ),
				'action'      => hivepress()->router->get_url( 'add_family_member_action' ),
				'method'      => 'POST',
				'redirect'    => true,

				'button'      => [
					'label' => esc_html__( 'Unfollow', 'foo-followers' ),
				],
			],
			$args
		);

		parent::__construct( $args );
	}
}