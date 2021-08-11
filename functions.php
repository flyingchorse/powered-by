<?php
/**
 * @package WordPress
 * @subpackage Powered By
 */

/**
 * Make theme available for translation
 * Translations can be filed in the /languages/ directory
 * If you're building a theme based on toolbox, use a find and replace
 * to change 'powered-by' to the name of your theme in all the template files
 */
load_theme_textdomain( 'powered-by', TEMPLATEPATH . '/languages' );

$locale = get_locale();
$locale_file = TEMPLATEPATH . "/languages/$locale.php";
if ( is_readable( $locale_file ) )
	require_once( $locale_file );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

/**
 * This theme uses wp_nav_menu() in one location.
 */
register_nav_menus( array(
	'primary' => __( 'Primary Menu', 'powered-by' ),
	'secondary' => __( 'Secondary Menu', 'powered-by' ),
) );

/**
 * Add default posts and comments RSS feed links to head
 */
add_theme_support( 'automatic-feed-links' );

/**
 * Add support for the Aside and Gallery Post Formats
 */
add_theme_support( 'post-formats', array( 'aside', 'image' ) );

// This theme uses Feature Images for per-post/per-page Custom Header images
add_theme_support( 'post-thumbnails', array( 'page' ) );

// We'll be using post thumbnails for custom header images on posts and pages.
set_post_thumbnail_size( '278', '200', true );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function powered_by_page_menu_args($args) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'powered_by_page_menu_args' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function powered_by_widgets_init() {
	// Our default sidebar
	register_sidebar( array (
		'name' => __( 'Sidebar 1', 'powered-by' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );

	// Our intro area on the custom front page template
	register_sidebar( array (
		'name' => __( 'Home Page Intro Area', 'powered-by' ),
		'id' => 'sidebar-2',
		'description' => __( 'An optional widget area for the custom Home Page template', 'powered-by' ),
		'before_widget' => '<aside id="%1$s" class="intro-widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );	
	register_sidebar( array (
		'name' => __( 'Footer Left', 'powered-by' ),
		'id' => 'sidebar-3',
		'description' => __( 'An optional widget area for the footer are', 'powered-by' ),
		'before_widget' => '<aside id="%1$s" class="intro-widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );	
}
add_action( 'init', 'powered_by_widgets_init' );

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 */
function powered_by_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'powered_by_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 */
function powered_by_continue_reading_link() {
	return ' <p><a class="more-link" href="'. get_permalink() . '">' . __( 'Continue&nbsp;reading&nbsp;<span class="meta-nav">&rarr;</span>', 'powered_by' ) . '</a></p>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and powered_by_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
function powered_by_auto_excerpt_more( $more ) {
	return ' &hellip;' . powered_by_continue_reading_link();
}
add_filter( 'excerpt_more', 'powered_by_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 */
function powered_by_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= powered_by_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'powered_by_custom_excerpt_more' );


/**
 * Create a new Custom Post Type for Powered By' exciting TPS 
 
 */





/**
 * Register a custom taxonomy for featuring pages
 */
register_taxonomy(
	'featured',
	'page',
	array(
		'labels' => array(
			'name' => _x( 'Featured', 'powered-by' ),
		),
		'public' => false,
	)
);

/**
 * Set a default term for the Featured Page taxonomy
 */
function powered_by_featured_term() {
	wp_insert_term(
		'Featured',
		'featured'
	);
}
add_action( 'after_setup_theme', 'powered_by_featured_term' );

/**
 * Add a custom meta box for the Featured Page taxonomy
 */
function powered_by_add_meta_mox() {
	add_meta_box(
		'powered-by-featured',
		__( 'Featured Page', 'powered-by' ),
		'powered_by_create_meta_box',
		'page',
		'side',
		'core'
	);
}
add_action( 'add_meta_boxes', 'powered_by_add_meta_mox' );

/**
 * Create a custom meta box for the Featured Page taxonomy
 */
function powered_by_create_meta_box( $post ) {
	
	// Use nonce for verification
  	wp_nonce_field( 'powered_by_featured_page', 'powered_by_featured_page_nonce' );

	// Retrieve the metadata values if the exist
	$use_as_feature = get_post_meta( $post->ID, '_use_as_feature', true );
	
	?>
		<label for="use_as_feature">
			<input type="checkbox" name="use_as_feature" id="use_as_feature" <?php checked( 'on', $use_as_feature ); ?> />
			<?php printf( __( 'Feature on the %1$s front page', 'powered-by' ), '<em>' . get_bloginfo( 'title' ) . '</em>' ); ?>
		</label>
	<?php
}

/**
 * Save the Featured Page meta box data
 */
function powered_by_save_meta_box_data( $post_id ) {

	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times
	if ( ! wp_verify_nonce( $_POST['powered_by_featured_page_nonce'], 'powered_by_featured_page' ) )
		return $post_id;

	// verify if this is an auto save routine. 
	// If it is our form has not been submitted, so we dont want to do anything
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return $post_id;
		
	// Check permissions
	if ( 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) )
			return $post_id;
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return $post_id;
	}

	// OK, we're authenticated: we need to find and save the data

	// Update use_as_feature value, default is off
	$use_as_feature = isset( $_POST['use_as_feature'] ) ? $_POST['use_as_feature'] : 'off';
	update_post_meta( $post_id, '_use_as_feature', $use_as_feature ); // Save the data

	if ( 'on' == $use_as_feature ) {
		// Add the Featured term to this post
		wp_set_object_terms( $post_id, 'Featured', 'featured' );
	} elseif ( 'off' == $use_as_feature ) {
		// Let's not use that term then
		wp_delete_object_term_relationships( $post_id, 'featured' );
	}
		
}
add_action( 'save_post', 'powered_by_save_meta_box_data' );

/**
 * This theme was built with PHP, Semantic HTML, CSS, love, and a Toolbox.
 */