<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress or ClassicPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://webcrunch.com.au/
 * @since             0.0.1
 * @package           Configurator_Wp
 *
 * @wordpress-plugin
 * Plugin Name:       configurator-wp
 * Plugin URI:        https://plugin.com/configurator-wp-uri/
 * Description:       A Short Plugin description. Keep it to the point.
 * Version:           0.0.1
 * Author:            Scott Zonneveldt
 * Requires at least: 1.0.0
 * Tested up to:      5.8
 * Author URI:        https://webcrunch.com.au//
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       configurator-wp
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Current plugin version.
 * Start at version 0.0.1 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CONFIGURATOR_WP_VERSION', '0.0.1' );

/**
 * The code that runs during plugin activation.
 *
 * This action is documented in includes/class-configurator-wp-activator.php
 * Full security checks are performed inside the class.
 */
function plugin_name_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-configurator-wp-activator.php';
	Configurator_Wp_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 *
 * This action is documented in includes/class-configurator-wp-deactivator.php
 * Full security checks are performed inside the class.
 */
function plugin_name_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-configurator-wp-deactivator.php';
	Configurator_Wp_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'plugin_name_activate' );
register_deactivation_hook( __FILE__, 'plugin_name_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-configurator-wp.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * Generally you will want to hook this function, instead of callign it globally.
 * However since the purpose of your plugin is not known until you write it, we include the function globally.
 *
 * @since    0.0.1
 */
function plugin_name_run() {

	$plugin = new Configurator_Wp();
	$plugin->run();

}
plugin_name_run();
