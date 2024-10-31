<?php
/**
 * $Desc$
 *
 * @version    $Id$
 * @package    opalestate
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
class Opalestate_Field_Map {

	/**
	 * Current version number
	 */
	const VERSION = '1.0.0';

	/**
	 * Initialize the plugin by hooking into CMB2
	 */
	public static function init() {
		add_filter( 'cmb2_render_opal_map', array( __CLASS__, 'render_map' ), 10, 5 );
		add_filter( 'cmb2_sanitize_opal_map', array( __CLASS__, 'sanitize_map' ), 10, 4 );
	}

	/**
	 * Render field
	 */
	public static function render_map( $field, $field_escaped_value, $field_object_id, $field_object_type, $field_type_object ) {
		self::setup_admin_scripts();
		echo '<input type="text" class="large-text opal-map-search" id="' . $field->args( 'id' ) . '" 
				name="'.$field->args( '_name' ).'[addess]" value="'.(isset( $field_escaped_value['address'] ) ? $field_escaped_value['address'] : '').'"/>';
		echo '<div class="opal-map"></div>';
		$field_type_object->_desc( true, true );

		echo $field_type_object->input( array(
			'type'       => 'text',
			'name'       => $field->args( '_name' ) . '[latitude]',
			'value'      => isset( $field_escaped_value['latitude'] ) ? $field_escaped_value['latitude'] : '',
			'class'      => 'opal-map-latitude',
			'desc'       => '',
		) );
		echo $field_type_object->input( array(
			'type'       => 'text',
			'name'       => $field->args( '_name' ) . '[longitude]',
			'value'      => isset( $field_escaped_value['longitude'] ) ? $field_escaped_value['longitude'] : '',
			'class'      => 'opal-map-longitude',
			'desc'       => '',
		) );

		echo '<p>You need register<a href="https://developers.google.com/maps/documentation/javascript/reference#Data.StyleOptions"> Google API Key </a>, then put the key in setting inside customizer,</p>';
	}

	/**
	 * Optionally save the latitude/longitude values into two custom fields
	 */
	public static function sanitize_map( $override_value, $value, $object_id, $field_args ) {
		if ( isset( $field_args['split_values'] ) && $field_args['split_values'] ) {
			if ( ! empty( $value['latitude'] ) ) {
				update_post_meta( $object_id, $field_args['id'] . '_latitude', $value['latitude'] );
			}

			if ( ! empty( $value['longitude'] ) ) {
				update_post_meta( $object_id, $field_args['id'] . '_longitude', $value['longitude'] );
			}

			if ( ! empty( $value['address'] ) ) {
				update_post_meta( $object_id, $field_args['id'] . '_address', $value['address'] );
			}
		}

		return $value;
	}

	/**
	 * Enqueue scripts and styles
	 */
	public static function setup_admin_scripts() {
		$key = 'AIzaSyDRVUZdOrZ1HuJFaFkDtmby0E93eJLykIk';
		$api = apply_filters( 'pbr_google_map_api',  '//maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&amp;key='.$key   );
		wp_register_script( 'pbr-google-maps-api',  $api, null, null );
		wp_enqueue_script( 'pbr-google-maps', plugins_url( 'js/script.js', __FILE__ ), array( 'pbr-google-maps-api' ), self::VERSION );
		wp_enqueue_style( 'pbr-google-maps', plugins_url( 'css/style.css', __FILE__ ), array(), self::VERSION );
	}
}

Opalestate_Field_Map::init();
