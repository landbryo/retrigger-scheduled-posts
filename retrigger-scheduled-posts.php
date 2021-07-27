<?php
/**
 * Plugin Name: Re-trigger Scheduled Posts
 * Plugin URL: https://scree.it/retrigger-scheduled-posts
 * Description: Re-triggers scheduled posts that were missed by cron
 * Version: 1.1.2
 * Author: Landon Otis
 * Author URI: https://github.com/landbryo/retrigger-scheduled-posts
 * Text Domain: mlrtsp
 * Domain Path: languages
 * License: GPL3
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 */

/**
 * Remove event on plugin deactivation
 */
register_deactivation_hook( __FILE__, 'mlrtsp_deactivate' );

function mlrtsp_deactivate() {
	wp_clear_scheduled_hook( 'mlrtsp_cron' );
}

/**
 * Schedule event if it isn't already scheduled
 */
if ( ! wp_next_scheduled( 'mlrtsp_cron' ) ) {
	wp_schedule_event( time(), 'hourly', 'mlrtsp_cron' );
}

/**
 * Check for unpublished posts hourly and publish them
 */
function mlrtsp_cron_run() {
	global $wpdb;
	global $wp_post_types;

	$now               = gmdate( 'Y-m-d H:i:s' );
	$post_type_names   = wp_list_pluck( $wp_post_types, 'name' );
	$post_types_string = implode( "','", $post_type_names );

	$query   = $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type IN ('$post_types_string') AND post_status = 'future' AND post_date_gmt < %s", $now );
	$results = $wpdb->get_results( $query );

	// Return early if no results found
	if ( empty( $results ) ) {
		return;
	}

	// Publish resulting posts
	foreach ( $results as $result ) {
		wp_publish_post( $result->ID );
	}
}

add_action( 'mlrtsp_cron', 'mlrtsp_cron_run' );