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

class Opalservice_Plugin_Settings {

	/**
	 * Option key, and option page slug
	 * @var string
	 */
	private $key = 'opalservice_settings';

	/**
	 * Array of metaboxes/fields
	 * @var array
	 */
	protected $option_metabox = array();

	/**
	 * Options Page title
	 * @var string
	 */
	protected $title = '';

	/**
	 * Options Page hook
	 * @var string
	 */
	protected $options_page = '';

	/**
	 * Constructor
	 * @since 1.0
	 */
	public function __construct() {

		add_action( 'admin_menu', array( $this, 'admin_menu' ) , 10 );

		add_action( 'admin_init', array( $this, 'init' ) );

		//Custom CMB2 Settings Fields
		add_action( 'cmb2_render_opalservice_title', 'opalservice_title_callback', 10, 5 );

		add_action( 'cmb2_render_api', 'opalservice_api_callback', 10, 5 );
		add_action( 'cmb2_render_license_key', 'opalservice_license_key_callback', 10, 5 );
		add_action( "cmb2_save_options-page_fields", array( $this, 'settings_notices' ), 10, 3 );

		// Include CMB CSS in the head to avoid FOUC
		add_action( "admin_print_styles-opalservice_service_page_opalservice-settings", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );

	}

	public function admin_menu() {
		//Settings
	 	$give_settings_page = add_submenu_page( 'edit.php?post_type=opal_service', __( 'Settings', 'opal-service' ), __( 'Settings', 'opal-service' ), 'manage_options', 'opalservice-settings', 
	 		array( $this, 'admin_page_display' ) );
	}

	/**
	 * Register our setting to WP
	 * @since  1.0
	 */
	public function init() {
		register_setting( $this->key, $this->key );

	}

	/**
	 * Retrieve settings tabs
	 *
	 * @since 1.0
	 * @return array $tabs
	 */
	public function opalservice_get_settings_tabs() {

		$settings = $this->opalservice_settings( null );

		$tabs             = array();
		$tabs['general']  = __( 'General', 'opal-service' );
		$tabs['pageview']  	= __( 'Page View', 'opal-service' );
		if ( ! empty( $settings['addons']['fields'] ) ) {
			$tabs['addons'] = __( 'Add-ons', 'opal-service' );
		}

		if ( ! empty( $settings['licenses']['fields'] ) ) {
			$tabs['licenses'] = __( 'Licenses', 'opal-service' );
		}

		return apply_filters( 'opalservice_settings_tabs', $tabs );
	}


	/**
	 * Admin page markup. Mostly handled by CMB2
	 * @since  1.0
	 */
	public function admin_page_display() {

		$active_tab = isset( $_GET['tab'] ) && array_key_exists( $_GET['tab'], $this->opalservice_get_settings_tabs() ) ? $_GET['tab'] : 'general';

		?>

		<div class="wrap opalservice_settings_page cmb2_options_page <?php echo $this->key; ?>">
			<h2 class="nav-tab-wrapper">
				<?php
				foreach ( $this->opalservice_get_settings_tabs() as $tab_id => $tab_name ) {

					$tab_url = esc_url( add_query_arg( array(
						'settings-updated' => false,
						'tab'              => $tab_id
					) ) );

					$active = $active_tab == $tab_id ? ' nav-tab-active' : '';

					echo '<a href="' . esc_url( $tab_url ) . '" title="' . esc_attr( $tab_name ) . '" class="nav-tab' . $active . '">';
					echo esc_html( $tab_name );

					echo '</a>';
				}
				?>
			</h2>

			<?php cmb2_metabox_form( $this->opalservice_settings( $active_tab ), $this->key ); ?>

		</div><!-- .wrap -->

		<?php
	}

