<?php
/**
 * Twenty Fourteen functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

/**
 * Set up the content width value based on the theme's design.
 *
 * @see twentyfourteen_content_width()
 *
 * @since Twenty Fourteen 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 474;
}

/**
 * Twenty Fourteen only works in WordPress 3.6 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '3.6', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'twentyfourteen_setup' ) ) :
/**
 * Twenty Fourteen setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 *
 * @since Twenty Fourteen 1.0
 */
function twentyfourteen_setup() {

	/*
	 * Make Twenty Fourteen available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Fourteen, use a find and
	 * replace to change 'twentyfourteen' to the name of your theme in all
	 * template files.
	 */
	load_theme_textdomain( 'twentyfourteen', get_template_directory() . '/languages' );

	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( array( 'css/editor-style.css', twentyfourteen_font_url(), 'genericons/genericons.css' ) );

	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Enable support for Post Thumbnails, and declare two sizes.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 672, 372, true );
	add_image_size( 'twentyfourteen-full-width', 1038, 576, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'   => __( 'Top primary menu', 'twentyfourteen' ),
		'secondary' => __( 'Secondary menu in left sidebar', 'twentyfourteen' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
	) );

	// This theme allows users to set a custom background.
	add_theme_support( 'custom-background', apply_filters( 'twentyfourteen_custom_background_args', array(
		'default-color' => 'f5f5f5',
	) ) );

	// Add support for featured content.
	add_theme_support( 'featured-content', array(
		'featured_content_filter' => 'twentyfourteen_get_featured_posts',
		'max_posts' => 6,
	) );

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );
}
endif; // twentyfourteen_setup
add_action( 'after_setup_theme', 'twentyfourteen_setup' );

/**
 * Adjust content_width value for image attachment template.
 *
 * @since Twenty Fourteen 1.0
 */
function twentyfourteen_content_width() {
	if ( is_attachment() && wp_attachment_is_image() ) {
		$GLOBALS['content_width'] = 810;
	}
}
add_action( 'template_redirect', 'twentyfourteen_content_width' );

/**
 * Getter function for Featured Content Plugin.
 *
 * @since Twenty Fourteen 1.0
 *
 * @return array An array of WP_Post objects.
 */
function twentyfourteen_get_featured_posts() {
	/**
	 * Filter the featured posts to return in Twenty Fourteen.
	 *
	 * @since Twenty Fourteen 1.0
	 *
	 * @param array|bool $posts Array of featured posts, otherwise false.
	 */
	return apply_filters( 'twentyfourteen_get_featured_posts', array() );
}

/**
 * A helper conditional function that returns a boolean value.
 *
 * @since Twenty Fourteen 1.0
 *
 * @return bool Whether there are featured posts.
 */
function twentyfourteen_has_featured_posts() {
	return ! is_paged() && (bool) twentyfourteen_get_featured_posts();
}

/**
 * Register three Twenty Fourteen widget areas.
 *
 * @since Twenty Fourteen 1.0
 */
function twentyfourteen_widgets_init() {
	require get_template_directory() . '/inc/widgets.php';
	register_widget( 'Twenty_Fourteen_Ephemera_Widget' );

	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'twentyfourteen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Main sidebar that appears on the left.', 'twentyfourteen' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Content Sidebar', 'twentyfourteen' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Additional sidebar that appears on the right.', 'twentyfourteen' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widget Area', 'twentyfourteen' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Appears in the footer section of the site.', 'twentyfourteen' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'twentyfourteen_widgets_init' );

/**
 * Register Lato Google font for Twenty Fourteen.
 *
 * @since Twenty Fourteen 1.0
 *
 * @return string
 */
function twentyfourteen_font_url() {
	$font_url = '';
	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Lato, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Lato font: on or off', 'twentyfourteen' ) ) {
		$font_url = add_query_arg( 'family', urlencode( 'Lato:300,400,700,900,300italic,400italic,700italic' ), "//fonts.googleapis.com/css" );
	}

	return $font_url;
}

/**
 * Enqueue scripts and styles for the front end.
 *
 * @since Twenty Fourteen 1.0
 */
