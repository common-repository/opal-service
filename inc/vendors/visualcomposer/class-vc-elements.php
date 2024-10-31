<?php

class OpalService_VisualComposer {

    public function __construct() {
        add_action('vc_after_mapping', array($this, 'init_vc_lean_map'));
        $shortcodes_menu = array('opalservice_vc_list_service', 'opalservice_vc_carousel_service', 'opalservice_vc_tabs_service');
        foreach ($shortcodes_menu as $shortcode) {
            add_filter('vc_autocomplete_' . $shortcode . '_category_callback', array($this, 'opalservice_category_field_search'), 10, 1);
            add_filter('vc_autocomplete_' . $shortcode . '_category_render', array($this, 'opalservice_category_render'), 10, 1);
        }
    }

    public function opalservice_vc_get_term_object($term) {
        $vc_taxonomies_types = vc_taxonomies_types();

        return array(
            'label'    => $term->name,
            'value'    => $term->slug,
            'group_id' => $term->taxonomy,
            'group'    => isset($vc_taxonomies_types[$term->taxonomy], $vc_taxonomies_types[$term->taxonomy]->labels, $vc_taxonomies_types[$term->taxonomy]->labels->name) ? $vc_taxonomies_types[$term->taxonomy]->labels->name : esc_html__('Taxonomies', 'opal-service'),
        );
    }


    public function opalservice_category_field_search($search_string) {
        $data = array();
        $vc_taxonomies_types = array('opalservice_category_service');
        $vc_taxonomies = get_terms($vc_taxonomies_types, array(
            'hide_empty' => false,
            'search'     => $search_string
        ));
        if (is_array($vc_taxonomies) && !empty($vc_taxonomies)) {
            foreach ($vc_taxonomies as $t) {
                if (is_object($t)) {
                    $data[] = $this->opalservice_vc_get_term_object($t);
                }
            }
        }
        return $data;
    }


    public function opalservice_category_render($query) {
        $category = get_term_by('slug', $query['value'], 'opalservice_category_service');
        if (!empty($query) && !empty($category)) {
            $data = array();
            $data['value'] = $category->slug;
            $data['label'] = $category->name;
            return !empty($data) ? $data : false;
        }
        return false;
    }

    public function init_vc_lean_map() {
        vc_lean_map('opalservice_vc_list_service', array($this, 'opalservice_vc_list_service'));
        vc_lean_map('opalservice_vc_carousel_service', array($this, 'opalservice_vc_carousel_service'));
        vc_lean_map('opalservice_vc_category_service', array($this, 'opalservice_vc_category_service'));
        vc_lean_map('opalservice_vc_tabs_service', array($this, 'opalservice_vc_tabs_service'));
    }

