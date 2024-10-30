<?php 
/**
 * @package  LinkvertiseScriptApiPlugin
 */
namespace Inc\Util;

class Validators
{
  /**
   * Validates a list of domains
   * 
   * @param string     the array of domains
   * @return boolean  valid or invalid array
   */
  public function domainsValid( string $domains )
  {
    $domains_arr = explode( ";", $domains );

    if( $this->hasDuplicates( $domains_arr )) {
      return false;
    }
    // for( $i = 0; $i < count($urls_arr); $i ++ ) {
    //   $domain_name = preg_replace('/\s+/', '', $urls_arr[$i]);
    //   if(!preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain_name) //valid chars check
    //   || !preg_match("/^.{1,253}$/", $domain_name) //overall length check
    //   || !preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain_name)) {
    //     return false;
    //   }
    // }

    return true;
  }

  private function hasDuplicates( $arr )
  {
    $dupArr = array();
    foreach ( $arr as $val ) {
      if ( ++$dupArr[$val] > 1 ) {
          return true;
      }
    }
    return false;
  }
}