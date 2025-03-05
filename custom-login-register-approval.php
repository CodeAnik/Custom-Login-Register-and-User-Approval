<?php
/**
 * Plugin Name: Custom Login Register with Approval
 * Description: একটি কাস্টম লগিন ও রেজিস্ট্রেশন প্লাগিন যেখানে ইউজার অ্যাড্রেস ফিল্ডসহ রেজিস্ট্রার করতে পারবে এবং অ্যাডমিন অনুমোদন নিতে হবে।
 * Version: 1.0
 * Author: Md. Anik Khan
 * Author URI: https://codeanik.github.io/portfolio/
 * License: GPL2
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin path
define('CLRA_PATH', plugin_dir_path(__FILE__));

// Include necessary files
require_once CLRA_PATH . 'includes/class-register-form.php';
require_once CLRA_PATH . 'includes/class-login-form.php';
require_once CLRA_PATH . 'includes/class-settings.php';
require_once CLRA_PATH . 'includes/class-user-approval.php';

// Activation hook
function clra_activate_plugin() {
    // Future database setup or default options
}
register_activation_hook(__FILE__, 'clra_activate_plugin');

// Deactivation hook
function clra_deactivate_plugin() {
    // Cleanup tasks if needed
}
register_deactivation_hook(__FILE__, 'clra_deactivate_plugin');