    public function opalservice_vc_list_service() {
        return array(
            "name"        => esc_html__('List Services', 'opal-service'),
            "base"        => "opalservice_vc_list_service",
            'icon'        => OPALSERVICE_PLUGIN_URL . "assets/img/logo_opal.png",
            'description' => 'Show Listing Service Info',
            'category'    => esc_html__('Opal Service', 'opal-service'),
            'params'      => array(
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__('Title', 'opal-service'),
                    'param_name'  => 'title',
                    'description' => __('The title of the Service List.', 'opal-service'),
                    'value'       => __('List Service', 'opal-service'),
                ),

                array(
                    'type'        => 'textarea',
                    'heading'     => __('Description', 'opal-service'),
                    'param_name'  => 'description',
                    'description' => __('The text description for your page.', 'opal-service'),
                    'value'       => __('The Description', 'opal-service'),
                ),

                array(
                    'type'       => 'autocomplete',
                    'heading'    => __('By Categories', 'opal-service'),
                    'param_name' => 'category',
                    'settings'   => array(
                        'multiple' => true,
                    )
                ),

                array(
                    'type'        => 'dropdown',
                    'heading'     => __('Column', 'opal-service'),
                    'param_name'  => 'column',
                    'description' => __('Number column of the page', 'opal-service'),
                    'value'       => array(1, 2, 3, 4, 6)
                ),

                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__('Limit', 'opal-service'),
                    'param_name'  => 'limit',
                    'description' => __('Number Limit of the page.', 'opal-service'),
                    'value'       => __('4', 'opal-service')
                ),

                array(
                    'type'        => 'dropdown',
                    'heading'     => __('Layouts', 'opal-service'),
                    'param_name'  => 'layout',
                    'description' => __('Layout of the page', 'opal-service'),
                    'value'       => array(
                        'Grid v1 (Default)'           => 'grid_v1',
                        'Grid V2 (Absolute Elements)' => 'grid_v2',
                        'Grid V3 (Show Icon)'         => 'grid_v3',
                    )
                ),
                
                array(
                    'type'        => 'checkbox',
                    'heading'     => __('Show Thumbnail', 'opal-service'),
                    'param_name'  => 'show_thumbnail',
                    'description' => __('Show the Thumbnail of the page.', 'opal-service'),
                    'value'       => array(__('Yes', 'opal-service') => '1'),

                ),

                array(
                    'type'        => 'dropdown',
                    'heading'     => __('Image Size', 'opal-service'),
                    'param_name'  => 'image_size',
                    'description' => __('Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'opal-service'),
                    'value'       => array(
                        'Thumbnail' => 'thumbnail',
                        'Medium'    => 'medium',
                        'Large'     => 'large',
                        'full'      => 'full',
                        'Other'     => 'other',
                    ),
                    'dependency'  => array(
                        'element' => 'show_thumbnail',
                        'value'   => '1'
                    ),
                ),

                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__('Other Image Size', 'opal-service'),
                    'param_name'  => 'other_size',
                    'description' => __('the set Image size for all image service , example: 150x150. is width = 150px and height = 150px', 'opal-service'),
                    'value'       => __('150x150', 'opal-service'),
                    'dependency'  => array(
                        'element' => 'image_size',
                        'value'   => 'other'
                    ),
                ),

                array(
                    'type'        => 'checkbox',
                    'heading'     => __('Show Category', 'opal-service'),
                    'param_name'  => 'show_category',
                    'description' => __('Show the Category of the page.', 'opal-service'),
                    'value'       => array(__('Yes', 'opal-service') => '1'),
                ),

                array(
                    'type'        => 'checkbox',
                    'heading'     => __('Show Description', 'opal-service'),
                    'param_name'  => 'show_description',
                    'description' => __('Show the Description of the page.', 'opal-service'),
                    'value'       => array(__('Yes', 'opal-service') => '1'),
                ),

                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__('Description Max Chars', 'opal-service'),
                    'param_name'  => 'max_char',
                    'description' => __('the set number max character for description service', 'opal-service'),
                    'value'       => __('10', 'opal-service'),
                    'dependency'  => array(
                        'element' => 'show_description',
                        'value'   => '1'
                    ),
                ),

