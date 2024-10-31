
<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $service, $post;

$service = new Opalservice_Service( get_the_ID() );
?>
<article id="post-<?php the_ID(); ?>" itemscope itemtype="http://schema.org/Service" <?php post_class(); ?>>
	<div class="row">
		<?php echo Opalservice_Template_Loader::get_template_part( 'sidebar/left-sidebar-check'); ?>
		
		<?php
			/**
			 * opalservice_single_service_preview hook by template-functions.php
			 * @hooked opalservice_show_product_images - 10
			 * @hooked opalservice_show_product_images - 15
			 * @hooked opalservice_show_content - 20
			 */
			do_action( 'opalservice_single_service_content' );
		?>

		<?php echo Opalservice_Template_Loader::get_template_part( 'sidebar/right-sidebar-check'); ?>

		

	</div> <!-- //.row -->
	<meta itemprop="url" content="<?php the_permalink(); ?>" />
</article><!-- #post-## -->

