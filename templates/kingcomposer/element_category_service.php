<?php
$atts = array_merge(
    array(
        'column'   => '4',
        'limit'    => '4',
        'style'    => 'grid'
    ), $atts);
extract( $atts );

// show by shortcode [opalservice_categories_service]
echo do_shortcode( '[opalservice_categories_services limit="'.$limit.'" column="'.$column.'" style="'.$style.'"]' );