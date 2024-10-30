<?php
/**
 * @package LinkvertiseScriptApiPlugin
 */

namespace Inc\Base;

class BaseController
{
  public $plugin_path;
  public $plugin_url;
  public $plugin;
  public $linkvertise_api_script_url = 'https://linkvertise.net/cdn/linkvertise.js';
  public $plugin_languages_path;
  public $translationFileDE;

  public function __construct() {
    $this->plugin_path = plugin_dir_path(dirname(__FILE__, 2));
    $this->plugin_url = plugin_dir_url(dirname(__FILE__, 2));
    $this->plugin = plugin_basename(dirname(__FILE__, 3)) . '/linkvertise-script-api.php';
    $this->plugin_languages_path = '/languages/';
    $this->translationFileDE = 'linkvertise-script-api-de_DE.mo';
  }
}