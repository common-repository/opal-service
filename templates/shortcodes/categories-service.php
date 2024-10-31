<?php 

if( class_exists("Opalservice_Query") ):
	$services = Opalservice_Query::getCategoryServices($limit);

	if(!is_wp_error( $services ) && $services):
?>
		<div class="widget widget-service">
			<div class="widget-content">
				<div class="opalservice-recent-service opalservice-rows">
					<?php if($style === 'carousel'): ?>
						<div class="owl-carousel-play">
							<div class="owl-carousel" data-slide="<?php echo esc_attr($column); ?>">
								<?php foreach($services as $service): ?>
									<?php $image_id = get_term_meta ( $service->term_id, 'category-image-id', true ); ?>
			                        <div class="item">
			                        	<?php if($image_id = get_term_meta ( $service->term_id, 'category-image-id', true )): ?>
				                        	<div class="image-category">
				                        		<?php echo wp_get_attachment_image ( $image_id, 'full' ); ?>
				                        	</div>
			                        	<?php endif; ?>
			                        	<h4 class="category-title"><a href="<?php echo esc_url(get_term_link($service)); ?>"><?php echo esc_html($service->name);?></a></h4>
			                        	
			                        </div>
								<?php endforeach; ?>
							</div>
						</div>
					<?php else: ?>
						<?php $colclass = floor(12/$column); ?>
						<div class="row">
							<?php foreach($services as $key=>$service): ?>
								<?php $image_id = get_term_meta ( $service->term_id, 'category-image-id', true ); ?>
		                        <div class="col-lg-<?php echo esc_attr($colclass); ?> col-md-<?php echo esc_attr($colclass); ?> col-sm-6 <?php echo ($key%$column==$column-1)? 'first' : ''; ?>">
		                        	<?php if($image_id = get_term_meta ( $service->term_id, 'category-image-id', true )): ?>
			                        	<div class="image-category">
			                        		<?php echo wp_get_attachment_image ( $image_id, 'full' ); ?>
			                        	</div>
		                        	<?php endif; ?>
		                        	<h4 class="category-title"><a href="<?php echo esc_url(get_term_link($service)); ?>"><?php echo esc_html($service->name);?></a></h4>
		                        </div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>	
				</div>
			</div>	
		</div>
	<?php endif; ?>	
<?php endif; ?>
<?php wp_reset_query();