function twentyfourteen_scripts() {
	// Add Lato font, used in the main stylesheet.
	wp_enqueue_style( 'twentyfourteen-lato', twentyfourteen_font_url(), array(), null );

	// Add Genericons font, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.0.3' );

	// Load our main stylesheet.
	wp_enqueue_style( 'twentyfourteen-style', get_stylesheet_uri(), array( 'genericons' ) );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'twentyfourteen-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentyfourteen-style', 'genericons' ), '20131205' );
	wp_style_add_data( 'twentyfourteen-ie', 'conditional', 'lt IE 9' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'twentyfourteen-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20130402' );
	}

	if ( is_active_sidebar( 'sidebar-3' ) ) {
		wp_enqueue_script( 'jquery-masonry' );
	}

	if ( is_front_page() && 'slider' == get_theme_mod( 'featured_content_layout' ) ) {
		wp_enqueue_script( 'twentyfourteen-slider', get_template_directory_uri() . '/js/slider.js', array( 'jquery' ), '20131205', true );
		wp_localize_script( 'twentyfourteen-slider', 'featuredSliderDefaults', array(
			'prevText' => __( 'Previous', 'twentyfourteen' ),
			'nextText' => __( 'Next', 'twentyfourteen' )
		) );
	}

	wp_enqueue_script( 'twentyfourteen-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20140616', true );
}
add_action( 'wp_enqueue_scripts', 'twentyfourteen_scripts' );

/**
 * Enqueue Google fonts style to admin screen for custom header display.
 *
 * @since Twenty Fourteen 1.0
 */
function twentyfourteen_admin_fonts() {
	wp_enqueue_style( 'twentyfourteen-lato', twentyfourteen_font_url(), array(), null );
}
add_action( 'admin_print_scripts-appearance_page_custom-header', 'twentyfourteen_admin_fonts' );

if ( ! function_exists( 'twentyfourteen_the_attached_image' ) ) :
/**
 * Print the attached image with a link to the next attached image.
 *
 * @since Twenty Fourteen 1.0
 */
function twentyfourteen_the_attached_image() {
	$post                = get_post();
	/**
	 * Filter the default Twenty Fourteen attachment size.
	 *
	 * @since Twenty Fourteen 1.0
	 *
	 * @param array $dimensions {
	 *     An array of height and width dimensions.
	 *
	 *     @type int $height Height of the image in pixels. Default 810.
	 *     @type int $width  Width of the image in pixels. Default 810.
	 * }
	 */
	$attachment_size     = apply_filters( 'twentyfourteen_attachment_size', array( 810, 810 ) );
	$next_attachment_url = wp_get_attachment_url();

	/*
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID',
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id ) {
			$next_attachment_url = get_attachment_link( $next_id );
		}

		// or get the URL of the first image attachment.
		else {
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
		}
	}

	printf( '<a href="%1$s" rel="attachment">%2$s</a>',
		esc_url( $next_attachment_url ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

if ( ! function_exists( 'twentyfourteen_list_authors' ) ) :
/**
 * Print a list of all site contributors who published at least one post.
 *
 * @since Twenty Fourteen 1.0
 */
function twentyfourteen_list_authors() {
	$contributor_ids = get_users( array(
		'fields'  => 'ID',
		'orderby' => 'post_count',
		'order'   => 'DESC',
		'who'     => 'authors',
	) );

	foreach ( $contributor_ids as $contributor_id ) :
		$post_count = count_user_posts( $contributor_id );

		// Move on if user has not published a post (yet).
		if ( ! $post_count ) {
			continue;
		}
	?>

	<div class="contributor">
		<div class="contributor-info">
			<div class="contributor-avatar"><?php echo get_avatar( $contributor_id, 132 ); ?></div>
			<div class="contributor-summary">
				<h2 class="contributor-name"><?php echo get_the_author_meta( 'display_name', $contributor_id ); ?></h2>
				<p class="contributor-bio">
					<?php echo get_the_author_meta( 'description', $contributor_id ); ?>
				</p>
				<a class="button contributor-posts-link" href="<?php echo esc_url( get_author_posts_url( $contributor_id ) ); ?>">
					<?php printf( _n( '%d Article', '%d Articles', $post_count, 'twentyfourteen' ), $post_count ); ?>
				</a>
			</div><!-- .contributor-summary -->
		</div><!-- .contributor-info -->
	</div><!-- .contributor -->

	<?php
	endforeach;
}
endif;

/**
 * Extend the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Presence of header image except in Multisite signup and activate pages.
 * 3. Index views.
 * 4. Full-width content layout.
 * 5. Presence of footer widgets.
 * 6. Single views.
 * 7. Featured content layout.
 *
 * @since Twenty Fourteen 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function twentyfourteen_body_classes( $classes ) {
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( get_header_image() ) {
		$classes[] = 'header-image';
	} elseif ( ! in_array( $GLOBALS['pagenow'], array( 'wp-activate.php', 'wp-signup.php' ) ) ) {
		$classes[] = 'masthead-fixed';
	}

	if ( is_archive() || is_search() || is_home() ) {
		$classes[] = 'list-view';
	}

	if ( ( ! is_active_sidebar( 'sidebar-2' ) )
		|| is_page_template( 'page-templates/full-width.php' )
		|| is_page_template( 'page-templates/contributors.php' )
		|| is_attachment() ) {
		$classes[] = 'full-width';
	}

	if ( is_active_sidebar( 'sidebar-3' ) ) {
		$classes[] = 'footer-widgets';
	}

	if ( is_singular() && ! is_front_page() ) {
		$classes[] = 'singular';
	}

	if ( is_front_page() && 'slider' == get_theme_mod( 'featured_content_layout' ) ) {
		$classes[] = 'slider';
	} elseif ( is_front_page() ) {
		$classes[] = 'grid';
	}

	return $classes;
}
add_filter( 'body_class', 'twentyfourteen_body_classes' );

/**
 * Extend the default WordPress post classes.
 *
 * Adds a post class to denote:
 * Non-password protected page with a post thumbnail.
 *
 * @since Twenty Fourteen 1.0
 *
 * @param array $classes A list of existing post class values.
 * @return array The filtered post class list.
 */
function twentyfourteen_post_classes( $classes ) {
	if ( ! post_password_required() && ! is_attachment() && has_post_thumbnail() ) {
		$classes[] = 'has-post-thumbnail';
	}

	return $classes;
}
add_filter( 'post_class', 'twentyfourteen_post_classes' );

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Twenty Fourteen 1.0
 *
 * @global int $paged WordPress archive pagination page count.
 * @global int $page  WordPress paginated post page count.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function twentyfourteen_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'twentyfourteen' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'twentyfourteen_wp_title', 10, 2 );

