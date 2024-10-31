<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
/**
 * Class OSF_Elementor_Blog
 */
class OSV_Elementor_Widget_Servicecarousel extends Elementor\Widget_Base {

    public function get_name() {
        return 'opal-servicecarousel';
    }

    public function get_title() {
        return __('Opal Service Carousel', 'opal-service');
    }

    /**
     * Get widget icon.
     *
     * Retrieve testimonial widget icon.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-slider-push';
    }
    
    /**
     * Retrieve the list of scripts the image carousel widget depended on.
     *
     * Used to set scripts dependencies required to run the widget.
     *
     * @since 1.3.0
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_script_depends() {
        return [ 'jquery-wpopal-slick' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_query',
            [
                'label' => __('Query', 'opal-service'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'style',
            [
                'label'     => __('Style Item Layout', 'opal-service'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default' => 'grid_v1',
                'options'   => service_loop_layouts(),
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label'   => __('Posts Per Page', 'opal-service'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 6,
            ]
        );

        $this->add_responsive_control(
            'column',
            [
                'label'     => __('Columns', 'opal-service'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 3,
                'options' => [
                    '0' => 'Auto',
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ],
            ]
        );

        $this->add_control(
            'categories',
            [
                'label'    => __('Categories', 'opal-service'),
                'type'     => Controls_Manager::SELECT2,
                'options'  => $this->get_post_categories(),
                'multiple' => true,
            ]
        );

        $this->add_control(
            'display_autoplay',
            [
                'label'       => __('Autoplay', 'opal-service'),
                'type'        => Controls_Manager::SWITCHER,
                'default'     => 'no',
            ]
        );
        $this->add_control(
            'speed',
            [
                'label'   => __('Speed', 'opal-service'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 3000,
                'condition' => [
                    'display_autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'other_size',
            [
                'label'     => __('Other Image Size', 'opal-service'),
                'type'      => \Elementor\Controls_Manager::TEXT,
                'default'   => '350x350',
                'condition' => [
                    'image_size' => 'other'
                ],
            ]
        );

        $this->add_control(
            'display_heading',
            [
                'label' => __('Display', 'opal-service'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'display_thumbnail',
            [
                'label'       => __('Show Thumbnail', 'opal-service'),
                'type'        => Controls_Manager::SWITCHER,
                'default'     => 'yes',
                'condition' => [
                    'style!' => 'list_v2'
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'default' => 'large',
                'separator' => 'none',
                'condition' => [
                    'display_thumbnail' => 'yes',
                    'style!' => 'list_v2'
                ]
            ]
            
        );

        $this->add_control(
            'display_category',
            [
                'label'       => __('Show Category', 'opal-service'),
                'type'        => Controls_Manager::SWITCHER,
                'default'     => 'yes',
            ]
        );


        $this->add_control(
            'display_description',
            [
                'label'       => __('Show Description', 'opal-service'),
                'type'        => Controls_Manager::SWITCHER,
                'default'     => 'yes',
            ]
        );
        $this->add_control(
            'max_char',
            [
                'label'       => __('Description Max Chars', 'opal-service'),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 10,
                'condition' => [
                    'display_description' => 'yes'
                ],
            ]
        );
        $this->add_control(
            'display_readmore',
            [
                'label'       => __('Show Readmore', 'opal-service'),
                'type'        => Controls_Manager::SWITCHER,
                'default'     => 'yes',
            ]
        );

        $this->add_control(
            'display_pagination',
            [
                'label'       => __('Show Pagination', 'opal-service'),
                'type'        => Controls_Manager::SWITCHER,
                'default'     => 'yes',
            ]
        );

        $this->add_control(
            'alignment',
            [
                'label' => __( 'Alignment', 'opal-service' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'default' => 'left',
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'opal-service' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'opal-service' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'opal-service' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} article, {{WRAPPER}} .entry-content' => 'text-align: {{VALUE}}',
                ],
                'prefix_class' => 'layout-icon-',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_box',
            [
                'label'     => __('General', 'opal-service'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'box_background',
            [
                'label'     => __('Background', 'opal-service'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .widget-service article' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'box_padding',
            [
                'label' => __( 'Padding', 'opal-service' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .widget-service article' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'box_margin',
            [
                'label' => __( 'Margin', 'opal-service' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default'    => [
                    'top'    => 0,
                    'right'  => 10,
                    'bottom' => 0,
                    'left'   => 10,
                    'unit '  => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .widget-service article' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_content_padding',
            [
                'label' => __( 'Content padding', 'opal-service' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'box_content_padding',
            [
                'label' => __( 'Padding', 'opal-service' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .entry-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_icon',
            [
                'label'     => __('Icon', 'opal-service'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label'     => __('Color', 'opal-service'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .service-box-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .service-box-icon svg path' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_color_hover',
            [
                'label'     => __('Hover Color', 'opal-service'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} article:hover .service-box-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} article:hover .service-box-icon svg path' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_size',
            [
                'label' => __( 'Icon Size', 'opal-service' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 50,
                ],
                'range' => [
                    'px' => [
                        'min' => 6,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .service-box-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .service-box-icon .icon-image' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'icon_padding',
            [
                'label' => __( 'Padding', 'opal-service' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .service-box-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'icon_margin',
            [
                'label' => __( 'Margin', 'opal-service' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .service-box-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();  

        $this->start_controls_section(
            'section_image',
            [
                'label'     => __('Image', 'opal-service'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control(
            'image_padding',
            [
                'label' => __( 'Padding', 'opal-service' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .service-box-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'image_margin',
            [
                'label' => __( 'Margin', 'opal-service' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .service-box-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();  

        $this->start_controls_section(
            'section_number',
            [
                'label'     => __('Number', 'opal-service'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'style' => 'list_v3'
                ],
            ]
        );

        $this->add_control(
            'number_color',
            [
                'label'     => __('Color', 'opal-service'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .service-box-number .service-number' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'number_color_hover',
            [
                'label'     => __('Hover Color', 'opal-service'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} article:hover .service-number' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'number_typography',
                'selector' => '{{WRAPPER}} .service-number',
            ]
        );
        
        $this->add_control(
            'number_padding',
            [
                'label' => __( 'Padding', 'opal-service' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .service-box-number' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'number_margin',
            [
                'label' => __( 'Margin', 'opal-service' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .service-box-number' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_title',
            [
                'label'     => __('Title', 'opal-service'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .entry-content .service-title a',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __('Color', 'opal-service'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} article .service-title a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_color_hover',
            [
                'label'     => __('Color hover', 'opal-service'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} article .service-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_padding',
            [
                'label' => __( 'Padding', 'opal-service' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} article .service-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'title_margin',
            [
                'label' => __( 'Margin', 'opal-service' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} article .service-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();   

        $this->start_controls_section(
            'section_description',
            [
                'label'     => __('Description', 'opal-service'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'description_typography',
                'selector' => '{{WRAPPER}} article .service-description, {{WRAPPER}} article .service-description p',
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label'     => __('Color', 'opal-service'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} article .service-description, {{WRAPPER}} article .service-description p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'description_padding',
            [
                'label' => __( 'Padding', 'opal-service' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} article .service-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'description_margin',
            [
                'label' => __( 'Margin', 'opal-service' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} article .service-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();   

        $this->start_controls_section(
            'section_button',
            [
                'label'     => __('Button', 'opal-service'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'button_typography',
                'selector' => '{{WRAPPER}} article .service-readmore a',
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label'     => __('Color', 'opal-service'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} article .service-readmore a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_color_hover',
            [
                'label'     => __('Color hover', 'opal-service'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} article .service-readmore a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_padding',
            [
                'label' => __( 'Padding', 'opal-service' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} article .service-readmore a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'button_margin',
            [
                'label' => __( 'Margin', 'opal-service' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} article .service-readmore a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        

        $this->end_controls_section();   
    }

    protected function get_post_categories() {
        $categories = get_terms(array(
                'taxonomy'   => 'opalservice_category_service',
                'hide_empty' => false,
            )
        );
        $results    = array();
        if (!is_wp_error($categories)) {
            foreach ($categories as $category) {
                $results[$category->slug] = $category->name;
            }
        }
        return $results;
    }



    
    public function get_posts_nav_link($page_limit = null) {
        if (!$page_limit) {
            $page_limit = $this->query_posts()->max_num_pages;
        }

        $return = [];

        $paged = $this->get_current_page();

        $link_template     = '<a class="page-numbers %s" href="%s">%s</a>';
        $disabled_template = '<span class="page-numbers %s">%s</span>';

        if ($paged > 1) {
            $next_page = intval($paged) - 1;
            if ($next_page < 1) {
                $next_page = 1;
            }

            $return['prev'] = sprintf($link_template, 'prev', get_pagenum_link($next_page), $this->get_settings('pagination_prev_label'));
        } else {
            $return['prev'] = sprintf($disabled_template, 'prev', $this->get_settings('pagination_prev_label'));
        }

        $next_page = intval($paged) + 1;

        if ($next_page <= $page_limit) {
            $return['next'] = sprintf($link_template, 'next', get_pagenum_link($next_page), $this->get_settings('pagination_next_label'));
        } else {
            $return['next'] = sprintf($disabled_template, 'next', $this->get_settings('pagination_next_label'));
        }

        return $return;
    }
    


    protected function render() {
        $settings = $this->get_settings_for_display();
        
        if(!empty( $settings['categories'])){
            $categories = array();
            foreach($settings['categories'] as $category){
                $cat = get_term_by('slug', $category, 'opalservice_category_service');
                if(!is_wp_error($cat) && is_object($cat)){
                    $categories[] = $cat->slug;
                }
            }
            
            $category = esc_attr( implode( ',', $categories ) ) ;
        } else {
            $category = '';
        }
        
        $limit              = $settings[ 'posts_per_page' ];
        $column             = $settings[ 'column'];
        $table_column       = $settings[ 'column_tablet'] ? $settings[ 'column_tablet'] : 2;
        $mobile_column      = $settings[ 'column_mobile'] ? $settings[ 'column_mobile'] : 1;
        $show_category      = $settings[ 'display_category'];
        $show_readmore      = $settings[ 'display_readmore'];
        $show_description   = $settings[ 'display_description'];
        $show_thumbnail     = $settings[ 'display_thumbnail'];
        $layout             = $settings[ 'style'];
        $max_char           = $settings[ 'max_char'];
        $image_size         = $settings[ 'thumbnail_size'];
        $other_size         = $settings[ 'other_size'];
        $show_pagination    = $settings[ 'display_pagination'];
        $speed              = $settings[ 'speed'];
        $autoplay           = $settings[ 'display_autoplay' ];

            echo do_shortcode( '[opalservice_carousel_service
                layout="'.$layout.'" 
                category="'.$category.'" 
                limit="'.$limit.'" 
                column="'.$column.'" 
                table_column="'.$table_column.'" 
                mobile_column="'.$mobile_column.'" 
                title="" 
                image_size="'.$image_size.'" 
                other_size="'.$other_size.'" 
                max_char="'.$max_char.'" 
                description="" 
                show_description="'.$show_description.'" 
                show_category="'.$show_category.'" 
                show_thumbnail="'.$show_thumbnail.'" 
                speed="'.$speed.'" 
                autoplay="'.$autoplay.'" 
                show_readmore="'.$show_readmore.'" 
                enable_pagination="'.$show_pagination.'"
            ]' );
             
        wp_reset_postdata();
    }

}