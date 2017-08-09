<?php
/**
 * Plugin Name: Lehigh Valley Current Temp Widget
 * Plugin URI: https://github.com/salcode/fe-lehigh-valley-current-temp
 * Description: Display the current temp in Lehigh Valley. Using the Dark Sky API and WordPress transients.
 * Version: 1.0.0
 * Author: Sal Ferrarello
 * Author URI: http://salferrarello.com/
 * Text Domain: fe-lehigh-valley-current-temp
 * Domain Path: /languages
 *
 * @package fe-lehigh-valley-current-temp
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once( 'src/class-fe-lehigh-valley-current-temp-widget.php' );

// Register Fe_Lehigh_Valley_Current_Temp_Widget widget.
add_action( 'widgets_init', 'register_fe_llctw' );

/**
 * Register Widget.
 */
function register_fe_llctw() {
	register_widget( 'Fe_Lehigh_Valley_Current_Temp_Widget' );
}

/**
 * Get the current outdoor temperature.
 *
 * This value returns a cached value. The value is
 * updated at least once every 30 minutes.
 *
 * @return string The current temperature in Lehigh Valley.
 */
function fe_get_lv_temp_f() {

	$temp = get_transient( 'fe_lv_temp' );
	$max_transient_time = 30 * MINUTE_IN_SECONDS;
	if ( false !== $temp ) {
		// We have a cached value (the transient).
		// Use it and do NOT process any other lines in this function.
		return $temp;
	}

	/**
	 * If we reach this point, we do not have a cached value that we can use.
	 * Get get the current temperature by calling the Dark Sky API.
	 */

	// This is a remote HTTP request, it is SLOW!
	$temp = fe_get_lv_temp_api_call();

	// Our API call lookup failed.
	if ( is_null( $temp ) ) {
		// Display "?" instead of the temperature.
		$temp = '?';
		// Cache the value for 30 seconds max.
		$max_transient_time = 30;
	}

	// Store the temperature in a transient, so we can use it without making the API call.
	set_transient(
		'fe_lv_temp',       // Transient key.
		$temp,              // Value to store.
		$max_transient_time // Max time to keep transient.
	);
	return $temp;
}

/**
 * Get current temperature via an API call.
 *
 * Note: This function is SLOW because it makes an HTTP request.
 *
 * @return string The current temperature in degrees F for Lehigh Valley.
 */
function fe_get_lv_temp_api_call() {
	try {
		$url = sprintf(
			'https://api.darksky.net/forecast/%s/37.8267,-122.4233',
			FE_DARK_SKY_API // My Secret DarkSky API key set in wp-config.php.
		);
		$response = wp_remote_get( $url );
		$body     = wp_remote_retrieve_body( $response );
		$weather  = json_decode( $body );
		$temp     = $weather->currently->temperature;
	} catch ( Exception $e ) {
		// Looking up the current temperature failed.
		return null;
	}
	return $temp;
}
