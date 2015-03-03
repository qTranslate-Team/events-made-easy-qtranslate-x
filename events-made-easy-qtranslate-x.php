<?php
/**
 * Plugin Name: Events Made Easy & qTranslate-X
 * Plugin URI: https://wordpress.org/plugins/events-made-easy-qtranslate-x
 * Description: Enables multilingual framework for plugin "Events Made Easy".
 * Version: 1.0
 * Author: qTranslate Team
 * Author URI: http://qtranslatexteam.wordpress.com/about
 * License: GPL2
 * Tags: multilingual, multi, language, translation, qTranslate-X, Events Made Easy
 * Author e-mail: qTranslateTeam@gmail.com
 */

if ( ! function_exists( 'add_filter' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if(is_admin()) :

define('QEME_VERSION','1.0');

//add_action('admin_enqueue_scripts','qeme_enqueue_scripts',11);
//function qeme_enqueue_scripts()
//{
//	remove_action('admin_head', 'eme_admin_map_script');//for now, not sure if it is needed, but it was breaking pages
//}

add_filter('qtranslate_compatibility', 'qeme_qtrans_compatibility');
function qeme_qtrans_compatibility($compatibility)
{
	return true;
}

add_filter('qtranslate_load_admin_page_config','qeme_add_admin_page_config');
function qeme_add_admin_page_config($page_configs)
{
	$page_config = array();

	/**
	 * ['pages'] tested against $pagenow & $_SERVER['QUERY_STRING'] like preg_match('!'.$page.'!',$pagenow)
	 * to enable use of regular expressions to identify pages, where fields need to become translatable.
	*/
	$page_config['pages'] = array( 'admin.php' => 'page=events-manager&eme_admin_action=edit_event' );

	$page_config['anchors'] = array( 'titlediv', 'div_event_notes' );//id of elements, at front of which the Language Switching Buttons are placed

	$page_config['forms'] = array();

	$f = array();
	$f['form'] = array( 'id' => 'eventForm' );//identify the form which fields described below belong to

	/**
	 * List of all translatable fields within the form on the page.
	 * Possible attributes for a field: 'tag', 'id', 'class', 'name', 'encode'
	 * No need to specify all possible attributes, but enough to define the field uniquely.
	 */
	$f['fields'] = array();
	$fields = &$f['fields']; // shortcut

	/**
	 * 'encode' here is excessive, since its value coincides with the default,
	 * but it does not hurt to show it for the clarity.
	 * '<' means to encode the multilingual field with <!--:--> kind of language tags (default for textarea).
	 * '[' means to encode the multilingual field with [:] kind of language tags (default for all input fields except textarea).
	 * 'd' means that the filed is used to display multilingual value in its innerHTML or attributes.
	 */
	$fields[] = array( 'id' => 'title', 'encode' => '[' );

	/**
	 * 'encode' is also excessive here, the default for textarea is '<'
	 */
	$fields[] = array( 'id' => 'content', 'encode' => '<' );

	$fields[] = array( 'id' => 'event_page_title_format' );// 'encode' by default, will be '<'
	$fields[] = array( 'id' => 'event_single_event_format' );
	$fields[] = array( 'id' => 'event_contactperson_email_body' );
	$fields[] = array( 'id' => 'event_registration_recorded_ok_html' );
	$fields[] = array( 'id' => 'event_registration_updated_email_body' );
	$fields[] = array( 'id' => 'event_cancel_form_format' );
	$fields[] = array( 'id' => 'event_registration_form_format' );
	$fields[] = array( 'id' => 'event_respondent_email_body' );
	$fields[] = array( 'id' => 'event_registration_pending_email_body' );
	//and so on for fields

	$page_config['forms'][] = $f;
	//and so on for forms

	$page_configs[] = $page_config;
	//and so on for pages

	return $page_configs;
}

endif;
?>
