<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://https://github.com/RajatWisdm/
 * @since             1.0.0
 * @package           Wdm_Subscribe
 *
 * @wordpress-plugin
 * Plugin Name:       WDM Subscribe
 * Plugin URI:        https://https://github.com/RajatWisdm/wdm_subscribe
 * Description:       A plugin that stores user email and notify them
 * Version:           1.0.0
 * Author:            Rajat Ganguly
 * Author URI:        https://https://github.com/RajatWisdm/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wdm-subscribe
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
define( 'WDM_SUBSCRIBE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wdm-subscribe-activator.php
 */
function activate_wdm_subscribe() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wdm-subscribe-activator.php';
	Wdm_Subscribe_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wdm-subscribe-deactivator.php
 */
function deactivate_wdm_subscribe() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wdm-subscribe-deactivator.php';
	Wdm_Subscribe_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wdm_subscribe' );
register_deactivation_hook( __FILE__, 'deactivate_wdm_subscribe' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wdm-subscribe.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wdm_subscribe() {

	$plugin = new Wdm_Subscribe();
	$plugin->run();

}
run_wdm_subscribe();