	/**
	 * Define General Settings Metabox and field configurations.
	 *
	 * Filters are provided for each settings section to allow add-ons and other plugins to add their own settings
	 *
	 * @param $active_tab active tab settings; null returns full array
	 *
	 * @return array
	 */
	public function opalservice_settings( $active_tab ) {

		$opalservice_settings = array(
			/**
			 * General Settings
			 */
			'general'     => array(
				'id'         => 'options_page',
				'title' => __( 'General Settings', 'opal-service' ),
				'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key, ), ),
				'fields'     => apply_filters( 'opalservice_settings_general', array(
						array(
							'name' => __( 'Slug Link Setting', 'opal-service' ),
							'desc' => '<td><hr><p class="tags-description"><b>Note: When you edit Slug bellow you must apply them in left menu > Setting > Permalinks > Save Changes</b></p><hr></td>',
							'type' => 'title',
							'id'   => 'opalservice_title_general_settings_2'
						),
						array(
							'name'    => __( 'Slug service', 'opal-service' ),
							'desc'    => __( 'You can change slug name of service link . (e.g: http://localhost/wordpress/<span style="color:red;" >service</span>/jane-done/)<br> the <span style="color:red;" >service</span> is slug name', 'opal-service' ),
							'id'      => 'slug_service',
							'type'    => 'text',
							'default' => 'services',
							
						),
						array(
							'name'    => __( 'Slug category service', 'opal-service' ),
							'desc'    => __( 'You can change slug name of category service link . (e.g: http://localhost/wordpress/<span style="color:red;" >category-service</span>/jane-done/)<br> the <span style="color:red;" >category-service</span> is slug name', 'opal-service' ),
							'id'      => 'slug_category_service',
							'type'    => 'text',
							'default' => 'category-service',
							
						),
					)
				)
			),// end general	
			/**
			 * Page View Settings
			 */
			'pageview'     => array(
				'id'         => 'options_page',
				'title' => __( 'Page View Settings', 'opal-service' ),
				'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key, ), ),
				'fields'     => apply_filters( 'opalservice_settings_pageview', array(
						array(
							'name' => __( 'Page Service Settings', 'opal-service' ),
							'desc' => '<hr>',
							'type' => 'title',
							'id'   => 'opalservice_title_pageview_settings_1'
						),

						array(
							'name'    => __( 'Service page view', 'opal-service' ),
							'desc'    => __( 'Choose the way to display your menu items within menu Page.', 'opal-service' ),
							'id'      => 'service_view',
							'type'    => 'select',
							'options' => array(
								'grid' => __( 'Grid', 'opal-service' ),
								'list'  => __( 'List', 'opal-service' )
							),
							'default' => 'gird',
						),
						array(
							'name'    => __( 'Column Service page', 'opal-service' ),
							'desc'    => __( 'Choose the way to display your menu items within menu page.', 'opal-service' ),
							'id'      => 'column_service',
							'type'    => 'text',
							'default' => '4',	
						),
						
						array(
							'type'      => 'select',
							'name'      => __( 'Image Size', 'opal-service' ),
							'id'        => 'service_image_size',
							'desc' 		=> __( 'Thumbnail (default 150px x 150px max)<br>Medium resolution (default 300px x 300px max)<br>Large resolution (default 640px x 640px max)<br>Full resolution (original size uploaded)<br>Other resolutions', 'opal-service' ),
							'options'     => array(
								'thumbnail'      	=> 'Thumbnail',
								'medium'          => 'Medium',
								'large'          	=> 'Large',
								'full'          	=> 'Full',
								'other'          	=> 'Other size',
							),
							'default'	=> 'thumbnail',			
						),

						array(
							'type'      => 'text',
							'name'      => esc_html__('Other Image Size', 'opal-service'),
							'id'        => 'service_other_size',
							'classes' 	=> 'service_other_size',
							'desc' 		=> __( 'the set Image size for all image service , example: 150x150. is width = 150px and height = 150px', 'opal-service' ),
							'default'	     => __( '150x150', 'opal-service' ),

						),
						array(
							'name'    => __( 'Show Thumnail', 'opal-service' ),
							'desc'    => __( 'Choose the way to display thumbnail on items page.', 'opal-service' ),
							'id'      => 'service_show_thumbnail',
							'type'    => 'radio_inline',
						   'options' => array(
						        0 => __( 'No', 'opal-service' ),
						        1   => __( 'Yes', 'opal-service' ),
						   ),
						   
						),
						array(
							'name'    => __( 'Show Category', 'opal-service' ),
							'desc'    => __( 'Choose the way to display category on items page.', 'opal-service' ),
							'id'      => 'service_show_category',
							'type'    => 'radio_inline',
						   'options' => array(
						        0 => __( 'No', 'opal-service' ),
						        1   => __( 'Yes', 'opal-service' ),
						   ),
						   
						),

						array(
							'name'    => __( 'Show Description', 'opal-service' ),
							'desc'    => __( 'Choose the way to display description on items page.', 'opal-service' ),
							'id'      => 'service_show_description',
							'type'    => 'radio_inline',
						   'options' => array(
						        0 => __( 'No', 'opal-service' ),
						        1   => __( 'Yes', 'opal-service' ),
						   ),
						   
						),

						array(
							'name'    => __( 'Show View Detail', 'opal-service' ),
							'desc'    => __( 'Choose the way to display View Detail button on items page.', 'opal-service' ),
							'id'      => 'service_show_readmore',
							'type'    => 'radio_inline',
						   'options' => array(
						        0 => __( 'No', 'opal-service' ),
						        1   => __( 'Yes', 'opal-service' ),
						   ),
						  
						),

						array(
							'name'    => __( 'Show Number', 'opal-service' ),
							'desc'    => __( 'Choose the way to display Number on items page.', 'opal-service' ),
							'id'      => 'service_show_number',
							'type'    => 'radio_inline',
						   'options' => array(
						        0 => __( 'No', 'opal-service' ),
						        1   => __( 'Yes', 'opal-service' ),
						   ),
						),

						array(
							'name'    => __( 'Description Max Chars', 'opal-service' ),
							'desc'    => __( 'the set number max character for description service on items page.', 'opal-service' ),
							'id'      => 'service_max_char',
							'type'    => 'text',
						   'default' => '10',
						),
					)
				)
			),// end Page View		
		);
		
		//Return all settings array if necessary
		if ( $active_tab === null || ! isset( $opalservice_settings[ $active_tab ] ) ) {
			return apply_filters( 'opalservice_registered_settings', $opalservice_settings );
		}

		// Add other tabs and settings fields as needed
		return apply_filters( 'opalservice_registered_settings', $opalservice_settings[ $active_tab ] );

	}

