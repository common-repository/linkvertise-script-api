<?php 
/**
 * @package  LinkvertiseScriptApiPlugin
 */
namespace Inc\Util;

class Sanitizers
{
  public function baseSanitize( $input )
  {
    if ( isset( $input) ) {
      $input = strip_tags( stripslashes( $input ) );
      $input = preg_replace('/\s+/', '', $input);
    }

    return $input;
  }

  public function removeEmptyDomainEntries( $input )
  {
    if ( isset( $input) ) {
      
      $domains_arr = explode( ";", $input );
    
      for( $i = 0; $i < count( $domains_arr ); $i ++ ) {
        $domains_arr[$i] = preg_replace('/\s+/', '', $domains_arr[$i]);
        if( empty( $domains_arr[$i] ) ) {
          array_splice( $domains_arr, $i, 1 );
          $i --;
        }
      }
        
      if( count( $domains_arr ) > 1 ) {
        return implode( ";", $domains_arr );
      }
      else if( count( $domains_arr ) == 1 ) {
        return $domains_arr[0];  
      }
    }
  }
}