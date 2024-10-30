<?php 
/**
 * @package  LinkvertiseScriptApiPlugin
 */
namespace Inc\Util;

class DomainTools
{
  /**
   * This method returns the domain name where the script is executed.
   * If both $_SERVER variables are unset, it returns an empty string.
   * 
   * @return domainName the domain name as a string
   */
  public function getOwnDomainName()
  {
    if( isset( $_SERVER['SERVER_NAME'] ) ) {
      return $_SERVER['SERVER_NAME'];
    }
    else if ( isset ( $_SERVER['HTTP_HOST'] ) ) {
      return $_SERVER['HTTP_HOST'];
    }

    return '';
  }
}