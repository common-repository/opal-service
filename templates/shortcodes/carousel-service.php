<?php 
if( $limit < $column){
	$limit = $column;
}
$_id = wp_generate_uuid4();

if ($category && !empty($category)) {
	$categories = explode(',', $category);
}else{
	$categories = '';
}

if( class_exists("Opalservice_Query") ):
    $query = Opalservice_Query::get_service_by_term_slug( $categories, $limit );
    $args_template = array(
        'layout'             => $layout,
        'show_category'      => $show_category,
        'show_thumbnail'     => $show_thumbnail,
        'show_description'   => $show_description,
        'max_char'           => $max_char,
        'image_size'         => $image_size,
        'other_size'         => $other_size,
        'show_readmore'      => $show_readmore,
        'title'              => $title,
        'description'        => $description,
        'column'             => $column,
        'table_column'       => $table_column,
        'mobile_column'      => $mobile_column, 
        'enable_pagination'  => $enable_pagination,
        'speed'              => $speed,
        'autoplay'           => $autoplay,
    );
?>
<div class="widget widget-service">
    <div class="opalservice-carousel opalservice-rows service-<?php echo esc_attr( $layout ); ?>">
        <?php if( $query->have_posts() ): ?>
        
            <div class="elementor-slick-slider elementor-service-slick-slider" data-slides-show="<?php echo esc_attr($column); ?>" data-table-columns="<?php echo esc_attr($table_column); ?>" data-mobile-columns="<?php echo esc_attr($mobile_column); ?>"  data-pagination="<?php echo esc_attr($enable_pagination); ?>" data-autoplay="<?php echo esc_attr($autoplay); ?>" data-speed="<?php echo esc_attr($speed); ?>" >
               
                <?php $cnt=0; while ( $query->have_posts() ) : $query->the_post(); 
                    $cls = '';
                    if( $cnt++%$column==0 ){
                        $cls .= ' first-child';
                    }
                    $args_template['number'] = $cnt;
                    ?>
                    <div class="slick-slide">
                        <?php if ($layout == "grid_v3"):?>
                        <?php echo Opalservice_Template_Loader::get_template_part( 'content-service-grid-icon',$args_template ); ?> 
                        <?php elseif($layout == "list_v1"):?>
                            <?php echo Opalservice_Template_Loader::get_template_part( 'content-service-list',$args_template ); ?>  
                        <?php elseif($layout == "list_v2"):?>
                            <?php echo Opalservice_Template_Loader::get_template_part( 'content-service-list-icon',$args_template ); ?> 
                        <?php elseif($layout == "list_v3"):?>
                            <?php echo Opalservice_Template_Loader::get_template_part( 'content-service-list-number',$args_template ); ?>   
                        <?php else: ?>
                            <?php echo Opalservice_Template_Loader::get_template_part( 'content-service-grid',$args_template ); ?>  
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
               
            </div>
            <div class="slick-pagination-custom">
                <div class="progressbar">
                    <div class="filled"></div>
                </div>
            </div>
        <?php else: ?>
            <?php echo Opalservice_Template_Loader::get_template_part( 'content-data-none' ); ?>
        <?php endif; ?>
    </div>
</div>
    <script type="text/javascript">
        (function ($) {
            "use strict";
            $(document).ready(function () {
                var $service_slick = $('.elementor-service-slick-slider');
                $service_slick.each(function (i, el) {
                    var $this = $(el),
                        //Setters
                        setSlidesToShow = $this.data('slides-show'),
                        setSlidesToScroll = $this.data('slides-scroll'),
                        setDot = $this.data('pagination'),
                        setAutoplay = $this.data('autoplay'),
                        setAnimation = $this.data('animation'),
                        setEasing = $this.data('easing'),
                        setFade = $this.data('fade'),
                        setSpeed = $this.data('speed'),
                        setSlidesRows = $this.data('rows'),
                        setCenterMode = $this.data('center-mode'),
                        setCenterPadding = $this.data('center-padding'),
                        setPauseOnHover = $this.data('pause-hover'),
                        setVariableWidth = $this.data('variable-width'),
                        setVertical = $this.data('vertical'),
                        setRtl = $this.data('rtl'),
                        setFocusOnSelect = $this.data('focus-on-select'),
                        setLazyLoad = $this.data('lazy-load'),
                        setTabletColumns = $this.data('table-columns'),
                        setMobileColumns = $this.data('mobile-columns')

                    $this.slick({

                        autoplay: setAutoplay ? true : false,
                        autoplaySpeed: setSpeed ? setSpeed : 3000,

                        cssEase: setAnimation ? setAnimation : 'ease',
                        easing: setEasing ? setEasing : 'linear',
                        fade: setFade ? true : false,

                        infinite: true,
                        slidesToShow: setSlidesToShow ? setSlidesToShow : 3,
                        slidesToScroll: setSlidesToScroll ? setSlidesToScroll : 1,
                        centerMode: setCenterMode ? true : false,
                        variableWidth: setVariableWidth ? true : false,
                        pauseOnHover: setPauseOnHover ? true : false,
                        rows: setSlidesRows ? setSlidesRows : 1,
                        vertical: setVertical ? true : false,
                        verticalSwiping: setVertical ? true : false,
                        rtl: setRtl ? true : false,
                        centerPadding: setCenterPadding ? setCenterPadding : 0,
                        focusOnSelect: setFocusOnSelect ? true : false,
                        lazyLoad: setLazyLoad ? setLazyLoad : true,
                        dots: setDot ? true : false,
                        adaptiveHeight: true,
                        responsive: [
                            {
                                breakpoint: 1023,
                                settings: {
                                    slidesToShow: setTabletColumns ? setTabletColumns : 2,
                                    infinite: true,
                                }
                            },
                            {
                                breakpoint: 767,
                                settings: {
                                    slidesToShow: setMobileColumns ? setMobileColumns : 1,
                                }
                            },
                        ]
                    });
                });

            }); // document
        }(jQuery));

    </script>
<?php endif; ?>
<?php wp_reset_query(); ?>