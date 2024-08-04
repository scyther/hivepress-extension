<?php
namespace HivePress\Components;

use HivePress\Helpers as hp;
use HivePress\Models;
use HivePress\Emails;

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Component class.
 */
final class Family_Members extends Component
{

	/**
	 * Class constructor.
	 *
	 * @param array $args Component arguments.
	 */
	public function __construct($args = [])
	{

		add_filter('hivepress/v1/components/request/context', [$this, 'set_request_context']);
		add_filter( 'hivepress/v1/menus/user_account', [ $this, 'add_menu_item' ] );
		parent::__construct($args);
	}

	// Implement the attached functions here.
	/**
	 * Sets request context for pages.
	 *
	 * @param array $context Context values.
	 * @return array
	 */
	public function set_request_context($context)
	{

		// Get user ID.
		$user_id = get_current_user_id();

		// Get cached vendor IDs.
		$family_members = hivepress()->cache->get_user_cache($user_id, 'user_family_members', 'models/family_member');
		$member_ids = [];
		if (is_null($family_members)) {

			// Get follows.
			$members = Models\Family_Member::query()->filter(
				[
					'family_owner' => $user_id,
				]
			)->get();



			foreach ($members as $member) {
				$member_ids[] = $member->get_id();
			}

			// Cache vendor IDs.
			hivepress()->cache->set_user_cache($user_id, 'user_family_members', 'models/family_member', $member_ids);
		}

		// Set request context.
		$context['user_family_members'] = $member_ids;

		return $context;
	}

	/**
 * Adds menu item to user account.
 *
 * @param array $menu Menu arguments.
 * @return array
 */
public function add_menu_item( $menu ) {
	if ( hivepress()->request->get_context( 'user_family_members' ) ) {
		$menu['items']['listings_feed'] = [
			'route'  => 'user_family_page',
			'_order' => 20,
		];
	}

	return $menu;
}
}