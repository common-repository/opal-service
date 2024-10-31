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
class Opalrestaurant_Taxonomy_Tags{

	/**
	 *
	 */
	public static function init(){
		add_action( 'init', array( __CLASS__, 'definition' ) );
		add_filter( 'opalservice_taxomony_tags_metaboxes', array( __CLASS__, 'metaboxes' ) );
	}

	/**
	 *
	 */
	public static function definition(){
		
		$labels = array(
			'name'              => __( 'Tags', 'opal-service' ),
			'singular_name'     => __( 'Tag', 'opal-service' ),
			'search_items'      => __( 'Search Tags', 'opal-service' ),
			'all_items'         => __( 'All Tags', 'opal-service' ),
			'parent_item'       => __( 'Parent Tag', 'opal-service' ),
			'parent_item_colon' => __( 'Parent Tag:', 'opal-service' ),
			'edit_item'         => __( 'Edit Tag', 'opal-service' ),
			'update_item'       => __( 'Update Tag', 'opal-service' ),
			'add_new_item'      => __( 'Add New Tag', 'opal-service' ),
			'new_item_name'     => __( 'New Tag', 'opal-service' ),
			'menu_name'         => __( 'Tags', 'opal-service' ),
		);
		 $slug_field = opalservice_get_option( 'slug_tags_service' );
        $slug = isset($slug_field) ? $slug_field : "service_tags";
		register_taxonomy( 'opalservice_tags', 'opal_service', array(
			'labels'            => apply_filters( 'opalservice_taxomony_tags_labels', $labels ),
			'hierarchical'      => true,
			'query_var'         => 'service-tags',
			'rewrite'           => array('slug' => $slug),
			'public'            => true,
			'show_ui'           => true,
		) );
	}

	public static function metaboxes(){

	}


}

Opalrestaurant_Taxonomy_Tags::init();