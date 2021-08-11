<?php
/**
 * Template Name: Home page
 *
 * A custom home page for the Powered By theme
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package WordPress
 * @subpackage Powered By
 */

get_header(); ?>

		<div id="primary">
			<div id="site-intro">
				<?php if ( ! dynamic_sidebar( 'sidebar-2' ) ) : ?>
				<p><?php bloginfo( 'description' ); ?></p>
				<?php endif; ?>
			</div><!-- #site-intro -->
			
			<div id="features">
				<?php
					$args = array(
						'order' => 'DESC',
						'post_type' => 'page',
						'posts_per_page' => '3',
						'tax_query' => array(
								array(
									'taxonomy' => 'featured',
									'field' => 'slug',
									'terms' => 'featured'
								)
						),
					);
					$features = new WP_Query();
					$features->query( $args );

					while ($features->have_posts()) : $features->the_post(); ?>
						<a href="<?php the_permalink(); ?>">
							<h2><?php the_title(); ?></h2>
							<?php if ( has_post_thumbnail() ) the_post_thumbnail(); ?>
						</a>
					<?php endwhile;
				?>
			</div><!-- #features -->
			
			<section id="recent-articles">
				<h1 class="section-title"><?php _e( 'Recent Articles from the Blog', 'powered-by' ); ?></h1>
				
				<?php
					$args = array(
						'order' => 'DESC',
						'posts_per_page' => 4,
						'tax_query' => array(
							array (
								'taxonomy' => 'post_format',
								'terms' => array( 'post-format-aside', 'post-format-image' ),
								'field' => 'slug',
								'operator' => 'NOT IN',
							),
						),
					);
					$recent_articles = new WP_Query();
					$recent_articles->query( $args );

					while ($recent_articles->have_posts()) : $recent_articles->the_post(); ?>
						<?php
							$odd_or_even = ('odd'==$odd_or_even) ? 'even' : 'odd';
							get_template_part( 'content', 'front' );
						?>
					<?php endwhile;
				?>
				
				<nav id="older-articles">
					<a href="<?php echo home_url( '/' ); ?>blog/">More from our blog &rarr;</a>
				</nav><!-- #older-reports -->
			</section><!-- #recent-articles -->
			
			<section id="recent-reports">
				<h1 class="section-title"><?php _e( 'Recent Reports', 'powered-by' ); ?></h1>
				
				<h2>Our Fabulous TPS Reports</h2>
				<p>Curabitur eget augue ac dolor iaculis laoreet sit amet et tortor. Praesent imperdiet libero ut justo tincidunt at tincidunt metus vulputate.</p>
				
				<?php
					// Create a custom WP_Query instance for our Custom Post Type, powered_by_tps_reports
					$args = array(
						'order' => 'DESC',
						'post_type' => 'pb_tps_reports',
					);
					$tps_reports = new WP_Query();
					$tps_reports->query( $args );
				?>
					
				<ul>
				<?php
				// Loop through our TPS Reports
				while ( $tps_reports->have_posts() ) : $tps_reports->the_post(); ?>
					<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
				<?php endwhile;
				?>
				</ul>
				
				<nav id="older-reports">
					<a href="<?php echo home_url( '/' ); ?>reports/">More reports &rarr;</a>
				</nav><!-- #older-reports -->
			</section><!-- #recent-reports -->
			
		</div><!-- #primary -->

<?php get_footer(); ?>
