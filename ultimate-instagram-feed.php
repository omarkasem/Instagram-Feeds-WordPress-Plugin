<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              omark.me
 * @since             1.3.5
 * @package           Ultimate_Instagram_Feed
 *
 * @wordpress-plugin
 * Plugin Name:       Ultimate Instagram Feed
 * Plugin URI:        ultimate-instagram-feed
 * Description:       Ulitmate instagram feed is the best plugin for displaying instagram feeds by username, you can display them with already designed template by shortcode, or you can display them in your ready desgined template with the WP REST API.
 * Version:           1.3.5
 * Author:            Omar Kasem
 * Author URI:        https://profiles.wordpress.org/omarkasem
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ultimate-instagram-feed
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ultimate-instagram-feed-activator.php
 */
function activate_ultimate_instagram_feed() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ultimate-instagram-feed-activator.php';
	Ultimate_Instagram_Feed_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ultimate-instagram-feed-deactivator.php
 */
function deactivate_ultimate_instagram_feed() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ultimate-instagram-feed-deactivator.php';
	Ultimate_Instagram_Feed_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ultimate_instagram_feed' );
register_deactivation_hook( __FILE__, 'deactivate_ultimate_instagram_feed' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ultimate-instagram-feed.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ultimate_instagram_feed() {

	$plugin = new Ultimate_Instagram_Feed();
	$plugin->run();

}
run_ultimate_instagram_feed();
