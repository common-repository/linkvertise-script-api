<?php 
/**
 * @package  LinkvertiseScriptApiPlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;
use \Inc\Util\Validators;
use \Inc\Util\Sanitizers;

class AdminCallbacks extends BaseController
{
  public $validators;
  public $sanitizers;

  public function register()
  {
    $this->validators = new Validators();
    $this->sanitizers = new Sanitizers();
  }

	public function adminSettings()
	{
		return require_once( "$this->plugin_path/templates/admin.php" );
	}

	public function adminHelp()
	{
    return require_once( "$this->plugin_path/templates/help.php" );
  }

  public function saveScriptAPISettingsInput( $input )
	{
    $input_valid = true;
		$new_input = array();
    
    // Account ID
    $new_input['linkvertise_acc_id'] = $input['linkvertise_acc_id'];

    // Plugin Status
    $status = $input['linkvertise_script_api_status'];

    // Prevent API activation if account ID is empty
    if( $status && ( !isset( $input['linkvertise_acc_id'] ) || empty( $input['linkvertise_acc_id'] ) ) ) {

      add_settings_error( 
        'linkvertise_script_api_settings', 
        '', 
        __('Account ID is empty.', 'linkvertise-script-api')
      );

      $new_input['linkvertise_script_api_status'] = false;
    }
    else {
      $new_input['linkvertise_script_api_status'] = isset( $status ) ? true : false;
    }

    // Blacklisted
    $blacklisted = $input['linkvertise_blacklisted'];
    $new_input['linkvertise_blacklisted'] = isset( $blacklisted ) ? ($blacklisted ? true : false) : false;

    // Domains
    $domains = $input['linkvertise_ext_links'];
    
    if( !empty( $domains) ) {
      $new_input['linkvertise_ext_links'] = $this->sanitizers->removeEmptyDomainEntries( $this->sanitizers->baseSanitize( $domains ) );

      if(! $this->validators->domainsValid( $new_input['linkvertise_ext_links']) ) {
        
        add_settings_error( 
          'linkvertise_script_api_settings', 
          '', 
          __('Provided domains are invalid.', 'linkvertise-script-api')
        );

        $input_valid = false;
      }
    }
    
    if( $input_valid ) {
      return $new_input;  
    }
    
    return get_option( 'linkvertise_script_api_settings' );
	}

	public function linkvertiseScriptApiExtLinkListSection()
	{
    $scriptApiSettings = get_option( 'linkvertise_script_api_settings' );
    $blacklisted = isset( $scriptApiSettings['linkvertise_blacklisted']) ? ($scriptApiSettings['linkvertise_blacklisted'] ? true : false) : false;

    echo '<div id="linkvertiseScriptApiExtLinkListSection" class="ext-link-list-desc-container">';

    if( $blacklisted ) {
      echo '<p><b>' . __('Monetize all external links.', 'linkvertise-script-api') . '</p></b>';
      echo '<p>' . __('Blacklist certain domains (won\'t be monetized).', 'linkvertise-script-api') . '</p>';
    }
    else {
      echo '<p><b>' . __('Monetize only certain external links.', 'linkvertise-script-api') . '</p></b>';
      echo '<p>' . __('Only enter the domains you want to monetize.', 'linkvertise-script-api') . '</p>';
    }

    echo '</div>';
  }
  
  public function linkvertiseScriptApiMainSettingsSection()
	{
    return require_once( "$this->plugin_path/templates/adminMainSec.php" );
  }

	public function displayScriptAPISettingsAccountId()
	{
    $scriptApiSettings = get_option( 'linkvertise_script_api_settings' );
    $accountId = isset( $scriptApiSettings['linkvertise_acc_id']) ? $accountId = $scriptApiSettings['linkvertise_acc_id'] : '';
		echo '<input type="number" min="1000" max="99999999" name="linkvertise_script_api_settings[linkvertise_acc_id]" value="' . $accountId . '">';
  }

  public function displayScriptAPIStatus() 
  {
    $scriptApiSettings = get_option( 'linkvertise_script_api_settings' );
    $status = isset( $scriptApiSettings['linkvertise_script_api_status']) ? $status = $scriptApiSettings['linkvertise_script_api_status'] : false;
    echo '<input type="checkbox" id="linkvertise_script_api_settings" name="linkvertise_script_api_settings[linkvertise_script_api_status]" value="1" class="" ' . ( $status ? 'checked' : '') . '><label for="linkvertise_script_api_settings[linkvertise_script_api_status]"></label>';
  }

  public function displayScriptAPISettingsBlacklisted()
  {
    $scriptApiSettings = get_option( 'linkvertise_script_api_settings' );
    $blacklisted = isset( $scriptApiSettings['linkvertise_blacklisted']) ? ($scriptApiSettings['linkvertise_blacklisted'] ? true : false) : false;
    echo '<div id="radios" class="radio-btns-container">';
    echo '<div class="custom-radio-container"><input type="radio" id="radio_black" name="linkvertise_script_api_settings[linkvertise_blacklisted]" value="1" ' . ( $blacklisted ? 'checked' : '') . '><label for="radio_black" class="custom-radio-label">Blacklist</label></div>';
    echo '<div class="custom-radio-container"><input type="radio" id="radio_white" name="linkvertise_script_api_settings[linkvertise_blacklisted]" value="0" ' . ( !$blacklisted ? 'checked' : '') . '><label for="radio_white" class="custom-radio-label">Whitelist</label></div>';
    echo '</div>';
  }

  public function displayScriptAPISettingsUrls() 
  {
    $scriptApiSettings = get_option( 'linkvertise_script_api_settings' );
    $urls = isset( $scriptApiSettings['linkvertise_ext_links']) ? $urls = $scriptApiSettings['linkvertise_ext_links'] : '';
    $blacklisted = isset( $scriptApiSettings['linkvertise_blacklisted']) ? ($scriptApiSettings['linkvertise_blacklisted'] ? true : false) : false;
    $urls_arr = explode( ';', $urls );
    $domainsCount = count( $urls_arr );

    echo '<div class="ext-links-label">';
    echo '<label for="linkvertise_ext_links">' . __("Separate domains with ';'", "linkvertise-script-api") . '</label></div><textarea name="linkvertise_script_api_settings[linkvertise_ext_links]" id="linkvertise_ext_links" rows="8" cols="40" placeholder="Domain (e.g. youtube.com)">' . $urls . '</textarea>';

    /**
     * 2nd if statement because explode() returns an empty field if string
     * is empty or null
     */
    if( $domainsCount > 1 || ( $domainsCount == 1 && !empty( $urls_arr[0] ) ) ) {

      echo '<div class="domain-count-container">';

      printf(
        _n(
          '%s domain',
          '%s domains',
          $domainsCount,
          'linkvertise-script-api'
        ), 
        number_format_i18n( $domainsCount )
      );

      echo '&nbsp;';

      if($blacklisted) {
        printf(
          _n(
            'won\'t get monetized',
            'won\'t get monetized',
            $domainsCount,
            'linkvertise-script-api'
          ), 
          number_format_i18n( $domainsCount )
        );
      }
      else {
        printf(
          _n(
            'get monetized.',
            'get monetized.',
            $domainsCount,
            'linkvertise-script-api'
          ), 
          number_format_i18n( $domainsCount )
        );
      }
      echo '</div>';
    }  
  }
}