// Implement Custom Header features.
require get_template_directory() . '/inc/custom-header.php';

// Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

// Add Theme Customizer functionality.
require get_template_directory() . '/inc/customizer.php';

/*
 * Add Featured Content functionality.
 *
 * To overwrite in a plugin, define your own Featured_Content class on or
 * before the 'setup_theme' hook.
 */
if ( ! class_exists( 'Featured_Content' ) && 'plugins.php' !== $GLOBALS['pagenow'] ) {
	require get_template_directory() . '/inc/featured-content.php';
}

add_action( 'init', 'my_custom_init' );

function my_custom_init() {

    $labels = array( 
        'name' => _x( 'メディア', 'media' ),
        'singular_name' => _x( 'メディア', 'media' ),
        'add_new' => _x( 'Add New', 'media' ),
        'add_new_item' => _x( 'Add New MEDIA', 'media' ),
        'edit_item' => _x( 'Edit MEDIA', 'media' ),
        'new_item' => _x( 'New MEDIA', 'media' ),
        'view_item' => _x( 'View MEDIA', 'media' ),
        'search_items' => _x( 'Search MEDIA', 'media' ),
        'not_found' => _x( 'No media found', 'media' ),
        'not_found_in_trash' => _x( 'No media found in Trash', 'media' ),
        'parent_item_colon' => _x( 'Parent MEDIA:', 'media' ),
        'menu_name' => _x( 'メディア', 'media' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        
        'supports' => array( 'title', 'editor', 'thumbnail' ),
        'taxonomies' => array( 'brand-tag' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'media', $args );

    $labels = array( 
        'name' => _x( 'インフォメーション', 'information' ),
        'singular_name' => _x( 'インフォメーション', 'information' ),
        'add_new' => _x( 'Add New', 'information' ),
        'add_new_item' => _x( 'Add New インフォメーション', 'information' ),
        'edit_item' => _x( 'Edit インフォメーション', 'information' ),
        'new_item' => _x( 'New インフォメーション', 'information' ),
        'view_item' => _x( 'View インフォメーション', 'information' ),
        'search_items' => _x( 'Search インフォメーション', 'information' ),
        'not_found' => _x( 'No インフォメーション found', 'information' ),
        'not_found_in_trash' => _x( 'No インフォメーション found in Trash', 'information' ),
        'parent_item_colon' => _x( 'Parent インフォメーション:', 'information' ),
        'menu_name' => _x( 'インフォメーション', 'information' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        
        'supports' => array( 'title', 'editor', 'thumbnail' ),
        'taxonomies' => array( 'brand-tag' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'information', $args );

// 商品のカスタム投稿を登録
add_action( 'init', 'register_cpt_product' );

    $labels = array( 
        'name' => _x( '商品', 'product' ),
        'singular_name' => _x( '商品', 'product' ),
        'add_new' => _x( 'Add New', 'product' ),
        'add_new_item' => _x( 'Add New 商品', 'product' ),
        'edit_item' => _x( 'Edit 商品', 'product' ),
        'new_item' => _x( 'New 商品', 'product' ),
        'view_item' => _x( 'View 商品', 'product' ),
        'search_items' => _x( 'Search 商品', 'product' ),
        'not_found' => _x( 'No 商品 found', 'product' ),
        'not_found_in_trash' => _x( 'No 商品 found in Trash', 'product' ),
        'parent_item_colon' => _x( 'Parent 商品:', 'product' ),
        'menu_name' => _x( '商品', 'product' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'supports' => array( 'title' ),
        'taxonomies' => array( 'brand-tag', 'product-tag' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'product', $args );

    $labels = array( 
        'name' => _x( 'ブランド', 'brand' ),
        'singular_name' => _x( 'ブランド', 'brand' ),
        'add_new' => _x( 'Add New', 'brand' ),
        'add_new_item' => _x( 'Add New ブランド', 'brand' ),
        'edit_item' => _x( 'Edit ブランド', 'brand' ),
        'new_item' => _x( 'New ブランド', 'brand' ),
        'view_item' => _x( 'View ブランド', 'brand' ),
        'search_items' => _x( 'Search ブランド', 'brand' ),
        'not_found' => _x( 'No ブランド found', 'brand' ),
        'not_found_in_trash' => _x( 'No ブランド found in Trash', 'brand' ),
        'parent_item_colon' => _x( 'Parent ブランド:', 'brand' ),
        'menu_name' => _x( 'ブランド', 'brand' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        
        'supports' => array( 'title', 'editor', 'excerpt' ),
        'taxonomies' => array( 'brand-tag' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'brand', $args );

	// カスタム分類
	register_taxonomy(
		'brand-tag',
		array( 'media', 'information', 'product', 'brand' ),
		array(
			'hierarchical' => false,
			'label' => 'ブランドタグ',
		)
	);
	register_taxonomy_for_object_type( 'brand-tag', 'media' );
	register_taxonomy_for_object_type( 'brand-tag', 'information' );
	register_taxonomy_for_object_type( 'brand-tag', 'product' );
	register_taxonomy_for_object_type( 'brand-tag', 'brand' );

	register_taxonomy(
		'product-tag',
		'product',
		array(
			'hierarchical' => true,
//			'update_count_callback' => '_update_post_term_count',
			'label' => '商品カテゴリ',
//			'singular_label' => '商品カテゴリ(singlarラベル)',
//			'public' => true,
//			'show_ui' => true
		)
	);
	register_taxonomy_for_object_type( 'product-tag', 'product' );

}

// アイコンを追加
function add_menu_icons_styles(){
     echo '<style>
          #adminmenu #menu-posts-team div.wp-menu-image:before {
               content: "\f307";
          }
     </style>';
}
add_action( 'admin_head', 'add_menu_icons_styles' );

// サムネイル画像を利用
add_theme_support( 'post-thumbnails', array( 'media', 'information', 'product' ) );
set_post_thumbnail_size( 50, 50 );
// 詳細ページの画像サイズ
// add_image_size('custom_size', 150, 150, true);

// トップページの新着情報にカスタム投稿を含める（投稿は外す）
function chample_latest_posts( $wp_query ) {
    if ( is_home() && ! isset( $wp_query->query_vars['suppress_filters'] ) ) {
        $wp_query->query_vars['post_type'] = array( /*'post',*/ 'media', 'information', 'product' );
    }
}
add_action( 'parse_query', 'chample_latest_posts' );

/*
// カスタム分類の編集ページにカスタムフィールドを追加
add_action ( 'product-tag_add_form_fields', 'extra_taxonomy_fields');

// セレクトボックスを設置
function extra_taxonomy_fields( $tag ) {
//$t_id = $tag->term_id;
//$cat_meta = get_option( "cat_$t_id");

//       $id = get_the_ID();
       //カスタムフィールドの値を取得
//       $paka3select = get_post_meta($id,'paka3select',true);
        $data = array(
//             array("選択してください","",""),
             array("選択してください","","selected"),
//         array("よいよい","よいよい",""),
         );
		$args = array(
			'orderby' 	=> 'name',
			'order'		=> 'ASC',
			'get'		=> 'all',
		);
		$tags = get_terms( 'brand-tag' );
		foreach ( $tags as $tag )
        	array_push($data, array( $tag->name, $tag->name, "" ));

        echo <<<EOS
        ブランド<br>
        <select name="Cat_meta[select]">
EOS;
        foreach($data as $d){
//        if($d[1]==$paka3select) $d[2] ="selected";
        	echo <<<EOS
			<option value="{$d[1]}" {$d[2]}>{$d[0]}
EOS;
		}
       	echo <<<EOS
		</select>
EOS;
}

add_action ( 'edited_term', 'save_extra_taxonomy_fileds');

// 追加情報を保存する
function save_extra_taxonomy_fileds( $term_id ) {
	if ( isset( $_POST['Cat_meta'] ) ) {
		$t_id = $term_id;
		$cat_meta = get_option( "cat_$t_id");
		$cat_keys = array_keys($_POST['Cat_meta']);
		foreach ($cat_keys as $key){
			if (isset($_POST['Cat_meta'][$key])){
				$cat_meta[$key] = $_POST['Cat_meta'][$key];
			}
		}
		update_option( "cat_$t_id", $cat_meta );
	}
}

/*
add_action('admin_print_scripts', 'my_admin_scripts');
add_action('admin_print_styles', 'my_admin_styles');

function my_admin_scripts() {
global $taxonomy;
if( 'タクソノミー名' == $taxonomy ) {
wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
wp_register_script('my-upload', get_bloginfo('template_directory') .'/js/upload.js');
wp_enqueue_script('my-upload');
}
}
function my_admin_styles() {
global $taxonomy;
if( 'タクソノミー名' == $taxonomy ) {
wp_enqueue_style('thickbox');
}
}
*/

// ブランド選択セレクトボックスの項目設定
function my_acf_load_field_brand_select( $field ){
	$field['choices'] = array();
/*
	$the_args = array('post_type' => '●●');
	$the_query = new WP_Query($the_args);
	while ( $the_query->have_posts() ) : $the_query->the_post();
*/
	$args = array(
		'orderby' 	=> 'name',
		'order'		=> 'ASC',
		'get'		=> 'all',
	);
	$tags = get_terms( 'brand-tag' );
	foreach ( $tags as $tag )
		$field['choices'][ $tag->name ] = $tag->name;
//	wp_reset_postdata();
	return $field;
}
add_filter('acf/load_field/name=brand-tagOfProduct-tag', 'my_acf_load_field_brand_select'); 



// 特定の商品カテゴリに属する商品を一覧表示する
// 商品のみのシンプルな表示で、商品カテゴリ名は表示しない
function printProductsSimple($productTagName /* (文字列)商品カテゴリ名 */) {
	// 該当の商品を全て取得
	$args = array(
	    'post_type' => 'product',
//	    'posts_per_page' => 10,
	    'posts_per_page' => 100,
	    'tax_query' => array(
			array(
				'taxonomy' => 'product-tag', //(string) - タクソノミー。
				'field' => 'slug', //(string) - IDかスラッグのどちらでタクソノミー項を選択するか
				'terms' => $productTagName, //(int/string/array) - タクソノミー項
				'include_children' => true, //(bool) - 階層構造を持ったタクソノミーの場合に、子タクソノミー項を含めるかどうか。デフォルトはtrue
			)
		)
	);
	$loop = new WP_Query($args);
	if ( $loop->have_posts() ) {
		echo '<table>';
		$postCount = 0; // 表示した商品をカウント
		$POSTS_PER_ROW = 2; // 一行あたりに表示する商品数
		while($loop->have_posts()) {
			$loop->the_post();
			if( $postCount % $POSTS_PER_ROW == 0 ) echo '<tr>';
			echo '<td>';
				$thumbnail = wp_get_attachment_image_src(post_custom('画像1'),'thumbnail' );
				echo '<a  href="', get_permalink($POST), '"><img src="', $thumbnail[0], '" /></a><br>';
				echo '<a  href="', get_permalink($POST), '">', the_title(), '</a>';
			echo '</td>';
			if( $postCount++ % $POSTS_PER_ROW == $POSTS_PER_ROW - 1 ) echo '</tr>';
		}
		echo '</table>';
	}
	wp_reset_postdata();

}



// 特定のカテゴリに属する商品を一覧表示する。子カテゴリに属するものを含む
function printProducts($productCat /* 商品カテゴリオブジェクト */ ) {
	$args = array(
		'parent'                 => $productCat->term_id,
		'orderby'                  => 'name',
		'order'                    => 'ASC',
		'hide_empty'               => false,
		'taxonomy'                 => 'product-tag',
	);
	$childCats = get_categories( $args );

	// その商品カテゴリに属する商品一覧を表示
	echo '<h1>' . $productCat->name . '</h1>';
	if(count($childCats) == 0) {
		// 子カテゴリを持たない場合
		printProductsSimple($productCat->name);
	} else {
		// 子カテゴリを持つ場合
		foreach ($childCats as $childCat) {
			echo '<b>' . $childCat->name . '</b>';
			printProductsSimple($childCat->name);
		}
	}
}



// 現在の投稿のブランドタグからブランド名を返す
// 戻り値:(文字列|null)ブランド名
function getBrandName() {
	global $post;
	have_posts(); // 2回呼ぶ必要がある
	if ( have_posts() ) {
		the_post();
		$terms = get_the_terms( $post->ID, 'brand-tag' );
		if(count($terms) == 1)
			foreach ( $terms as $term ); // $termのセットのための空ループ
		$name = $term->name;
		wp_reset_postdata();
		return $name;
	}
	wp_reset_postdata();
	return null;
}



// 投稿についているタグを表示する
function printTags(
	$postId, // 投稿のID
	$printsPostType = true // (boolean)投稿の種類を表示するか
) {
	// ブランドタグを表示
	$terms = get_the_terms($postId, 'brand-tag');
	if($terms != false) {
		foreach($terms as $term)
			echo $term->name, '　';
	}

	if($printsPostType) {
		// 投稿の種類を表すタグを表示。これは内部的にはタグではない
		$postType = get_post_type();
		if($postType == 'media')
			echo 'MEDIA　';
		if($postType == 'information')
			echo 'INFORMATION　';
	}
}



// メディアなどの投稿記事を一覧表示において1つ表示する
function printPost() {
?>
	<div>
		<?php the_post_thumbnail(array(68,68)); ?>
		<?php echo get_the_date("Y.n.j"); ?>
		<br>

		<?php printTags($post->ID); ?>
	</div>
	<div>
		<u><b><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></b></u>
		<br>
		<?php echo mb_substr ( get_the_content() , 0, 150 ), "..."; ?>
	</div>
	<p></p>

<?php
}



/*
function set_my_query( $wp_query ) {
    if ( is_admin() || ! $wp_query->is_main_query() )
        return;

    if ($wp_query->is_archive('information'))
        $wp_query->set( 'posts_per_page', 1 ); // 表示件数
    if ($wp_query->is_page('news')) {
        $wp_query->set( 'posts_per_page', 2 ); // 表示件数
    	$wp_query->set( 'post_type', array('media', 'information')); // 表示件数
        $wp_query->set( 'orderby', 'modified' ); // 表示件数
        $wp_query->set( 'paged', $paged ); // 表示件数
    }
}
add_action( 'pre_get_posts', 'set_my_query' );
*/



// 一部ページでリダイレクトをしないように設定
// リダイレクトによって次ページへ移動できない不具合があるため
add_filter('redirect_canonical','my_disable_redirect_canonical');

function my_disable_redirect_canonical( $redirect_url ) {
    if ( is_singular('brand') )
    $redirect_url = false;
    return $redirect_url;
}



