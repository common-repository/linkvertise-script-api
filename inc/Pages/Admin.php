<?php
/**
 * @package LinkvertiseScriptApiPlugin
 */

namespace Inc\Pages;

use \Inc\Base\BaseController;
use \Inc\Api\SettingsApi;
use \Inc\Api\Callbacks\AdminCallbacks;
use \Inc\Util\DomainTools;

class Admin extends BaseController
{
  private $domainTools;

  public $settings;

  public $callbacks;

  public $pages = array();
  
  public $subpages = array();
  
	public function register() 
	{
    $this->settings = new SettingsApi();

    $this->callbacks = new AdminCallbacks();

    $this->domainTools = new DomainTools();

    $this->setPages();

    $this->setSubpages();

    $this->setSettings();
    
    $this->setSections();
    
    $this->setFields();
    
    $this->setDefaultFields();
    
    $this->settings->addPages( $this->pages )->withSubPage( __("Settings", "linkvertise-script-api") )->addSubPages( $this->subpages )->register();
    $this->callbacks->register();
  }
  
  public function setPages()
  {
    $this->pages = array(
			array(
				'page_title' => 'Linkvertise Script API', 
				'menu_title' => 'Linkvertise', 
				'capability' => 'manage_options', 
				'menu_slug' => 'linkvertise_script_api', 
				'callback' => array( $this->callbacks, 'adminSettings' ), 
				'icon_url' => 'dashicons-admin-links', 
				'position' => 110
			)
		);
  }

  public function setSubpages() 
  {
    $this->subpages = array(
			array(
				'parent_slug' => 'linkvertise_script_api', 
				'page_title' => __('Help', 'linkvertise-script-api'), 
				'menu_title' => __('Help', 'linkvertise-script-api'), 
				'capability' => 'manage_options', 
				'menu_slug' => 'linkvertise_script_api_help', 
				'callback' => array( $this->callbacks, 'adminHelp' ), 
			)
		);
  }

  public function setSettings()
	{
		$args = array(
			array(
				'option_group' => 'linkvertise_script_api_options_group',
				'option_name' => 'linkvertise_script_api_settings',
        'callback' => array( $this->callbacks, 'saveScriptAPISettingsInput' )
      )
		);

		$this->settings->setSettings( $args );
	}

	public function setSections()
	{
		$args = array(
			array(
				'id' => 'linkvertise_script_api_main_settings',
				'title' => __('Settings', 'linkvertise-script-api'),
				'callback' => array( $this->callbacks, 'linkvertiseScriptApiMainSettingsSection' ),
				'page' => 'linkvertise_script_api_plugin'
      ),
      array(
				'id' => 'linkvertise_script_api_ext_link_list',
				'title' => __('External Links', 'linkvertise-script-api'),
				'callback' => array( $this->callbacks, 'linkvertiseScriptApiExtLinkListSection' ),
				'page' => 'linkvertise_script_api_plugin'
			)
		);

		$this->settings->setSections( $args );
	}

	public function setFields()
	{
		$args = array(
      array(
        'id' => 'linkvertise_script_api_status',
        'title' => __('Activate Full Script API', 'linkvertise-script-api'),
        'callback' => array( $this->callbacks, 'displayScriptAPIStatus' ),
        'page' => 'linkvertise_script_api_plugin',
        'section' => 'linkvertise_script_api_main_settings'
      ),
			array(
				'id' => 'linkvertise_acc_id',
				'title' => 'Account ID',
				'callback' => array( $this->callbacks, 'displayScriptAPISettingsAccountId' ),
				'page' => 'linkvertise_script_api_plugin',
				'section' => 'linkvertise_script_api_main_settings'
      ),
      array(
				'id' => 'linkvertise_blacklisted',
				'title' => '',
				'callback' => array( $this->callbacks, 'displayScriptAPISettingsBlacklisted' ),
				'page' => 'linkvertise_script_api_plugin',
				'section' => 'linkvertise_script_api_ext_link_list'
      ),
      array(
				'id' => 'linkvertise_ext_links',
				'title' => 'Domains',
				'callback' => array( $this->callbacks, 'displayScriptAPISettingsUrls' ),
				'page' => 'linkvertise_script_api_plugin',
				'section' => 'linkvertise_script_api_ext_link_list'
      )
		);

		$this->settings->setFields( $args );
  }
  
  public function setDefaultFields()
  {
    $defaults = array(
      'linkvertise_script_api_status' => '0',
      'linkvertise_acc_id' => '',
      'linkvertise_blacklisted' => '1',
      'linkvertise_ext_links' => $this->domainTools->getOwnDomainName()
    );

    $this->settings->setDefaultFields( 'linkvertise_script_api_settings', $defaults );
  }
}