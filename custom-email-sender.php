<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link https://sqoove.com
 * @since 1.0.0
 * @package Custom_Email_Sender
 *
 * @wordpress-plugin
 * Plugin Name: Custom Email Sender
 * Plugin URI: https://wordpress.org/plugins/custom-email-sender/
 * Description: Change the default email address and sender name output for all message sent from your WP dashboard.
 * Version: 2.6.0
 * Author: Sqoove
 * Author URI: https://sqoove.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: custom-email-sender
 * Domain Path: /languages
*/

/**
 * If this file is called directly, then abort
*/
if(!defined('WPINC'))
{
	die;
}

/**
 * Currently plugin version
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions
*/
define('CUSTOM_EMAIL_SENDER_VERSION', '2.6.0');

/**
 * The code that runs during plugin activation
 * This action is documented in includes/class-custom-email-sender-activator.php
*/
function activate_custom_email_sender()
{
	require_once plugin_dir_path(__FILE__).'includes/class-custom-email-sender-activator.php';
	Custom_Email_Sender_Activator::activate();
}

/**
 * The code that runs during plugin deactivation
 * This action is documented in includes/class-custom-email-sender-deactivator.php
*/
function deactivate_custom_email_sender()
{
	require_once plugin_dir_path(__FILE__).'includes/class-custom-email-sender-deactivator.php';
	Custom_Email_Sender_Deactivator::deactivate();
}

/**
 * Activation/deactivation hook
*/
register_activation_hook(__FILE__, 'activate_custom_email_sender');
register_deactivation_hook(__FILE__, 'deactivate_custom_email_sender');

/**
 * The core plugin class that is used to define internationalization and admin-specific hooks
*/
require plugin_dir_path(__FILE__).'includes/class-custom-email-sender-core.php';

/**
 * Begins execution of the plugin
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle
 * @since 1.0.0
*/
function run_custom_email_sender()
{
	$plugin = new Custom_Email_Sender();
	$plugin->run();
}

/**
 * Run plugin
*/
run_custom_email_sender();

?>