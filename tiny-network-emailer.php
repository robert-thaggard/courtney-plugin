<?php

/**
 * Plugin Name:       Tiny Network Emailer
 * Plugin URI:        N/A
 * Description:       Send ya'll some Emails. Yeeeeeeeeeeeeeehah!
 * Version:           1.0.0
 * Author:            Robert Thaggard
 * Author URI:        N/A
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tiny-network-emailer
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die("Access Denied.");
}

define('TNE_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('TNE_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once TNE_PLUGIN_DIR . 'tinynetworkemailer.php';

add_action('admin_menu', 'TinyNetworkEmailer::registerMenuHooks');
add_action('wp_ajax_tne_send_email', 'TinyNetworkEmailer::ajaxSendEmails');