	/**
	 * Show Settings Notices
	 *
	 * @param $object_id
	 * @param $updated
	 * @param $cmb
	 */
	public function settings_notices( $object_id, $updated, $cmb ) {

		//Sanity check
		if ( $object_id !== $this->key ) {
			return;
		}

		if ( did_action( 'cmb2_save_options-page_fields' ) === 1 ) {
			settings_errors( 'opalservice-notices' );
		}

		add_settings_error( 'opalservice-notices', 'global-settings-updated', __( 'Settings updated.', 'opal-service' ), 'updated' );

	}


	/**
	 * Public getter method for retrieving protected/private variables
	 *
	 * @since  1.0
	 *
	 * @param  string $field Field to retrieve
	 *
	 * @return mixed          Field value or exception is thrown
	 */
	public function __get( $field ) {

		// Allowed fields to retrieve
		if ( in_array( $field, array( 'key', 'fields', 'opalservice_title', 'options_page' ), true ) ) {
			return $this->{$field};
		}
		if ( 'option_metabox' === $field ) {
			return $this->option_metabox();
		}

		throw new Exception( 'Invalid service: ' . $field );
	}


}

// Get it started
$Opalservice_Settings = new Opalservice_Plugin_Settings();

/**
 * Wrapper function around cmb2_get_option
 * @since  0.1.0
 *
 * @param  string $key Options array key
 *
 * @return mixed        Option value
 */
function opalservice_get_option( $key = '', $default = false ) {
	global $opalservice_options;
	$value = ! empty( $opalservice_options[ $key ] ) ? $opalservice_options[ $key ] : $default;
	$value = apply_filters( 'opalservice_get_option', $value, $key, $default );

	return apply_filters( 'opalservice_get_option_' . $key, $value, $key, $default );
}


/**
 * Update an option
 *
 * Updates an opalservice setting value in both the db and the global variable.
 * Warning: Passing in an empty, false or null string value will remove
 *          the key from the opalservice_options array.
 *
 * @since 1.0
 *
 * @param string          $key   The Key to update
 * @param string|bool|int $value The value to set the key to
 *
 * @return boolean True if updated, false if not.
 */
function opalservice_update_option( $key = '', $value = false ) {

	// If no key, exit
	if ( empty( $key ) ) {
		return false;
	}

	if ( empty( $value ) ) {
		$remove_option = opalservice_delete_option( $key );

		return $remove_option;
	}

	// First let's grab the current settings
	$options = get_option( 'opalservice_settings' );

	// Let's let devs alter that value coming in
	$value = apply_filters( 'opalservice_update_option', $value, $key );

	// Next let's try to update the value
	$options[ $key ] = $value;
	$did_update      = update_option( 'opalservice_settings', $options );

	// If it updated, let's update the global variable
	if ( $did_update ) {
		global $opalservice_options;
		$opalservice_options[ $key ] = $value;
	}

	return $did_update;
}

/**
 * Remove an option
 *
 * Removes an opalservice setting value in both the db and the global variable.
 *
 * @since 1.0
 *
 * @param string $key The Key to delete
 *
 * @return boolean True if updated, false if not.
 */
