<?php
defined('ABSPATH') || exit;
/*
Plugin Name: Example Plugin
Plugin URI: https://wordpress.com/
Description: Excample plugin build
Version: 1.0.0
Author: Kevin Lim
Author URI: https://word.com/wordpress-plugins/
License: GPLv2 or later
Text Domain: kevin
*/

define('PLUGIN_DIR', plugin_dir_path(__FILE__));
require_once PLUGIN_DIR . 'kevin-plugin-admin.php';

function init_admins(){
    $admin =  new KevinPluginAdmin();
    $admin->register_admin();
}
add_action('admin_menu', 'init_admins');
?>