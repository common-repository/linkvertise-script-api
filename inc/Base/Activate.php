<?php
/**
 * @package LinkvertiseScriptApiPlugin
 */

namespace Inc\Base;

class Activate
{  
  public static function activatePlugin() 
  {
    // Bring our translation file into place
    $src_translation_file = plugin_dir_path( dirname (__FILE__, 2) ) . '/languages/linkvertise-script-api-de_DE.mo';
    $dest_translation_file = get_home_path() . '/wp-content/languages/plugins/linkvertise-script-api-de_DE.mo';

    if ( ! copy ( $src_translation_file, $dest_translation_file ) ) {
      echo "Error while copying the translation file.";
    }

    flush_rewrite_rules();
  }
}