<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $service, $post; 
$service = new Opalservice_Service( get_the_ID() );
$categories = $service->getCategoryTax();
//---------------------------------------
$show_category_option = opalservice_get_option('service_show_category');
$show_category_option = ($show_category_option == true) ? $show_category_option : 0;
$show_category = isset($show_category) ? $show_category : $show_category_option; // check exists kingc
//---
$show_description_option = opalservice_get_option('service_show_description');
$show_description_option = ($show_description_option == true) ? $show_description_option : 0;
$show_description = isset($show_description) ? $show_description : $show_description_option; // check exists kingc
//---
$show_readmore_option = opalservice_get_option('service_show_readmore');
$show_readmore_option = ($show_readmore_option == true) ? $show_readmore_option : 0;
$show_readmore = isset($show_readmore) ? $show_readmore : $show_readmore_option; // check exists kingc
//---
$max_char_option = opalservice_get_option('service_max_char');
$max_char_option = ($max_char_option == true) ? $max_char_option : 50;
$max_char = isset($max_char) ? $max_char : $max_char_option;// check exists kingc


if ($number <= 9) {
	$number = "0".$number;
}
$icon = $service->getIcon();
$iconpicker = $service->getIconPicker();

?>
<article itemscope itemtype="http://schema.org/Doctor" <?php post_class(); ?>>
	<?php do_action( 'opalservice_before_service_loop_item' ); ?>
	<div class="service-list">
		<div class="service-left">
			<div class="service-box-number">
				<div class="service-number">
					<?php echo $number; ?>
				</div>
			</div>
		</div> <!--/.col-lg-4 left-->
		<div class="service-right">
			<div class="entry-content">
				<?php the_title( '<h4 class="service-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' ); ?>
				<?php if($show_category): ?>
			     <div class="service-categories ">
			     <?php foreach( $categories as $categorie ) : 
			     			$namect = $categorie->name.',';
				     		if ($categorie === end($categories) || count($categories) == 1){
				     			$namect = $categorie->name;
				     		}?>
				     	<a href="<?php echo esc_url( get_term_link($categorie->term_id, 'opalservice_category_service') );?>" class="categories-link"><span><?php echo trim( $namect ); ?></span> </a>
					<?php endforeach; ?>
			     </div>	
				<?php endif; ?>
				<div class="service-content">
					<?php if($show_description): ?>
						<div class="service-description">
							<?php echo opalservice_fnc_description($max_char,'...'); ?>
						</div>
					<?php endif?>
					<?php if($show_readmore): ?>
					<div class="service-readmore">
						<a href="<?php echo esc_url( get_permalink() );?>">Read More <i class="fa fa-angle-right"></i> </a>
					</div>
					<?php endif?>
				</div>
			</div><!-- .entry-content -->
		</div> <!--/.col-lg-8 right-->
	</div> <!--/.row chef-list-->
<?php do_action( 'opalservice_after_service_loop_item' ); ?>
<meta itemprop="url" content="<?php the_permalink(); ?>" />
</article><!-- #post-## -->
