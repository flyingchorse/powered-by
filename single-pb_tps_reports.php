<?php
/**
 * @package WordPress
 * @subpackage Powered By
 */

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">

			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				
				<?php get_template_part( 'content', 'tps' ); ?>

				<?php comments_template( '', true ); ?>

				<nav id="nav-below">
					<h1 class="section-heading"><?php _e( 'Post navigation', 'powered-by' ); ?></h1>
					<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'powered-by' ) . '</span> %title' ); ?></div>
					<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'powered-by' ) . '</span>' ); ?></div>
				</nav><!-- #nav-below -->

			<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary -->

		<div id="secondary" class="widget-area documents" role="complementary">
			<aside class="widget">
			<h2 class="widget-title"><?php _e( 'Download', 'powered-by' );  ?></h2>
			<?php
			$args = array( 'post_type' => 'attachment', 'numberposts' => -1, 'post_status' => null, 'post_parent' => $post->ID ); 
			$attachments = get_posts($args);
			if ($attachments) {
				foreach ( $attachments as $attachment ) { ?>
					<figure class="document">
						<?php the_attachment_link( $attachment->ID , false ); ?>
						<figcaption>
							<?php echo apply_filters( 'the_title' , $attachment->post_title ); ?>
						</figcaption>
					</figure>
				<?php }
			}
			?>
			</aside<!-- .widget -->
		</div><!-- #secondary .widget-area -->
<?php get_footer(); ?>