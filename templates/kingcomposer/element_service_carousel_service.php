<?php
$atts = array_merge(array(
    'title'             => '',
    'description'       => '',
    'category'          => '',
    'column'            => '',
    'limit'             => '',
    'max_char'          => '',
    'show_description'  => 1,
    'show_category'     => 1,
    'show_thumbnail'    => 1,
    'enable_navigation' => 1,
    'enable_pagination' => 1,
    'speed'             => '',
), $atts);
extract( $atts );
if( $limit < $column){
	$limit = $column;
}
// show by shortcode [opalservice_carousel_service]
echo do_shortcode( '[opalservice_carousel_service
    category="'.$category.'" 
    limit="'.$limit.'" 
    column="'.$column.'" 
    title="'.$title.'" 
    image_size="'.$image_size.'"  
    other_size="'.$other_size.'"  
    max_char="'.$max_char.'"  
    description="'.$description.'"  
    show_description="'.$show_description.'" 
    show_category="'.$show_category.'" 
    show_thumbnail="'.$show_thumbnail.'"
    speed="'.$speed.'" 
    show_readmore="'.$show_readmore.'"
    enable_navigation="'.$enable_pagination.'"
    enable_pagination="'.$enable_pagination.'"
]' );
