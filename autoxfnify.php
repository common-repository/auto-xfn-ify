<?php
/*
Plugin Name: Auto XFN-ify
Version: 1.1
Plugin URI: http://www.slackspace.net/wordpress-plugins/auto-xfn-ify.php
Description: This Plugin automatically adda XFN rel attributes to links (based on the XFN data stored for links in your blogroll admin section) in all posts which link to someone in your blogroll.  This way you don't have to add them manualy each time you link to someone, and as you update/add/remove links and XFN data in your wp-admin blogroll area, all links on your site are automatically updated with appropriate XFN attributes.  The plug can optional (when theme supported) include XFN icons next to links in your posts.
Author: David Meade
Author URI: http://www.DavidMeade.com
*/

function autoxfnify_install() {
	//global $wpdb;
	// do stuff
}


function autoxfnify_getRelLinks() {
	global $wp_version, $wpdb;
	$sql = "SELECT link_url, link_rel FROM `wp_links` WHERE `link_rel` != ''";
	$rels = $wpdb->get_results($sql, ARRAY_A, 0);

  $num_records = count($rels);
  return $rels;
}


function autoxfnify_xfninfy($postText = '') {
  $xfnifiedPost = $postText;
  $blogroll = "";
	$debug_info = "<!-- XFNify Debuf info:\n===============\n";
	$linkcount = 0;
	
	$blogrollLinks_withRels = autoxfnify_getRelLinks();
	
  foreach ($blogrollLinks_withRels as $lwr) :
    //$relvals[$lwr['link_url']] =	preg_split("/ /", $lwr['link_rel']);
      
    $link_raw = trim($lwr['link_url']);	
		$link_safe = rtrim($link_raw, "/");	
    $link_safe = str_replace("\r", "",  $link_safe); 
    $link_safe = str_replace("\n", "",  $link_safe);      
    $link_safe = str_replace("/", "\/", $link_safe);
    $link_safe = str_replace(".", "\.", $link_safe);
    $link_safe = str_replace("?", "\?", $link_safe);		
    $link_safe = str_replace("#", "\#", $link_safe);	

    $httpPos = stripos($link_safe, 'http:\/\/');
	  $wwwPos = stripos($link_safe, 'www\.');
		if ($wwwPos === false) {
		 // lets add (www\.)? after the http:\/\/
     $link_safe = str_ireplace("http:\/\/", "http:\/\/(www\.)?", $link_safe);		 
		}
		else {
		 // lets replace www\. with (www\.)?
		 $link_safe = str_ireplace("www\.", "(www\.)?", $link_safe);
		}
  
    $blogroll = $link_safe;
    $new_rels = " rel=\"$lwr[link_rel]\" ";  
		//$linkPattern = "/(<\s?a\shref\s?=[\s\"\'])($blogroll\/?)([\s\"\']{1,3})([^>]+)?(>)([^<]+)(<\/a>)/i";
    $linkPattern = "/(<\s*?a\b[^>]*?\bhref\s*?=[\s\"\'])($blogroll\/?)([\s\"\']{1,3})([^>]+)?(>)([^<]+)(<\/a>)/i";
     /*
       1 = <a href="
       2 = link url
       3 = www.
			 4 = /"
       5 = other a tag attributes
       6 = >
       7 = linked text
       8 = </a>
      */
		$replacement = '$1$2$4'. $new_rels .'$5$6$7$8';
		
		$debug_info .= "pass $linkcount:\nlinkraw: $link_raw\nlinksafe=$blogroll\n$new_rels\nPattern: $linkPattern\nreplacement: $replacement\n\n";
	  
		$xfnifiedPost = preg_replace($linkPattern, $replacement, $xfnifiedPost);
		
    ++$linkcount;
  endforeach;
	
	$debug_info .= " -->";
	
	//$xfnifiedPost .=  $debug_info; 
	
	return $xfnifiedPost;
}

function autoxfnify_addcss() {
  $includeCSS = get_option('autoxfnify_includeCSS');

	if ($includeCSS == 'true') {
	 $cssURL = get_bloginfo('wpurl'). "/" . PLUGINDIR . "/auto-xfn-ify/autoxfnify.css";
	 print "<link rel=\"stylesheet\" href=\"$cssURL\" type=\"text/css\" media=\"screen\" />";
	}
}

function autoxfnify_menu() {
  add_options_page(
    'Auto XFN-ify',         //Title
    'Auto XFN-ify',         //Sub-menu title
    'manage_options', //Security
    __FILE__,         //File to open
    'autoxfnify_menu_options'  //Function to call
  );  
}

 function autoxfnify_menu_options () {
      echo '<div class="wrap"><h2>Auto XFN-ify Options</h2>';
      if ($_REQUEST['submit']) {
           update_autoxfnify_options();
      }
      print_autoxfnify_form();
      echo '</div>';
 }

  function print_autoxfnify_form () {
    $includeCSS = get_option('autoxfnify_includeCSS');
    ?>   
    <form method="post">
    <label>Include XFN styles <i style="font-size: .75em">(icons next to XFN lins)</i>?</label><br />
    <input type="radio" name="autoxfnify_includeCSS" value="true" <?php if ($includeCSS == "true") echo "CHECKED"  ?>/> Yes<br />
    <input type="radio" name="autoxfnify_includeCSS" value="false" <?php if ($includeCSS == "false") echo "CHECKED"  ?> /> No<br />
    <br />
    <input type="submit" name="submit" value="Submit" />
    </form>
    <?php
  }

  function update_autoxfnify_options() {
    $updated = false;
    if ($_REQUEST['autoxfnify_includeCSS']) {
         update_option('autoxfnify_includeCSS', $_REQUEST['autoxfnify_includeCSS']);
         $updated = true;
    }
    if ($updated) {
          echo '<div id="message" class="updated fade">';
          echo '<p>Options Updated</p>';
          echo '</div>';
    } else {
          echo '<div id="message" class="error fade">';
          echo '<p>Unable to update options</p>';
          echo '</div>';
    }
  }

 

////////////////////////////////////////////////

add_action('activate_autoxfnify.php', 'autoxfnify_install');
add_filter('the_content', 'autoxfnify_xfninfy');
add_action('wp_head', 'autoxfnify_addcss');
add_action('admin_menu','autoxfnify_menu');

////////////////////////////////////////////////

?>
