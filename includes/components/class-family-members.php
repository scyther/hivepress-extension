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

		if (is_null($family_members)) {

			// Get follows.
			$members = Models\Family_Member::query()->filter(
				[
					'family_owner' => $user_id,
				]
			)->get();

			// Get vendor IDs.
			$member_ids = [];

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
}