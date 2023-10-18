<?php

/**
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://digitalzest.co.uk
 * @since             1.0.0
 * @package           Woomio
 *
 * @wordpress-plugin
 * Plugin Name:       WooMio
 * Plugin URI:        https://digitalzest.co.uk
 * Description:       Connects WooCommerce to Pabbly and further along, to Growmio. Modular switches that enable you to choose what data to send for marketing support.
 * Version:           0.1.1
 * Author:            Digital Zest
 * Author URI:        https://digitalzest.co.uk/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woomio
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WOOMIO_VERSION', '0.1.1' );
define( 'PLUGIN_ROOT', plugin_dir_path( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woomio-activator.php
 */
function activate_woomio() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woomio-activator.php';
	Woomio_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woomio-deactivator.php
 */
function deactivate_woomio() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woomio-deactivator.php';
	Woomio_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woomio' );
register_deactivation_hook( __FILE__, 'deactivate_woomio' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woomio.php';

/**
 * Updating Module from https://github.com/YahnisElsts/plugin-update-checker
 */
require plugin_dir_path( __FILE__ ) . 'plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;


/**
 * A custom update checker for WordPress plugins. 
 * Useful if you don't want to host your project in the official WP repository, 
 * but would still like it to support automatic updates. 
 *
 * @since    1.0.0
 */

function run_woomio_update_checker() {
	$myUpdateChecker = PucFactory::buildUpdateChecker(
		'https://github.com/AuraCreativeMedia/woomio/',
		__FILE__,
		'woomio'
	);
}

run_woomio_update_checker();

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woomio() {

	$plugin = new Woomio();
	$plugin->run();

}

run_woomio();
