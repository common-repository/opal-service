<?php 
/**
 * $Desc$
 *
 * @version    $Id$
 * @package    opalservice
 * @author     Opal  Team <opalwordpressl@gmail.com >
 * @copyright  Copyright (C) 2016 wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/support/forum.html
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 *
 */
function opalservice_template_init(){
	if( isset($_GET['display']) && ($_GET['display']=='list' || $_GET['display']=='grid') ){  
		setcookie( 'opalservice_displaymode', trim($_GET['display']) , time()+3600*24*100,'/' );
		$_COOKIE['opalservice_displaymode'] = trim($_GET['display']);
	}
}

add_action( 'init', 'opalservice_template_init' );

function opalservice_get_current_url(){

	global $wp;
	$current_url = home_url(add_query_arg(array(),$wp->request));
 	
 	return $current_url;
}

/**
* |----------------------------------------
* | Single Service
* |----------------------------------------
*/ 

/**
 * single content
 */
function opal_service_content(){
	echo Opalservice_Template_Loader::get_template_part( 'single-service/content' );
}
/**
 * single price list
 */
function opal_service_other_service(){
	echo Opalservice_Template_Loader::get_template_part( 'single-service/other-service' );
}

/**
 * single contact
 */
function opal_service_contact(){
	echo Opalservice_Template_Loader::get_template_part( 'single-service/contacts' );
}

//--
add_action( 'opalservice_single_service_content', 'opal_service_content', 10 );
//--

//add_action( 'opalservice_after_single_service_summary', 'opal_service_tags', 35 );

/**
 * Set sidebar position
 */
function opalservice_sidebar_archive_position( $pos ){
    if( is_single() && get_post_type() == 'opal_service' ){
        return get_theme_mod( 'opalservice_sidebar_single_position' );
    }
    return $pos; 
}
add_filter( 'opalservice_sidebar_archive_position', 'opalservice_sidebar_archive_position' );


function service_loop_layouts(){
	return apply_filters(
		'service_loop_layouts', array(
		    'grid_v1'       => 'Grid_V1 (Default)',
            'grid_v2'       => 'Grid_v2 (Absolute Elements)',
            'grid_v3'       => 'Grid_v3 (Show Icon)',
            'list_v1'       => 'List_v1 (Default)',
            'list_v2'       => 'List_v2 (List Icon)',
            'list_v3'       => 'List_v3 (List Number)',
		)
	);
}
