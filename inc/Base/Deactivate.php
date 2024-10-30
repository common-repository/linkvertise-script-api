<?php
/**
 * @package LinkvertiseScriptApiPlugin
 */

 namespace Inc\Base;

class Deactivate 
{  
  public function deactivatePlugin() {
    flush_rewrite_rules();

    // Remove translation file
    $translation_file = get_home_path() . '/wp-content/languages/plugins/linkvertise-script-api-de_DE.mo';

    if ( ! unlink ( $translation_file ) ) {
      echo "Error while removing the translation file.";
    }
  }
}