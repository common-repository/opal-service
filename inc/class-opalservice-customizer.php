<?php
/**
 * Service Customizer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Select sanitization function
 *
 * @param string               $input   Slug to sanitize.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string Sanitized slug if it is a valid choice; otherwise, the setting default.
 */
function opalservice_theme_slug_sanitize_select( $input, $setting ){

		// Ensure input is a slug (lowercase alphanumeric characters, dashes and underscores are allowed only).
		$input = sanitize_key( $input );

		// Get the list of possible select options.
		$choices = $setting->manager->get_control( $setting->id )->choices;

		// If the input is a valid key, return it; otherwise, return the default.
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                

}
    	
/**
 * Register individual settings through customizer's API.
 *
 * @param WP_Customize_Manager $wp_customize Customizer reference.
 */    	
if ( ! function_exists( 'opalservice_post_layout_customize_register' ) ) {
	
	function opalservice_post_layout_customize_register( $wp_customize ) {

		 
		// Theme layout settings.
		$wp_customize->add_section( 'opalservice_service_options', array(
			'title'       => esc_html__( 'Service Settings', 'opal-service' ),
			'capability'  => 'edit_theme_options',
			'description' => esc_html__( 'Set Service layout display in varials style and design', 'opal-service' ),
			'priority'    => 3,
		) );

		// single Service 
		$wp_customize->add_setting( 'opalservice_sidebar_archive_position', array(
			'default'           => 'right',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'capability'        => 'edit_theme_options',
		) );

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'opalservice_sidebar_archive_position', array(
					'label'       => esc_html__( 'Archive Sidebar Position', 'opal-service' ),
					'description' => esc_html__( 'Set sidebar\'s default position. Can either be: right, left, both or none. Note: this can be overridden on individual pages.',
					'opal-service' ),
					'section'     => 'opalservice_service_options',
					'settings'    => 'opalservice_sidebar_archive_position',
					'type'        => 'select',
					'sanitize_callback' => 'opalservice_theme_slug_sanitize_select',
					'choices'     => array(
						'right' => esc_html__( 'Right sidebar', 'opal-service' ),
						'left'  => esc_html__( 'Left sidebar', 'opal-service' ),
						'both'  => esc_html__( 'Left & Right sidebars', 'opal-service' ),
						'none'  => esc_html__( 'No sidebar', 'opal-service' ),
					),
					'priority'    => '20',
				)
		) );

		// single Service 
		$wp_customize->add_setting( 'opalservice_sidebar_single_position', array(
			'default'           => 'right',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'capability'        => 'edit_theme_options',
		) );

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'opalservice_sidebar_single_position', array(
					'label'       => esc_html__( 'Single Sidebar Position', 'opal-service' ),
					'description' => esc_html__( 'Set sidebar\'s default position. Can either be: right, left, both or none. Note: this can be overridden on individual pages.',
					'opal-service' ),
					'section'     => 'opalservice_service_options',
					'settings'    => 'opalservice_sidebar_single_position',
					'type'        => 'select',
					'sanitize_callback' => 'opalservice_theme_slug_sanitize_select',
					'choices'     => array(
						'right' => esc_html__( 'Right sidebar', 'opal-service' ),
						'left'  => esc_html__( 'Left sidebar', 'opal-service' ),
						'both'  => esc_html__( 'Left & Right sidebars', 'opal-service' ),
						'none'  => esc_html__( 'No sidebar', 'opal-service' ),
					),
					'priority'    => '20',
				)
		) );


		/// enable or disable preloader 
	}
} // endif function_exists( 'opalservice_theme_customize_register' ).
add_action( 'customize_register', 'opalservice_post_layout_customize_register' );

/**
 * Automatic set default values for postion and style, containner width after active the theme.
 */
add_action( 'after_setup_theme', 'opalservice_setup_theme_default_settings' );
if ( ! function_exists ( 'opalservice_setup_theme_default_settings' ) ) {
	function opalservice_setup_theme_default_settings() {

		// check if settings are set, if not set defaults.
		// Caution: DO NOT check existence using === always check with == .
		// Sidebar position.
		$opalservice_sidebar_archive_position = get_theme_mod( 'opalservice_sidebar_archive_position' );
		if ( '' == $opalservice_sidebar_archive_position ) {
			set_theme_mod( 'opalservice_sidebar_archive_position', 'none' );
		}

		// Container width.
		$opalservice_sidebar_single_position = get_theme_mod( 'opalservice_sidebar_single_position' );
		if ( '' == $opalservice_sidebar_single_position ) {
			set_theme_mod( 'opalservice_sidebar_single_position', 'none' );
		}

		
	}
}
?>