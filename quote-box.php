<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://pixiebox.com
 * @since             0.1
 * @package           Quote_Box
 *
 * @wordpress-plugin
 * Plugin Name:       Quote Box
 * Plugin URI:        http://pixiebox.com/
 * Description:       Quote box displays a random, or chosen, quote as a widget or shortcode.
 * Version:           0.1
 * Author:            Pixiebox
 * Author URI:        http://pixiebox.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       quote-box
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-quote-box-activator.php
 */
function activate_quote_box() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-quote-box-activator.php';
	Quote_Box_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-quote-box-deactivator.php
 */
function deactivate_quote_box() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-quote-box-deactivator.php';
	Quote_Box_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_quote_box' );
register_deactivation_hook( __FILE__, 'deactivate_quote_box' );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-quote-box.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.1
 */
function run_quote_box() {

	$plugin = new Quote_Box();
	$plugin->run();

}
run_quote_box();
