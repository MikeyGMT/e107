<?php
//error_reporting(E_ALL); 


include_once(e_PLUGIN.'facebook/facebook_function.php' );

prevent_cache_headers();

/**
 * just define facebook XMLNS
 *
 */   


define(XMLNS,"xmlns:fb='http://www.facebook.com/2008/fbml'");

/**
 * Ensure "Make entering an email address optional" is setted to "ON";
 *
 */
 
global $pref;
   
if ( $pref['disable_emailcheck'] == 0 ) {

$pref['disable_emailcheck'] = 1;

save_prefs();

}


/**
 * when clicked it insert a new User
 *
 */  

  if ( e_QUERY == 'facebook' ) {

      Fb_Connect_Me();

    }

/**
 * simple Re-Login after logged out from e107
 *
 */  

  if ( e_QUERY == 'login' ) {

      Fb_LogIn();

    }

/**
 * simulate Facebook logOut when logged out from e107
 *
 */  

  if ( e_QUERY == 'logout') {

      Fb_LogOut();
  
    }


  if ( e_QUERY == 'facebook_switch') {

      Switch_Facebook_User();
  
    }
    
    
      if ( e_QUERY == 'facebook_delete') {

      Delete_Duplicate_Facebook_User();
  
    }

  function theme_foot(){


  /**
   * the init js needs to be at the bottom of the document, within the </body> tag
   * this is so that any xfbml elements are already rendered by the time the xfbml
   * rendering takes over. otherwise, it might miss some elements in the doc.
   *  
   */  

    global $onload_js;
 
    $text .= render_facebook_init_js( is_fb() );
  // Print out all onload function calls
  
  if ( $onload_js ) {
  
    $text .= '<script type="text/javascript">'
      .'window.onload = function() { ' . $onload_js . ' };'
      .'</script>';
  
      }
      return  $text;

    }

  
  
  /**
   *
   * Facebook Deprecated get Feed Story trough Template Bundle 2009
   *               
  
  function getTemplateData() {

    $template_data = array(
    'post_title' => $_POST[ 'subject' ],
	  'body' => $_POST[ 'comment' ],
	  'body_short' => $_POST[ 'comment' ],
	  'post_permalink' => e_SELF,
	  'blogname' => SITENAME,
	  'blogdesc' => SITEDESCRIPTION,
    'siteurl' => SITEURLBASE);

      return $template_data;
    }
    
    */
    
    
  /**
   * get Feed Story infos to send to Facebook
   * 
   * the new way FB.Connect.streamPublish();     
   *
   */
    
     function getStreamToPublish() {
     //global $pref;
       //$stream = facebook_client()->api_client->stream_get('','','','','',''.$pref[ 'Facebook_App-Bundle' ].'','');
      
     // $stream = facebook_client()->api_client->stream_publish($_POST[ 'comment' ]);
      
      return $_POST[ 'comment' ];
     }
    
    
  /**
   * if comment is submitted and "publish_to_facebook" is checked send a copy to Facebook
   *
   */        
  
  if ( isset( $_POST[ 'commentsubmit' ] ) && ( $_POST[ 'publish_to_facebook' ] == true ) ) {
  
      register_feed_form_js();
  
    }

?>