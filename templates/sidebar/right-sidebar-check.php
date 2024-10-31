<?php
/**
 * Right sidebar check.
 *
 * @package wpopalbootstrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$left_sidebar  = apply_filters( "opalservice_left_sidebar"     , 'left-sidebar-service' );
$right_sidebar = apply_filters( "opalservice_right_sidebar"    , 'right-sidebar-service' ); 
$sidebar_pos   = apply_filters( "opalservice_sidebar_archive_position" , get_theme_mod( 'opalservice_sidebar_archive_position' ) ); 
?>

</div><!-- #closing the primary container from /global-templates/left-sidebar-check.php -->

<?php if ( 'right' === $sidebar_pos ) {  ?>
	<div class="wp-col-md-4 widget-area column-sidebar" id="sidebar-right-service" role="complementary">
		<?php dynamic_sidebar( $right_sidebar ); ?>
	</div>
<?php } elseif ( 'both' === $sidebar_pos ) { ?>

	<div class="wp-col-md-3 widget-area column-sidebar" id="sidebar-right-service" role="complementary">
		<?php dynamic_sidebar( $right_sidebar ); ?>
	</div>

<?php } ?>