function opalservice_delete_option( $key = '' ) {

	// If no key, exit
	if ( empty( $key ) ) {
		return false;
	}

	// First let's grab the current settings
	$options = get_option( 'opalservice_settings' );

	// Next let's try to update the value
	if ( isset( $options[ $key ] ) ) {

		unset( $options[ $key ] );

	}

	$did_update = update_option( 'opalservice_settings', $options );

	// If it updated, let's update the global variable
	if ( $did_update ) {
		global $opalservice_options;
		$opalservice_options = $options;
	}

	return $did_update;
}


/**
 * Get Settings
 *
 * Retrieves all Opalservice plugin settings
 *
 * @since 1.0
 * @return array Opalservice settings
 */
function opalservice_get_settings() {

	$settings = get_option( 'opalservice_settings' );

	return (array) apply_filters( 'opalservice_get_settings', $settings );

}

/**
 * Gateways Callback
 *
 * Renders gateways fields.
 *
 * @since 1.0
 *
 * @global $opalservice_options Array of all the Opalservice Options
 * @return void
 */
function opalservice_enabled_gateways_callback( $field_object, $escaped_value, $object_id, $object_type, $field_type_object ) {

	$id                = $field_type_object->field->args['id'];
	$field_description = $field_type_object->field->args['desc'];
	$gateways          = opalservice_get_payment_gateways();

	echo '<ul class="cmb2-checkbox-list cmb2-list">';

	foreach ( $gateways as $key => $option ) :

		if ( is_array( $escaped_value ) && array_key_exists( $key, $escaped_value ) ) {
			$enabled = '1';
		} else {
			$enabled = null;
		}

		echo '<li><input name="' . $id . '[' . $key . ']" id="' . $id . '[' . $key . ']" type="checkbox" value="1" ' . checked( '1', $enabled, false ) . '/>&nbsp;';
		echo '<label for="' . $id . '[' . $key . ']">' . $option['admin_label'] . '</label></li>';

	endforeach;

	if ( $field_description ) {
		echo '<p class="cmb2-metabox-description">' . $field_description . '</p>';
	}

	echo '</ul>';


}

/**
 * Gateways Callback (drop down)
 *
 * Renders gateways select service
 *
 * @since 1.0
 *
 * @param $field_object , $escaped_value, $object_id, $object_type, $field_type_object Arguments passed by CMB2
 *
 * @return void
 */
function opalservice_default_gateway_callback( $field_object, $escaped_value, $object_id, $object_type, $field_type_object ) {

	$id                = $field_type_object->field->args['id'];
	$field_description = $field_type_object->field->args['desc'];
	$gateways          = opalservice_get_enabled_payment_gateways();

	echo '<select class="cmb2_select" name="' . $id . '" id="' . $id . '">';

	//Add a field to the Opalservice Form admin single post view of this field
	if ( $field_type_object->field->object_type === 'post' ) {
		echo '<option value="global">' . __( 'Global Default', 'opal-service' ) . '</option>';
	}

	foreach ( $gateways as $key => $option ) :

		$selected = isset( $escaped_value ) ? selected( $key, $escaped_value, false ) : '';


		echo '<option value="' . esc_attr( $key ) . '"' . $selected . '>' . esc_html( $option['admin_label'] ) . '</option>';

	endforeach;

	echo '</select>';

	echo '<p class="cmb2-metabox-description">' . $field_description . '</p>';

}

/**
 * Opalservice Title
 *
 * Renders custom section titles output; Really only an <hr> because CMB2's output is a bit funky
 *
 * @since 1.0
 *
 * @param       $field_object , $escaped_value, $object_id, $object_type, $field_type_object
 *
 * @return void
 */
function opalservice_title_callback( $field_object, $escaped_value, $object_id, $object_type, $field_type_object ) {

	$id                = $field_type_object->field->args['id'];
	$title             = $field_type_object->field->args['name'];
	$field_description = $field_type_object->field->args['desc'];

	echo '<hr>';

}

/**
 * Gets a number of posts and displays them as options
 *
 * @param  array $query_args Optional. Overrides defaults.
 * @param  bool  $force      Force the pages to be loaded even if not on settings
 *
 * @see: https://github.com/WebDevStudios/CMB2/wiki/Adding-your-own-field-types
 * @return array An array of options that matches the CMB2 options array
 */
