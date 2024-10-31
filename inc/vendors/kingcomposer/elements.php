<?php 

	add_action('init', 'opalservice_element_kingcomposer_map', 99 );
 
	function opalservice_element_kingcomposer_map(){
		global $kc;

		$maps = array();

		 

		//=======================================================================
		$maps['element_service_list_service'] =  array(
		    'name' => esc_html__('List Services', 'opal-service'),
		    'icon' => 'kc-icon-post',
		    'description' => 'Show Listing Service Info',
		    'category' => esc_html__('Elements', 'opal-service'),
		    'params' => array(
		    	array(
					'type'        => 'text',
					'label'       => esc_html__('Title', 'opal-service'),
					'name'        => 'title',
					'description' => __( 'The title of the Service List.', 'opal-service' ),
					'value'	     => __( 'List Service', 'opal-service' ),
					'admin_label' => true
				),

				array(
					'type'			=> 'textarea',
					'label'			=> __( 'Description', 'opal-service' ),
					'name'			=> 'description',
					'description'	=> __( 'The text description for your page.', 'opal-service' ),
					'value'		   => base64_encode('The Description'),
				),

				array(
					'type'        => 'multiple',
					'label'       => __( 'By Categories', 'opal-service' ),
					'name'        => 'category',
					'description' => __( 'Layout of the page', 'opal-service' ),
					'admin_label' => true,
					'options'     => CategoryService_OptionArray(),
				),

				array(
					'type'        => 'dropdown',
					'label'       => __( 'Column', 'opal-service' ),
					'name'        => 'column',
					'description' => __( 'Number column of the page', 'opal-service' ),
					'admin_label' => true,
					'options'     => array(1=>1,2=>2,3=>3,4=>4,5=>5,6=>6)
				),

				array(
					'type'        => 'dropdown',
					'label'       => __( 'Layouts', 'opal-service' ),
					'name'        => 'layout',
					'description' => __( 'Layout of the page', 'opal-service' ),
					'admin_label' => true,
					'options'     => array(
						'grid_v1'       => 'Grid_V1 (Default)',
						'grid_v2'       => 'Grid_v2 (Absolute Elements)',
						'grid_v3'       => 'Grid_v3 (Show Icon)',
					)
				),

                array(
                    'type'        => 'dropdown',
                    'label'       => __( 'Image Size', 'opal-service' ),
                    'name'        => 'image_size',
                    'description' => __( 'Thumbnail (default 150px x 150px max)<br>Medium resolution (default 300px x 300px max)<br>Large resolution (default 640px x 640px max)<br>Full resolution (original size uploaded)<br>Other resolutions', 'opal-service' ),
                    'admin_label' => true,
                    'options'     => array(
                        'thumbnail'      	=> 'Thumbnail',
                        'medium'          	=> 'Medium',
                        'large'          	=> 'Large',
                        'full'          	=> 'Full',
                        'other'          	=> 'Other size',
                    )
                ),

                array(
                    'type'        => 'text',
                    'label'       => esc_html__('Other Image Size', 'opal-service'),
                    'name'        => 'other_size',
                    'description' => __( 'the set Image size for all image service , example: 150x150. is width = 150px and height = 150px', 'opal-service' ),
                    'value'	     => __( '150x150', 'opal-service' ),
                    'admin_label' => true,
                    'relation'	=> array(
                        'parent'	=> 'image_size',
                        'show_when'	=> 'other'
                    ),
                ),

				array(
					'type'        => 'text',
					'label'       => esc_html__('Limit', 'opal-service'),
					'name'        => 'limit',
					'description' => __( 'Number Limit of the page.', 'opal-service' ),
					'value'	     => __( '4', 'opal-service' ),
					'admin_label' => true
				),
				
				array(
					'type'        => 'text',
					'label'       => esc_html__('Description Max Chars', 'opal-service'),
					'name'        => 'max_char',
					'description' => __( 'the set number max character for description service', 'opal-service' ),
					'value'	     => __( '10', 'opal-service' ),
					'admin_label' => true
				),

				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show Category', 'opal-service' ),
					'name'        => 'show_category',
					'description' => __( 'Show the Category of the page.', 'opal-service' ),
					'options'     => array(
						'yes' => __('Yes, Please!', 'opal-service'),
					)
				),

				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show Description', 'opal-service' ),
					'name'        => 'show_description',
					'description' => __( 'Show the Description of the page.', 'opal-service' ),
					'options'     => array(
						'yes' => __('Yes, Please!', 'opal-service'),
					)
				),

				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show Thumbnail', 'opal-service' ),
					'name'        => 'show_thumbnail',
					'description' => __( 'Show the Thumbnail of the page.', 'opal-service' ),
					'options'     => array(
						'yes' => __('Yes, Please!', 'opal-service'),
					),
				),
				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show Readmore', 'opal-service' ),
					'name'        => 'show_readmore',
					'description' => __( 'Show the Readmore of the page.', 'opal-service' ),
					'options'     => array(
						'yes' => __('Yes, Please!', 'opal-service'),
					),
				),
				

		   )
		);
		
		//=======================================================================

		$maps['element_service_carousel_service'] =  array(
		    'name' => esc_html__('Service Carousel Service', 'opal-service'),
		    'icon' => 'kc-icon-pcarousel',
		    'description' => 'Show list carousel service Info',
		    'category' => esc_html__('Elements', 'opal-service'),
		    'params' => array(
		    	array(
					'type'        => 'text',
					'label'       => esc_html__('Title', 'opal-service'),
					'name'        => 'title',
					'description' => __( 'The title of the Service List.', 'opal-service' ),
					'value'	     => __( 'List Service', 'opal-service' ),
					'admin_label' => true
				),

				array(
					'type'			=> 'textarea',
					'label'			=> __( 'Description', 'opal-service' ),
					'name'			=> 'description',
					'description'	=> __( 'The text description for your page.', 'opal-service' ),
					'value'		   => base64_encode('The Description'),
				),

				array(
					'type'        => 'multiple',
					'label'       => __( 'By Categories', 'opal-service' ),
					'name'        => 'category',
					'description' => __( 'Layout of the page', 'opal-service' ),
					'admin_label' => true,
					'options'     => CategoryService_OptionArray(),
				),

				array(
					'type' 		  => 'number_slider',  // USAGE RADIO TYPE
					'label'       => __( 'Column', 'opal-service' ),
					'name'        => 'column',
					'description' => __( 'Number column of the page', 'opal-service' ),
					'admin_label' => true,
				   'options' => array(    // REQUIRED
				        'min' => 1,
				        'max' => 6,
				        'unit' => '',
				        'show_input' => false
				    ),
				),

				array(
					'type'        => 'number_slider',
					'label'       => esc_html__('Limit', 'opal-service'),
					'name'        => 'limit',
					'description' => __( 'Number Limit of the page.', 'opal-service' ),
					'value'	     => __( '4', 'opal-service' ),
					'admin_label' => true,
					'options' => array(    // REQUIRED
				        'min' => 1,
				        'max' => 20,
				        'unit' => '',
				        'show_input' => false
				    ),
				),

                array(
                    'type'        => 'dropdown',
                    'label'       => __( 'Image Size', 'opal-service' ),
                    'name'        => 'image_size',
                    'description' => __( 'Thumbnail (default 150px x 150px max)<br>Medium resolution (default 300px x 300px max)<br>Large resolution (default 640px x 640px max)<br>Full resolution (original size uploaded)<br>Other resolutions', 'opal-service' ),
                    'admin_label' => true,
                    'options'     => array(
                        'thumbnail'      	=> 'Thumbnail',
                        'medium'          => 'Medium',
                        'large'          	=> 'Large',
                        'full'          	=> 'Full',
                        'other'          	=> 'Other size',
                    )
                ),

                array(
                    'type'        => 'text',
                    'label'       => esc_html__('Other Image Size', 'opal-service'),
                    'name'        => 'other_size',
                    'description' => __( 'the set Image size for all image service , example: 150x150. is width = 150px and height = 150px', 'opal-service' ),
                    'value'	     => __( '150x150', 'opal-service' ),
                    'admin_label' => true,
                    'relation'	=> array(
                        'parent'	=> 'image_size',
                        'show_when'	=> 'other'
                    ),
                ),

				array(
					'type'        => 'text',
					'label'       => esc_html__('Description Max Chars', 'opal-service'),
					'name'        => 'max_char',
					'description' => __( 'the set number max character for description service', 'opal-service' ),
					'value'	     => __( '10', 'opal-service' ),
					'admin_label' => true
				),

				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show Category', 'opal-service' ),
					'name'        => 'show_category',
					'description' => __( 'Show the Category of the page.', 'opal-service' ),
					'options'     => array(
						'yes' => __('Yes, Please!', 'opal-service'),
					)
				),
					
				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show Description', 'opal-service' ),
					'name'        => 'show_description',
					'description' => __( 'Show the Description of the page.', 'opal-service' ),
					'options'     => array(
						'yes' => __('Yes, Please!', 'opal-service'),
					)
				),

				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show Readmore', 'opal-service' ),
					'name'        => 'show_readmore',
					'description' => __( 'Show the Readmore of the page.', 'opal-service' ),
					'options'     => array(
						'yes' => __('Yes, Please!', 'opal-service'),
					),
				),

				array(
					'type'        => 'checkbox',
					'label'       => __( 'Show Thumbnail', 'opal-service' ),
					'name'        => 'show_thumbnail',
					'description' => __( 'Show the Thumbnail of the page.', 'opal-service' ),
					'options'     => array(
						'yes' => __('Yes, Please!', 'opal-service'),
					)
				),
				// Owl Carousel Setting

				array(
					'type'        => 'checkbox',
					'label'       => __( 'Enable Button Navigation', 'opal-service' ),
					'name'        => 'enable_navigation',
					'options'     => array(
						'1' => __('Yes, Please!', 'opal-service'),
					)
				),

				array(
					'type'        => 'checkbox',
					'label'       => __( 'Enable Button Pagination', 'opal-service' ),
					'name'        => 'enable_pagination',
					'options'     => array(
						'1' => __('Yes, Please!', 'opal-service'),
					)
				),
				array(
					'type'        => 'text',
					'label'       => esc_html__('Speed', 'opal-service'),
					'name'        => 'speed',
					'description' => __( 'Determines the duration of the transition in milliseconds.If less than 10, the number is interpreted as a speed (pixels/millisecond).This is probably desirable when scrolling items with variable sizes', 'opal-service' ),
					'admin_label' => true,
					'value'	     => __( '3000', 'opal-service' ),
				),
		   )
		);

		$maps['element_service_tabs_service'] =  array(
			    'name' => esc_html__('Service Tabs', 'opal-service'),
			    'icon' => 'kc-icon-post',
			    'description' => 'Show Service by Tabs Info',
			    'category' => esc_html__('Elements', 'opal-service'),
			    'params' => array(
			    	array(
						'type'        => 'text',
						'label'       => esc_html__('Title', 'opal-service'),
						'name'        => 'title',
						'description' => esc_html__('The title of the Service List.', 'opal-service' ),
						'value'	     => esc_html__('Our Services', 'opal-service' ),
						'admin_label' => true
					),

					array(
						'type'        => 'multiple',
						'label'       => esc_html__('By Categories', 'opal-service' ),
						'name'        => 'category',
						'description' => esc_html__('Layout of the page', 'opal-service' ),
						'admin_label' => true,
						'options'     => CategoryService_OptionArray(),
					),

					array(
						'type'        => 'dropdown',
						'label'       => esc_html__('Layouts', 'opal-service' ),
						'name'        => 'layout',
						'description' => esc_html__('Layout of the page', 'opal-service' ),
						'admin_label' => true,
						'options'     => array(
							'tabs_v1'       => 'Tabs_v1 (Vertical)',
							
						)
					),

					array(
						'type'        => 'dropdown',
						'label'       => esc_html__('Style', 'opal-service' ),
						'name'        => 'style',
						'description' => esc_html__('Style of the page', 'opal-service' ),
						'admin_label' => true,
						'options'     => array(
							'style_v1'       => 'Style default',
							'style_v2'       => 'Style light Tab V2',
						)
					), 

					array(
						'type'        => 'text',
						'label'       => esc_html__('Limit', 'opal-service'),
						'name'        => 'limit',
						'description' => esc_html__('Number Limit of the page.', 'opal-service' ),
						'value'	     => '4',
						'admin_label' => true
					),

					

					array(
						'type'        => 'dropdown',
						'label'       => esc_html__('Image Size', 'opal-service' ),
						'name'        => 'image_size',
						'description' => esc_html__('Thumbnail (default 150px x 150px max)<br>Medium resolution (default 300px x 300px max)<br>Large resolution (default 640px x 640px max)<br>Full resolution (original size uploaded)<br>Other resolutions', 'opal-service' ),
						'admin_label' => true,
						'options'     => array(
							'thumbnail'      	=> 'Thumbnail',
							'medium'          	=> 'Medium',
							'large'          	=> 'Large',
							'full'          	=> 'Full',
							'other'          	=> 'Other size',
						),
						'relation'	=> array(
							'parent'	=> 'layout',
							'show_when'	=> 'tabs_v2'
						),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__('Other Image Size', 'opal-service'),
						'name'        => 'other_size',
						'description' => esc_html__('the set Image size for all image service , example: 150x150. is width = 150px and height = 150px', 'opal-service' ),
						'value'	     => esc_html__('150x150', 'opal-service' ),
						'admin_label' => true,
						'relation'	=> array(
							'parent'	=> 'image_size',
							'show_when'	=> 'other'
						),
					),
					
					array(
						'type'        => 'text',
						'label'       => esc_html__('Description Max Chars', 'opal-service'),
						'name'        => 'max_char',
						'description' => esc_html__('the set number max character for description service', 'opal-service' ),
						'value'	     => esc_html__('100', 'opal-service' ),
						'admin_label' => true
					),

					array(
						'type'        => 'checkbox',
						'label'       => esc_html__('Show Button Read More', 'opal-service' ),
						'name'        => 'show_readmore',
						'description' => esc_html__('Show button Read More of the page.', 'opal-service' ),
						'options'     => array(
							'yes' => esc_html__('Yes, Please!', 'opal-service'),
						),
					), 
			   )
			);

		//=======================================================================

		$maps['element_category_service'] =  array(
		    'name' => esc_html__('Category Service', 'opal-service'),
		    'icon' => 'kc-icon-pcarousel',
		    'description' => 'Show list category service',
		    'category' => esc_html__('Elements', 'opal-service'),
		    'params' => array(

				array(
					'type' 		  => 'number_slider',  // USAGE RADIO TYPE
					'label'       => __( 'Column', 'opal-service' ),
					'name'        => 'column',
					'description' => __( 'Number column of the page', 'opal-service' ),
					'admin_label' => true,
				   'options' => array(    // REQUIRED
				        'min' => 1,
				        'max' => 6,
				        'unit' => '',
				        'show_input' => false
				    ),
				),

				array(
					'type'        => 'number_slider',
					'label'       => esc_html__('Limit', 'opal-service'),
					'name'        => 'limit',
					'description' => __( 'Number Limit of the page.', 'opal-service' ),
					'value'	     => __( '4', 'opal-service' ),
					'admin_label' => true,
					'options' => array(    // REQUIRED
				        'min' => 1,
				        'max' => 20,
				        'unit' => '',
				        'show_input' => false
				    ),
				),
				array(
					'type'        => 'dropdown',
					'label'       => __( 'Style', 'opal-service' ),
					'name'        => 'style',
					'description' => __( 'Select style', 'opal-service' ),
					'admin_label' => true,
					'options'     => array(
						'grid'       => 'Grid',
						'carousel'   => 'Carousel',
					)
				),
		   )
		);


		$maps = apply_filters( 'opalservice_element_kingcomposer_map', $maps ); 
	    $kc->add_map( $maps );
	}
 

	/**
	* Get Array taxonomy category service
	*/
	function CategoryService_OptionArray()
	{
		$optionArray = array();
		$services = Opalservice_Query::getCategoryServices();
		foreach ($services as $service) {
			$optionArray[$service->slug] = $service->name;
		}
		return $optionArray;
	}



?>
