<?php
if(!defined('ABSPATH'))exit;

//add_action('admin_enqueue_scripts','qeme_enqueue_scripts',11);
//function qeme_enqueue_scripts()
//{
//	remove_action('admin_head', 'eme_admin_map_script');//for now, not sure if it is needed, but it was breaking pages
//}

add_filter('qtranslate_load_admin_page_config','qeme_add_admin_page_config');
function qeme_add_admin_page_config($page_configs)
{
	{//admin.php?page=events-manager
	$page_config = array();

	/**
	 * ['pages'] tested against $pagenow & $_SERVER['QUERY_STRING'] like preg_match('!'.$page.'!',$pagenow)
	 * to enable use of regular expressions to identify pages, where fields need to become translatable.
	*/
	$page_config['pages'] = array( 'admin.php' => 'page=events-manager&eme_admin_action=edit_event|page=events-manager&eme_admin_action=edit_recurrence|page=eme-new_event' );

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
	 * (obsolete) '<' means to encode the multilingual field with <!--:--> kind of language tags (default for textarea).
	 * (obsolete) '[' means to encode the multilingual field with [:] kind of language tags (default for all input fields except textarea).
	 * 'display' means that the filed is used to display multilingual value in its innerHTML or attributes.
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
	}

	{// for locations
	//admin.php?page=eme-locations&eme_admin_action=editlocation
	$page_config = array();
	$page_config['pages'] = array( 'admin.php' => 'page=eme-locations&eme_admin_action=editlocation' );
	$page_config['anchors'] = array( 'titlediv', 'loc_description' ); //id of elements, at front of which the Language Switching Buttons are placed
	$page_config['forms'] = array();
	$f = array();
	$f['form'] = array( 'id' => 'editloc' ); //identify the form which fields described below belong to
	$f['fields'] = array();
	$fields = &$f['fields']; // shortcut
	$fields[] = array( 'id' => 'title' );
	$fields[] = array( 'id' => 'content' );
	$fields[] = array( 'id' => 'location_address' );
	$fields[] = array( 'id' => 'location_town' );
	$page_config['forms'][] = $f;
	$page_configs[] = $page_config;
	}

	return $page_configs;
}
