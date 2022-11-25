<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @wordpress-plugin
 * Plugin Name:       Easy SCSS
 * Plugin URI:        https://www.manuelbosi.it
 * Description:       A wordpress plugin helps you edit and compile scss file to plain css from in your wordpress admin panel.
 * Version:           1.0.0
 * Author:            Manuel Bosi
 * Author URI:        https://www.manuelbosi.it
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       easy-scss
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Setup autoload
require_once 'lib/autoload.php';

use EasyScss\Shared\EasyScss;
use EasyScss\Shared\EasyScssActivator;
use EasyScss\Shared\EasyScssDeactivator;

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'EASY_SCSS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 */
function activate_easy_scss() {
	EasyScssActivator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_easy_scss() {
	EasyScssDeactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_easy_scss' );
register_deactivation_hook( __FILE__, 'deactivate_easy_scss' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/EasyScss.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 */
function run_easy_scss() {

	$plugin = new EasyScss();
	$plugin->run();

}
run_easy_scss();
