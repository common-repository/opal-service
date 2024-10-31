<?php 
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

// show by shortcode [opalservice_tabs_services]
echo do_shortcode( '[opalservice_tabs_services category="'.$category.'" layout="'.$layout.'" style="'.$style.'" limit="'.$limit.'"  title="'.$title.'" max_char="'.$max_char.'"  show_readmore="'.$show_readmore.'" image_size="'.$image_size.'" other_size="'.$other_size.'"]' );

