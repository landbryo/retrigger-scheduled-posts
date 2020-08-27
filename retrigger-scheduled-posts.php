<?php
/**
 * Plugin Name: Re-trigger Scheduled Posts
 * Description: This plugin re-triggers scheduled posts that were missed by the server's cron
 * Version: 1.0
 * Author: Landon Otis - Mission Lab
 * Author URI: http://missionlab.dev
 * License: GPL3
 */

/**
 * Clear scheduler on deactivation
 */
register_deactivation_hook( __FILE__, 'ml_pub_deactivate' );

function ml_pub_deactivate() {
	wp_clear_scheduled_hook( 'ml_pub_cron' );
}

/**
 * Schedule event if it isn't already scheduled
 */
if ( ! wp_next_scheduled( 'ml_pub_cron' ) ) {
	wp_schedule_event( time(), 'hourly', 'ml_pub_cron' );
}

/**
 * Check for unpublished posts hourly and publish them
 */
function ml_pub_cron_run() {
	global $wpdb;
	$now = gmdate( 'Y-m-d H:i:00' );

	// Support custom post types
	$args = [
		'public'   => true,
		'_builtin' => false
	];

	$post_types = get_post_types( $args, 'names', 'and' );
	$str        = implode( '\',\'', $post_types );

	if ( $str ) {
		$query = $wpdb->prepare( "SELECT id FROM {$wpdb->posts} WHERE post_type IN ('post','page',%s) AND post_status = 'future' AND post_date_gmt < %s", $str, $now );
	} else {
		$query = $wpdb->prepare( "SELECT id FROM {$wpdb->posts} WHERE post_type IN ('post','page') AND post_status = 'future' AND post_date_gmt < %s", $now );
	}

	$results = $wpdb->get_results( $query );

	if ( $results ) {
		foreach ( $results as $result ) {
			wp_publish_post( $result->ID );
		}
	}
}

add_action( 'ml_pub_cron', 'ml_pub_cron_run' );