function opalservice_cmb2_get_post_options( $query_args, $force = false ) {

	$post_options = array( '' => '' ); // Blank option

	if ( ( ! isset( $_GET['page'] ) || 'opalservice-settings' != $_GET['page'] ) && ! $force ) {
		return $post_options;
	}

	$args = wp_parse_args( $query_args, array(
		'post_type'   => 'page',
		'numberposts' => 10,
	) );

	$posts = get_posts( $args );

	if ( $posts ) {
		foreach ( $posts as $post ) {

			$post_options[ $post->ID ] = $post->post_title;

		}
	}

	return $post_options;
}


/**
 * Modify CMB2 Default Form Output
 *
 * @param string @args
 *
 * @since 1.0
 */

add_filter( 'cmb2_get_metabox_form_format', 'opalservice_modify_cmb2_form_output', 10, 3 );

function opalservice_modify_cmb2_form_output( $form_format, $object_id, $cmb ) {

	//only modify the opalservice settings form
	if ( 'opalservice_settings' == $object_id && 'options_page' == $cmb->cmb_id ) {

		return '<form class="cmb-form" method="post" id="%1$s" enctype="multipart/form-data" encoding="multipart/form-data"><input type="hidden" name="object_id" value="%2$s">%3$s<div class="opalservice-submit-wrap"><input type="submit" name="submit-cmb" value="' . __( 'Save Settings', 'opal-service' ) . '" class="button-primary"></div></form>';
	}

	return $form_format;

}


/**
 * Opalservice License Key Callback
 *
 * @description Registers the license field callback for EDD's Software Licensing
 * @since       1.0
 *
 * @param array $field_object , $escaped_value, $object_id, $object_type, $field_type_object Arguments passed by CMB2
 *
 * @return void
 */
if ( ! function_exists( 'opalservice_license_key_callback' ) ) {
	function opalservice_license_key_callback( $field_object, $escaped_value, $object_id, $object_type, $field_type_object ) {

		$id                = $field_type_object->field->args['id'];
		$field_description = $field_type_object->field->args['desc'];
		$license_status    = get_option( $field_type_object->field->args['options']['is_valid_license_option'] );
		$field_classes     = 'regular-text opalservice-license-field';
		$type              = empty( $escaped_value ) ? 'text' : 'password';

		if ( $license_status === 'valid' ) {
			$field_classes .= ' opalservice-license-active';
		}

		$html = $field_type_object->input( array(
			'class' => $field_classes,
			'type'  => $type
		) );

		//License is active so show deactivate button
		if ( $license_status === 'valid' ) {
			$html .= '<input type="submit" class="button-secondary opalservice-license-deactivate" name="' . $id . '_deactivate" value="' . __( 'Deactivate License', 'opal-service' ) . '"/>';
		} else {
			//This license is not valid so delete it
			opalservice_delete_option( $id );
		}

		$html .= '<label for="opalservice_settings[' . $id . ']"> ' . $field_description . '</label>';

		wp_nonce_field( $id . '-nonce', $id . '-nonce' );

		echo $html;
	}
}


/**
 * Display the API Keys
 *
 * @since       2.0
 * @return      void
 */
function opalservice_api_callback() {

	if ( ! current_user_can( 'manage_opalservice_settings' ) ) {
		return;
	}

	do_action( 'opalservice_tools_api_keys_before' );

	require_once OPALESTATE_PLUGIN_DIR . 'includes/admin/class-api-keys-table.php';

	$api_keys_table = new Opalservice_API_Keys_Table();
	$api_keys_table->prepare_items();
	$api_keys_table->display();
	?>
	<p>
		<?php printf(
			__( 'API keys allow users to use the <a href="%s">Opalservice REST API</a> to retrieve donation data in JSON or XML for external applications or devices, such as <a href="%s">Zapier</a>.', 'opal-service' ),
			'https://opalservicewp.com/documentation/opalservice-api-reference/',
			'https://opalservicewp.com/addons/zapier/'
		); ?>
	</p>

	<style>
		.opalservice_service_page_opalservice-settings .opalservice-submit-wrap {
			display: none; /* Hide Save settings button on System Info Tab (not needed) */
		}
	</style>
	<?php

	do_action( 'opalservice_tools_api_keys_after' );
}

add_action( 'opalservice_settings_tab_api_keys', 'opalservice_api_callback' );

/**
 * Hook Callback
 *
 * Adds a do_action() hook in place of the field
 *
 * @since 1.0
 *
 * @param array $args Arguments passed by the setting
 *
 * @return void
 */
function opalservice_hook_callback( $args ) {
	do_action( 'opalservice_' . $args['id'] );
}