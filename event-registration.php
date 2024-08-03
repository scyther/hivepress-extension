<?php
/**
 * Plugin Name: Event Registration for HivePress
 * Description: Allow users to register for events.
 * Version: 1.0.0
 * Author: Chirag
 * Author URI: https://example.com/
 * Text Domain: foo-followers
 * Domain Path: /languages/
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Register extension directory.
add_filter(
	'hivepress/v1/extensions',
	function( $extensions ) {
		$extensions[] = __DIR__;

		return $extensions;
	}
);