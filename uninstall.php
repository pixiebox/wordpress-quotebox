<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the quote box
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       http://pixiebox.com
 * @since      0.1
 *
 * @package    Quote_Box
 */

// If uninstall not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

if ( ! function_exists( 'unregister_post_type' ) ) :
	function unregister_post_type( $post_type, $slug = '' ) {
		global $wp_post_types;
		if ( isset( $wp_post_types[ $post_type ] ) ) {
			unset( $wp_post_types[ $post_type ] );
		}
		$slug = ( !$slug ) ? 'edit.php?post_type=quotes' . $post_type : $slug;
		remove_menu_page( $slug );
	}
endif;

remove_action('init', array('Quote_Box_Admin', 'quote_box_register_post_types'));

global $wpdb;

$wpdb->query( 
	"DELETE FROM wp_posts
	WHERE post_type = 'quotes'"
);

unregister_post_type ('quotes');
unregister_widget( 'QuoteBoxWidget' );

