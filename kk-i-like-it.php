<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @since             1.0.0
 * @package           Kk_I_Like_It
 *
 * @wordpress-plugin
 * Plugin Name:       KK I Like It 2
 * Description:       Plugin gives users or guest an option to like an article or a page.
 * Version:           0.1.0
 * Author:            KWThemes
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       kkilikeit2
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
define( 'KKILIKEIT2_VERSION', '0.1.0' );

define( 'KKILIKEIT2_PATH', plugin_dir_path( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-kk-i-like-it-activator.php
 */
function activate_kk_i_like_it() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-kk-i-like-it-activator.php';
	Kk_I_Like_It_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-kk-i-like-it-deactivator.php
 */
function deactivate_kk_i_like_it() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-kk-i-like-it-deactivator.php';
	Kk_I_Like_It_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_kk_i_like_it' );
register_deactivation_hook( __FILE__, 'deactivate_kk_i_like_it' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-kk-i-like-it.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_kk_i_like_it() {

	$plugin = new Kk_I_Like_It();
	$plugin->run();
	
}
run_kk_i_like_it();
