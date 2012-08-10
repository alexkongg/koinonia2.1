<?php
/*
Plugin Name: GP Shortcoder
Plugin URI: http://www.acts2fellowship.org/riverside
Description: Shortcode generator with tinyMCE plugins to allow for easier styling and editing for fellowship sites
Version: 1.0
Author: Brian Wang
Author URI: http://www.acts2fellowship.org/riverside
*/

/*
*	Caption position = left, right, bottom
*/

function location_parser ($location) {
	$maplink = null;
	if ($atpos = strpos($location, '@')) {
		$maplink = trim(substr($location, $atpos+1));
		$location = trim(substr($location, 0, $atpos));
	}
	return array($location, $maplink);
}
 
function resizeflickrimage($imgurl, $tosize = '_m') {
	if (strpos($imgurl, 'flickr')) {
		// $imgurl can be smtg like: 
		//	* http://farm3.static.flickr.com/2584/3926130749_52dd4b2f5b_x.jpg, where 'x' is {t,m,b,o}
		//	* http://farm3.static.flickr.com/2584/3926130749_52dd4b2f5b.jpg

		if (substr($imgurl, -6, 1) == '_') $index = -6; // if there's an underscore
		else $index = -4;

		if (substr($imgurl, -6, 2) == '_b') $imgurl = $imgurl;
		else $imgurl = substr($imgurl, 0, $index) . $tosize . '.jpg'; // change the suffix
	}
	return $imgurl;
}

function photo_big($url, $caption) {
	$code = "";
	$url = resizeflickrimage($url, '_b');
	
	$code .= "<figure class=\"photo big grid_12 alpha\">";
	$code .= "	<img title=\"${caption}\" src=\"${url}\" alt=\"\" />";
	if ($caption != "") {
		$code .= "  <figcaption class=\"caption\">${caption}</figcaption>";
	}
	$code .= "</figure>";
	return $code;
}

function photo_regular($url, $caption, $legacycaption = '') {
	$code = "";
	$url = resizeflickrimage($url, '_b');
		
	$code .= "<figure class=\"photo prefix_2 grid_8 suffix_2 alpha\">";
	$code .= "	<img title=\"${caption}\" src=\"${url}\" alt=\"\" />";
	if ($caption != "") {
		$code .= "  <figcaption class=\"caption\">${caption}</figcaption>";
	}
	else if ($legacycaption != "") {
		$code .= "  <figcaption class=\"caption\">${legacycaption}</figcaption>";
	}
	$code .= "</figure>";
	return $code;
}

/*
 * cpos (caption position: left, right), type (multi, large),
 *
 */
function shortcode_photo($attr, $content) {	
	extract(shortcode_atts(array(
		'type' => 'regular',
	), $atts));
	
	$url = $attr['url'];
	$type = $attr['type'];
	$caption = trim($attr['caption']);
	$content = trim($content);
	
	// For Legacy Comments, next iteration remove this!
	if (!in_array($type, array('singlebottom', 'singleleft','large'))) {
		$content = "";
	}
	
	switch ($attr['type']) {
		case 'big':
			return photo_big($url, $caption);
		default: // regular
			return photo_regular($url, $caption, $content);
	}
}
add_shortcode('photo', 'shortcode_photo');

function shortcode_event($attr, $content) {
	extract(shortcode_atts(array(
		'title' => 'Please Supply A Valid Title',
	), $attr));
	$code = "";
	$date = trim($attr['date']);
	$time = trim($attr['time']);
	$location = trim($attr['location']);
	$info = trim($attr['info']);
	$anchor = trim($attr['anchor']);

	$code .= "<a name=\"${anchor}\"></a>";
	$code .= "<div class=\"upcoming-block\">";
	
	$code .= "<h4 class=\"datetime grid_8 prefix_2 suffix_2 alpha\">${date}";
	
	if($time != "") {
		$code .= ", ${time}</h4>";
	}else{
		
		$code .= "</h4>";
	}
	
	$code .= "<div class=\"stripes grid_2 alpha\">&nbsp;</div>";
	$code .= "<div class=\"upcoming-info grid_8 suffix_2 omega\">";
	$code .= "<h3>${content}</h3>";
	$code .= "<h4>";
	
	// Location will generate a Google Map link if:
	// * your location is like this: Stratton Community Center @ 2008 Martin Luther King Blvd, Riverside CA
	// * generates: <maplink>Stratton Community Center</maplink>
	if($location != ""){
		$locarr = location_parser($location);
		$location = $locarr[0];
		$maplink = $locarr[1];
		
		if($maplink != "") {
			$code .= "<span class=\"location\"><a href=\"http://maps.google.com/?q=${maplink}\" target=\"new\">${location}</a></span>";
		}
		else {
			$code .= "<span class=\"location\">${location}</span>";
		}
	}
	
	if($info != ""){
		$code .= "<span class=\"otherinfo\">(${info})</span>";
	}
	
	$code .= "</h4>";
	
	
	$code .= "</div>";
	$code .= "</div>";
	
	return $code;
}
add_shortcode('event', 'shortcode_event');

function shortcode_video($attr, $content) {
	extract(shortcode_atts(array(
		'id' => 'Invalid Id',
		'width'   => '809',
		'height'  => '455',
	), $attr));
	$code = "";
	
	$vimeoid = trim($attr['vimeoid']);
	$width = trim($attr['width']);
	$height = trim($attr['height']);
	
	if ($width == "");
		$width = "809";
	if ($height == "")
		$height = "455";

	$code .="	<div class=\"video grid_12 alpha\">";
	$code .="	    <div class=\"video-inner\">";
	$code .="	        <iframe src=\"http://player.vimeo.com/video/${id}?title=0&amp;byline=0&amp;portrait=0&amp;color=FDD91C\" width=\"${width}\" height=\"${height}\" frameborder=\"0\"></iframe>";
	$code .="	    </div>";
	$code .="	</div>";
	
	return $code;
}
add_shortcode('video', 'shortcode_video');

/*
*  plugins - Extend the MCE editor
*/

function gpphoto_addbuttons() {
   // Don't bother doing this stuff if the current user lacks permissions
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
     return;
 
   // Add only in Rich Editor mode
   if ( get_user_option('rich_editing') == 'true') {
     add_filter("mce_external_plugins", 'add_gpphoto_tinymce_plugin');
     add_filter("mce_buttons", 'register_gpphoto_button');
   }
}
 
function register_gpphoto_button($buttons) {
   array_splice($buttons, 4, 0, array('|', 'gpphoto', 'gpvideo', 'gpevent','hr'));
   return $buttons;
}
 
// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
function add_gpphoto_tinymce_plugin($plugin_array) {
   $plugin_array['gpphoto'] = get_bloginfo('wpurl') . '/wp-content/plugins/gpphoto/editor_plugin.js';
   $plugin_array['gpvideo'] = get_bloginfo('wpurl') . '/wp-content/plugins/gpvideo/editor_plugin.js';
   $plugin_array['gpevent'] = get_bloginfo('wpurl') . '/wp-content/plugins/gpevent/editor_plugin.js';
   return $plugin_array;
}
 
// init process for button control
add_action('init', 'gpphoto_addbuttons');

// remove old media buttons
add_action( 'media_buttons_context' , 'remove_media' );
function remove_media() {
	return;
}

?>
