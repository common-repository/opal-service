<?php

add_action( 'widgets_init', 'opalservice_widgets_init' );

if ( ! function_exists( 'opalservice_widgets_init' ) ) {
	/**
	 * Initializes themes widgets.
	 */
	function opalservice_widgets_init() {
		register_sidebar( array(
			'name'          => esc_html__( 'Right Sidebar Service', 'opal-service' ),
			'id'            =>  'right-sidebar-service',
			'description'   => esc_html__( 'Right sidebar service widget area', 'opal-service' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Left Sidebar Service', 'opal-service' ),
			'id'            => 'left-sidebar-service',
			'description'   => esc_html__( 'Left sidebar service widget area', 'opal-service' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}
} // endif function_exists( 'opalservice_widgets_init' ).