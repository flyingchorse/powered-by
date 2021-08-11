<?php
/**
 * @package WordPress
 * @subpackage Powered By
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<hgroup>
			<?php
				if ( ! is_single() ) { ?>
					<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'powered-by' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
				<?php } else { ?>
					<h1 class="entry-title"><?php the_title(); ?></h1>
				<?php }
			?>
			<h2 class="entry-meta"><?php the_terms( $post->ID, 'team', __( 'Presented by: ', 'powered-by' ), ', ', ' ' ); ?></h2>
		</hgroup>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			if ( ! is_single() ) {
				the_excerpt();
			} else {
				the_content();
			}
		?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'powered-by' ), 'after' => '</div>' ) ); ?>
		<?php edit_post_link( __( 'Edit', 'powered-by' ), '<span class="edit-link">', '</span>' ); ?>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
