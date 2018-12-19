<?php 
global $instance, $post;
$format = get_post_format();
$furnikit_bclass = ( has_post_thumbnail() ) ? '' : 'no-thumb ';
$furnikit_bclass .= 'clearfix';
?>
<div id="post-<?php the_ID();?>" <?php post_class( $furnikit_bclass ); ?>>
	<div class="entry clearfix">
		<?php if( $format == '' ){?>
		<div class="entry-content">				
			<div class="content-top clearfix">
				<div class="entry-title">
					<h4><a href="<?php echo get_permalink( $post->ID ) ?>"><?php furnikit_trim_words( $post->post_title ); ?></a></h4>
				</div>
				<div class="entry-meta">
					<div class="entry-date"><?php furnikit_get_time(); ?> - </div>
					<span class="entry-comment">
						<a href="<?php comments_link(); ?>"><?php echo _n( ' Comment', ' Comments', $post-> comment_count , 'furnikit' ); ?></a></a>
					</span>
				</div>
			</div>
		</div>
		<div class="entry-thumb">	
			<?php if ( has_post_thumbnail() ){ ?>
			<a class="entry-hover" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail('furnikit_detail_thumb'); ?>			
			</a>
			<?php } ?>	
			<div class="entry-summary">
				<?php 												
				if ( preg_match('/<!--more(.*?)?-->/', $post->post_content, $matches) ) {
					$content = explode($matches[0], $post->post_content, 2);
					$content = $content[0];
					$content = wp_trim_words($post->post_content, 55, '...');
					echo sprintf( '%s', $content );	
				} else {
					the_content('...');
				}		
				?>	
			</div>
			<div class="readmore"><a href="<?php echo get_permalink($post->ID)?>"><?php esc_html_e('Read More', 'furnikit'); ?></a></div>		
		</div>	
		<?php } else { ?>
		<div class="entry-thumb">	
			<?php if( $format == 'video' || $format == 'audio' ){ ?>	
			<?php echo sprintf( ( $format == 'video' ) ? '<div class="video-wrapper">%s</div>' : '%s', furnikit_get_entry_content_asset( $post->ID ) ); ?>																			
			<?php } ?>
			<?php if( $format == 'image' ){?>
			<div class="entry-thumb-content">
				<a class="entry-hover" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
					<?php the_post_thumbnail('furnikit_detail_thumb');?>				
				</a>	
			</div>
			<?php } ?>
			<?php if( $format == 'gallery' ) { 
				if(preg_match_all('/\[gallery(.*?)?\]/', get_post($instance['post_id'])->post_content, $matches)){
					$attrs = array();
					if (count($matches[1])>0){
						foreach ($matches[1] as $m){
							$attrs[] = shortcode_parse_atts($m);
						}
					}
					$ids = '';
					if (count($attrs)> 0){
						foreach ($attrs as $attr){
							if (is_array($attr) && array_key_exists('ids', $attr)){
								$ids = $attr['ids'];
								break;
							}
						}
					}
					?>
					<div id="gallery_slider_<?php echo esc_attr( $post->ID ); ?>" class="carousel slide gallery-slider" data-interval="0">	
						<div class="carousel-inner">
							<?php
							$ids = explode(',', $ids);						
							foreach ( $ids as $i => $id ){ ?>
							<div class="item<?php echo esc_attr( ( $i== 0 ) ? ' active' : '' );  ?>">			
								<?php echo wp_get_attachment_image($id, 'full'); ?>
							</div>
							<?php }	?>
						</div>
						<a href="#gallery_slider_<?php echo esc_attr( $post->ID ); ?>" class="left carousel-control" data-slide="prev"><?php esc_html_e( 'Prev', 'furnikit' ) ?></a>
						<a href="#gallery_slider_<?php echo esc_attr( $post->ID ); ?>" class="right carousel-control" data-slide="next"><?php esc_html_e( 'Next', 'furnikit' ) ?></a>
					</div>
					<?php }	?>							
					<?php } ?>
				</div>
				<div class="entry-content">				
					<div class="content-top clearfix">
						<div class="entry-title">
							<h4><a href="<?php echo get_permalink($post->ID)?>"><?php furnikit_trim_words( $post->post_title ); ?></a></h4>
						</div>
						<div class="entry-meta">
							<div class="entry-date"><?php furnikit_get_time(); ?> - </div>
							<span class="entry-comment">
								<a href="<?php comments_link(); ?>"><?php echo _n( ' Comment', ' Comments', $post-> comment_count , 'furnikit' ); ?></a></a>
							</span>
						</div>
						<div class="entry-summary">
							<?php 												
							if ( preg_match('/<!--more(.*?)?-->/', $post->post_content, $matches) ) {
								$content = explode($matches[0], $post->post_content, 2);
								$content = $content[0];
								$content = wp_trim_words($post->post_content, 55, '...');
								echo sprintf( '%s', $content );	
							} else {
								the_content('...');
							}		
							?>	
						</div>
						<div class="readmore"><a href="<?php echo get_permalink($post->ID)?>"><?php esc_html_e('Read More', 'furnikit'); ?></a></div>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>