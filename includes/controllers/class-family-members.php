<?php
namespace HivePress\Controllers;

use HivePress\Helpers as hp;
use HivePress\Models;
use HivePress\Blocks;

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Controller class.
 */
final class Family_Members extends Controller
{

	/**
	 * Class constructor.
	 *
	 * @param array $args Controller arguments.
	 */
	public function __construct($args = [])
	{
		$args = hp\merge_arrays(
			[
				'routes' => [
					'user_family_panel_page' => [
						'title' => esc_html__('Family', 'Panel'),
						'base' => 'user_account_page',
						'path' => '/family',
						'redirect' => [$this, 'redirect_family_page'],
						'action' => [$this, 'render_family_page'],
						'paginated' => true,
					],
					// 'vendor_follow_action' => [
					// 	'base' => 'vendor_resource',
					// 	'path' => '/follow',
					// 	'method' => 'POST',
					// 	'action' => [$this, 'follow_vendor'],
					// 	'rest' => true,
					// ],

					// 'vendors_unfollow_action' => [
					// 	'base' => 'vendors_resource',
					// 	'path' => '/unfollow',
					// 	'method' => 'POST',
					// 	'action' => [$this, 'unfollow_vendors'],
					// 	'rest' => true,
					// ],
				],

			],
			$args
		);

		parent::__construct($args);
	}

	// Implement the route actions here.

	/**
	 * Redirects listing feed page.
	 *
	 * @return mixed
	 */
	public function redirect_family_page()
	{

		// Check authentication.
		if (!is_user_logged_in()) {
			return hivepress()->router->get_return_url('user_login_page');
		}

		// // Check followed vendors.
		// if (!hivepress()->request->get_context('vendor_follow_ids')) {
		// 	return hivepress()->router->get_url('user_account_page');
		// }

		return false;
	}

	/**
	 * Renders listing feed page.
	 *
	 * @return string
	 */
	public function render_family_page()
	{

		// Create listing query.
		$query = Models\Family_Member::query()->filter(
			[
				'family_member__in' => hivepress()->request->get_context('user_family_members'),
			]
		)->order(['created_date' => 'desc'])
			->limit(get_option('hp_listings_per_page'))
			->paginate(hivepress()->request->get_page_number());

		// Set request context.
		hivepress()->request->set_context(
			'post_query',
			$query->get_args()
		);

		// Render page template.
		return (
			new Blocks\Template(
				[
					'template' => 'user_family_panel_page',

					'context' => [
						'listings' => [],
					],
				]
			)
		)->render();
	}



}