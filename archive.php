<?php
/**
 * @package WordPress
 * @subpackage Powered By
 */

get_header(); ?>

		<section id="primary">
			<div id="content" role="main">

				<?php the_post(); ?>

				<header class="page-header">
					<h1 class="page-title">
						<?php
							if ( is_day() ) :
								printf( __( 'Daily Archives: <span>%s</span>', 'powered-by' ), get_the_date() );
							elseif ( is_month() ) :
								printf( __( 'Monthly Archives: <span>%s</span>', 'powered-by' ), get_the_date( 'F Y' ) );
							elseif ( is_year() ) :
								printf( __( 'Yearly Archives: <span>%s</span>', 'powered-by' ), get_the_date( 'Y' ) );
							else :
								_e( 'Archives', 'powered-by' );
							endif;
						?>
					</h1>
				</header>

				<?php rewind_posts(); ?>

				<?php /* Display navigation to next/previous pages when applicable */ ?>
				<?php if ( $wp_query->max_num_pages > 1 ) : ?>
					<nav id="nav-above">
						<h1 class="section-heading"><?php _e( 'Post navigation', 'powered-by' ); ?></h1>
						<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'powered-by' ) ); ?></div>
						<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'powered-by' ) ); ?></div>
					</nav><!-- #nav-above -->
				<?php endif; ?>
				
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
					
					<?php get_template_part( 'content', get_post_format() ); ?>

				<?php endwhile; ?>
				
				<?php /* Display navigation to next/previous pages when applicable */ ?>
				<?php if (  $wp_query->max_num_pages > 1 ) : ?>
					<nav id="nav-below">
						<h1 class="section-heading"><?php _e( 'Post navigation', 'powered-by' ); ?></h1>
						<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'powered-by' ) ); ?></div>
						<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'powered-by' ) ); ?></div>
					</nav><!-- #nav-below -->
				<?php endif; ?>				

			</div><!-- #content -->
		</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>