<?php
/**
 * @package LinkvertiseScriptApiPlugin
 */

namespace Inc\Base;

use \Inc\Base\BaseController;

class Enqueue extends BaseController
{  
  public function register() {
     add_action('admin_enqueue_scripts', array($this, 'enqueueAdminScripts'));
     add_action('wp_enqueue_scripts', array($this, 'enqueueScripts'));
     //add_action('wp_enqueue_scripts', array($this, 'enqueueBaseScripts'));
  }  

  /**
   * This function enqueues required external scripts
   * which are needed for further execution
   */
  public function enqueueBaseScripts() { }

  /**
   * This function enqueues the linkvertise full script api
   * script
   */
  public function enqueueScripts() 
  {
    $scriptApiSettings = get_option( 'linkvertise_script_api_settings' );
    $status = isset( $scriptApiSettings['linkvertise_script_api_status']) ? $status = $scriptApiSettings['linkvertise_script_api_status'] : false;
    $accountId = isset( $scriptApiSettings['linkvertise_acc_id']) ? $accountId = $scriptApiSettings['linkvertise_acc_id'] : '';
    $blacklisted = isset( $scriptApiSettings['linkvertise_blacklisted']) ? ($scriptApiSettings['linkvertise_blacklisted'] ? true : false) : false;
    $urls = isset( $scriptApiSettings['linkvertise_ext_links']) ? $urls = $scriptApiSettings['linkvertise_ext_links'] : '';

    $urls_str = '';
    $urls_arr = explode( ";", $urls );
    $domainsCount = count( $urls_arr );

    if( $domainsCount > 1 || ( $domainsCount == 1 && !empty( $urls_arr[0] ) ) ) {
      for( $i = 0; $i < count($urls_arr); $i ++ ) {
        
        if( $i > 0) {
          $urls_str = $urls_str . ',';
        }

        $urls_str = $urls_str . '"' . preg_replace('/\s+/', '', $urls_arr[$i]) . '"';
      }
    }

    $scriptData;

    if( $blacklisted ) {
      $scriptData = 'whitelist: [], blacklist: [' . $urls_str . ']';
    }
    else {
      $scriptData = 'whitelist: [' . $urls_str . '], blacklist: []';
    }

    if( $status ) {
      wp_register_script( 'linkvertise_full_script_api', $this->linkvertise_api_script_url, array(), null );
      wp_enqueue_script( 'linkvertise_full_script_api');
      wp_add_inline_script( 
        'linkvertise_full_script_api',
        'linkvertise(' . $accountId . ', {' . $scriptData . '});',
        'after'
      );
    }
  }

  /**
   * This function enqueues the required assets (styles, scripts ...)
   * for the admin pages
   */
  public function enqueueAdminScripts() 
  {
    // Register the script
    wp_register_script( 'linkvertiseScriptApiJS', $this->plugin_url . 'assets/admin.js' );

    // Localize the script with new data
    $translation_array = array(
      'blacklist_description_title' => __( 'Monetize all external links.', 'linkvertise-script-api' ),
      'blacklist_description' => __( 'Blacklist certain domains (won\'t be monetized).', 'linkvertise-script-api' ),
      'whitelist_description_title' => __( 'Monetize only certain external links.', 'linkvertise-script-api' ),
      'whitelist_description' => __( 'Only enter the domains you want to monetize.', 'linkvertise-script-api' )
    );
    wp_localize_script( 'linkvertiseScriptApiJS', 'translated_strings', $translation_array );

    // Enqueued script with localized data.
    wp_enqueue_script( 'linkvertiseScriptApiJS' );

    wp_enqueue_style('linkvertiseScriptApiStyle', $this->plugin_url . 'assets/style.css');
    //wp_enqueue_script('linkvertiseScriptApiJS', $this->plugin_url . 'assets/admin.js');
  }
}