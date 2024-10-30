<?php
/**
 * Plugin Name: Linkvertise Script API
 * Plugin URI: https://linkvertise.net/dashboard#dynamic
 * Description: This plugin includes the Linkvertise API script to your Wordpress page.
 * Version: 1.0.8
 * Author: Linkvertise
 * Author URI: https://linkvertise.net/
 * License: GPLv2 or later
 * Text Domain: linkvertise-script-api
 */

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/

/**
 * @package LinkvertiseScriptApiPlugin
 */

defined('ABSPATH') OR die();

// Require once the Composer autoload
if(file_exists( dirname(__FILE__) . '/vendor/autoload.php')) {
  require_once dirname(__FILE__) . '/vendor/autoload.php';
}

/**
 * Code that runs during plugin activation
 */
function activatePlugin() {
  Inc\Base\Activate::activatePlugin();
}
register_activation_hook(__FILE__, 'activatePlugin');

/**
 * Code that runs during plugin deactivation
 */
function deactivatePlugin() {
  Inc\Base\Deactivate::deactivatePlugin();
}
register_deactivation_hook(__FILE__, 'deactivatePlugin');

/**
 * Code that runs during plugin uninstallation
 */
function uninstallPlugin() {
  Inc\Base\Uninstall::uninstallPlugin();
}
register_uninstall_hook(__FILE__, 'uninstallPlugin');

// Initialize all the core classes of the plugin
if(class_exists('Inc\\Init')) {
  Inc\Init::register_services();
}