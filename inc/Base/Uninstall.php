<?php
/**
 * @package LinkvertiseScriptApiPlugin
 */

namespace Inc\Base;

class Uninstall
{  
  public static function uninstallPlugin() 
  {
    // Stop execution if WP variable is not set
    if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
      die();
    }
  
    // Remove settings from DB
    delete_option( 'linkvertise_script_api_settings' );
  }
}