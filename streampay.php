<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://plugins.streampay.shop
 * @since             1.0.0
 * @package           StreamPay
 *
 * @wordpress-plugin
 * Plugin Name:       streampay Payment Gateway
 * Plugin URI:        https://plugins.streampay.shop
 * Description:       A payment gateway using Solana Pay for your WooCommerce store.
 * Version:           1.0.0
 * Author:            StreamPay
 * Author URI:        https://profiles.wordpress.org/streampayplugins/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       streampay
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
define( 'streampay_VERSION', '1.0.0' );
define( 'streampay_ROOT', plugin_dir_path( __FILE__ ) );
define( 'streampay_ASSETS', streampay_ROOT . '/assets/' );
define( 'streampay_ASSETS_URL', plugin_dir_url( __FILE__ ) . 'assets/' );
define( 'streampay_GATEWAY_ID', 'wc_streampay_solana' );
define( 'streampay_SIGNATURE_STORAGE', 'wc_streampay_signature' );
define( 'streampay_MEMO_SESSION', 'streampay_order_memo' );

/**
 * Add the helper functions file.
 */
if ( is_readable( streampay_ROOT . 'helper.php' ) ) {
	require_once streampay_ROOT . 'helper.php';
}

if ( is_readable( streampay_ROOT . '/vendor/autoload.php' ) ) {
	require_once streampay_ROOT . '/vendor/autoload.php';
}
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-streampay-activator.php
 */
function activate_streampay() {
	require_once streampay_ROOT . 'includes/class-streampay-activator.php';
	streampay_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-streampay-deactivator.php
 */
function deactivate_streampay() {
	require_once streampay_ROOT . 'includes/class-streampay-deactivator.php';
	streampay_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_streampay' );
register_deactivation_hook( __FILE__, 'deactivate_streampay' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require streampay_ROOT . 'includes/class-streampay.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_streampay() {

	$plugin = new StreamPay();
	$plugin->run();

}
run_streampay();