                array(
                    'type'        => 'checkbox',
                    'heading'     => __('Show Readmore', 'opal-service'),
                    'param_name'  => 'show_readmore',
                    'description' => __('Show the Readmore of the page.', 'opal-service'),
                    'value'       => array(__('Yes', 'opal-service') => '1'),
                ),
            )
        );
    }

    public function opalservice_vc_tabs_service() {
        return array(
            'name'        => esc_html__('Service Tabs', 'opal-service'),
            "base"        => "opalservice_vc_tabs_service",
            'icon'        => OPALSERVICE_PLUGIN_URL . "assets/img/logo_opal.png",
            'description' => 'Show Service by Tabs Info',
            'category'    => esc_html__('Opal Service', 'opal-service'),
            'params'      => array(
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__('Title', 'opal-service'),
                    'param_name'  => 'title',
                    'description' => esc_html__('The title of the Service List.', 'opal-service'),
                    'value'       => esc_html__('Our Services', 'opal-service'),
                    'admin_label' => true
                ),

                array(
                    'type'       => 'autocomplete',
                    'heading'    => __('By Categories', 'opal-service'),
                    'param_name' => 'category',
                    'settings'   => array(
                        'multiple' => true,
                    )
                ),

                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__('Layouts', 'opal-service'),
                    'param_name'  => 'layout',
                    'description' => esc_html__('Layout of the page', 'opal-service'),
                    'admin_label' => true,
                    'value'       => array(
                        'Tabs_v1 (Vertical)' => 'tabs_v1',
                    )
                ),

                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__('Style', 'opal-service'),
                    'param_name'  => 'style',
                    'description' => esc_html__('Style of the page', 'opal-service'),
                    'admin_label' => true,
                    'value'       => array(
                        'Style default'      => 'style_v1',
                        'Style light Tab V2' => 'style_v2',
                    )
                ),

                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__('Limit', 'opal-service'),
                    'param_name'  => 'limit',
                    'description' => esc_html__('Number Limit of the page.', 'opal-service'),
                    'value'       => '4',
                    'admin_label' => true
                ),
                array(
                    'type'        => 'dropdown',
                    'heading'     => __('Image Size', 'opal-service'),
                    'param_name'  => 'image_size',
                    'description' => __('Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'opal-service'),
                    'value'       => array(
                        'Thumbnail' => 'thumbnail',
                        'Medium'    => 'medium',
                        'Large'     => 'large',
                        'full'      => 'full',
                        'Other'     => 'other',
                    )
                ),

                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__('Other Image Size', 'opal-service'),
                    'param_name'  => 'other_size',
                    'description' => __('the set Image size for all image service , example: 150x150. is width = 150px and height = 150px', 'opal-service'),
                    'value'       => __('150x150', 'opal-service'),
                    'dependency'  => array(
                        'element' => 'image_size',
                        'value'   => 'other'
                    ),
                ),

                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__('Description Max Chars', 'opal-service'),
                    'param_name'  => 'max_char',
                    'description' => __('the set number max character for description service', 'opal-service'),
                    'value'       => __('10', 'opal-service'),
                ),

                array(
                    'type'        => 'checkbox',
                    'heading'     => __('Show Readmore', 'opal-service'),
                    'param_name'  => 'show_readmore',
                    'description' => __('Show the Readmore of the page.', 'opal-service'),
                    'value'       => array(__('Yes', 'opal-service') => '1'),
                ),

            )
        );
    }

    public function opalservice_vc_carousel_service() {
        return array(
            'name'        => esc_html__('Service Carousel Service', 'opal-service'),
            "base"        => "opalservice_vc_list_service",
            'icon'        => OPALSERVICE_PLUGIN_URL . "assets/img/logo_opal.png",
            'description' => 'Show list carousel service Info',
            'category'    => esc_html__('Opal Service', 'opal-service'),
            'params'      => array(
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__('Title', 'opal-service'),
                    'param_name'  => 'title',
                    'description' => __('The title of the Service List.', 'opal-service'),
                    'value'       => __('List Service', 'opal-service'),
                ),

                array(
                    'type'        => 'textarea',
                    'heading'     => __('Description', 'opal-service'),
                    'param_name'  => 'description',
                    'description' => __('The text description for your page.', 'opal-service'),
                    'value'       => ('The Description'),
                ),

                array(
                    'type'       => 'autocomplete',
                    'heading'    => __('By Categories', 'opal-service'),
                    'param_name' => 'category',
                ),

                array(
                    'type'        => 'dropdown',
                    'heading'     => __('Column', 'opal-service'),
                    'param_name'  => 'column',
                    'description' => __('Number column of the page', 'opal-service'),
                    'value'       => array(1, 2, 3, 4, 6)
                ),

                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__('Limit', 'opal-service'),
                    'param_name'  => 'limit',
                    'description' => __('Number Limit of the page.', 'opal-service'),
                    'value'       => __('4', 'opal-service')
                ),

                array(
                    'type'        => 'checkbox',
                    'heading'     => __('Show Thumbnail', 'opal-service'),
                    'param_name'  => 'show_thumbnail',
                    'description' => __('Show the Thumbnail of the page.', 'opal-service'),
                    'value'       => array(__('Yes', 'opal-service') => '1'),
                ),

                array(
                    'type'        => 'dropdown',
                    'heading'     => __('Image Size', 'opal-service'),
                    'param_name'  => 'image_size',
                    'description' => __('Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'opal-service'),
                    'value'       => array(
                        'Thumbnail' => 'thumbnail',
                        'Medium'    => 'medium',
                        'Large'     => 'large',
                        'full'      => 'full',
                        'Other'     => 'other',
                    ),
                    'dependency'  => array(
                        'element' => 'show_thumbnail',
                        'value'   => '1'
                    ),
                ),

                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__('Other Image Size', 'opal-service'),
                    'param_name'  => 'other_size',
                    'description' => __('the set Image size for all image service , example: 150x150. is width = 150px and height = 150px', 'opal-service'),
                    'value'       => __('150x150', 'opal-service'),
                    'dependency'  => array(
                        'element' => 'image_size',
                        'value'   => 'other'
                    ),
                ),

                array(
                    'type'        => 'checkbox',
                    'heading'     => __('Show Description', 'opal-service'),
                    'param_name'  => 'show_description',
                    'description' => __('Show the Description of the page.', 'opal-service'),
                    'value'       => array(__('Yes', 'opal-service') => '1'),
                ),


                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__('Description Max Chars', 'opal-service'),
                    'param_name'  => 'max_char',
                    'description' => __('the set number max character for description service', 'opal-service'),
                    'value'       => __('10', 'opal-service'),
                    'dependency'  => array(
                        'element' => 'show_description',
                        'value'   => '1'
                    ),
                ),

                array(
                    'type'        => 'checkbox',
                    'heading'     => __('Show Category', 'opal-service'),
                    'param_name'  => 'show_category',
                    'description' => __('Show the Category of the page.', 'opal-service'),
                    'value'       => array(__('Yes', 'opal-service') => '1'),
                ),

                array(
                    'type'        => 'checkbox',
                    'heading'     => __('Show Readmore', 'opal-service'),
                    'param_name'  => 'show_readmore',
                    'description' => __('Show the Readmore of the page.', 'opal-service'),
                    'value'       => array(__('Yes', 'opal-service') => '1'),
                ),
                
                // Owl Carousel Setting

                array(
                    'type'       => 'checkbox',
                    'heading'    => __('Enable Button Navigation', 'opal-service'),
                    'param_name' => 'enable_navigation',
                    'value'      => array(__('Yes', 'opal-service') => '1'),
                ),

                array(
                    'type'       => 'checkbox',
                    'heading'    => __('Enable Button Pagination', 'opal-service'),
                    'param_name' => 'enable_pagination',
                    'value'      => array(__('Yes', 'opal-service') => '1'),
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__('Speed', 'opal-service'),
                    'param_name'  => 'speed',
                    'description' => __('Determines the duration of the transition in milliseconds.If less than 10, the number is interpreted as a speed (pixels/millisecond).This is probably desirable when scrolling items with variable sizes', 'opal-service'),
                    'value'       => __('3000', 'opal-service'),
                ),
            )
        );

    }

    public function opalservice_vc_category_service() {
        return array(
            'name'        => esc_html__('Category Service', 'opal-service'),
            "base"        => "opalservice_vc_list_service",
            'icon'        => OPALSERVICE_PLUGIN_URL . "assets/img/logo_opal.png",
            'description' => 'Show list category service',
            'category'    => esc_html__('Opal Service', 'opal-service'),
            'params'      => array(
                array(
                    'type'        => 'dropdown',
                    'heading'     => __('Column', 'opal-service'),
                    'param_name'  => 'column',
                    'description' => __('Number column of the page', 'opal-service'),
                    'value'       => array(1, 2, 3, 4, 6)
                ),

                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__('Limit', 'opal-service'),
                    'param_name'  => 'limit',
                    'description' => __('Number Limit of the page.', 'opal-service'),
                    'value'       => __('4', 'opal-service')
                ),
                array(
                    'type'        => 'dropdown',
                    'heading'     => __('Style', 'opal-service'),
                    'param_name'  => 'style',
                    'description' => __('Select style', 'opal-service'),
                    'value'       => array(
                        'Grid'     => 'grid',
                        'Carousel' => 'carousel',
                    )
                ),
            )
        );
    }
}

new OpalService_VisualComposer();