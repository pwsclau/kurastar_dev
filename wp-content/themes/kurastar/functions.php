<?php
/**
 * Twenty Fifteen functions and definitions
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
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Twenty Fifteen 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 660;
}

/**
 * Twenty Fifteen only works in WordPress 4.1 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.1-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'twentyfifteen_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Twenty Fifteen 1.0
 */
function twentyfifteen_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on twentyfifteen, use a find and replace
	 * to change 'twentyfifteen' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'twentyfifteen', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 825, 510, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu',      'twentyfifteen' ),
		'social'  => __( 'Social Links Menu', 'twentyfifteen' ),
		'category'  => __( 'Search Category Menu', 'twentyfifteen' ),
		'country'  => __( 'Search Country Menu Footer', 'twentyfifteen' ),
		'country-main'  => __( 'Search Country Menu Main', 'twentyfifteen' ),
		'footer'  => __( 'Footer Menu', 'twentyfifteen' ),
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
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );

	$color_scheme  = twentyfifteen_get_color_scheme();
	$default_color = trim( $color_scheme[0], '#' );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'twentyfifteen_custom_background_args', array(
		'default-color'      => $default_color,
		'default-attachment' => 'fixed',
	) ) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', 'genericons/genericons.css', twentyfifteen_fonts_url() ) );
}
endif; // twentyfifteen_setup
add_action( 'after_setup_theme', 'twentyfifteen_setup' );

add_action( 'init', 'create_post_type' );
function create_post_type() {

  register_post_type( 'acme_article',
    array(
      'labels' => array('name' => __('Article'),
      'singular_name' => __('Article'),
      'add_new_item' => __('Add New Article'),
      'edit_item' => __('Edit Article'),
           ),
      'public' => true,
	  '_builtin' => false,
	  'query_var' => true,
	  'rewrite' => array('slug' => 'article', 'with_front' => true),
      'show_ui' => true,
      'supports' => array('title','editor','thumbnail', 'author' )
  ));

  $labels = array(
      'name'                       => _x( 'Categories', 'taxonomy general name' ),
      'singular_name'              => _x( 'Category', 'taxonomy singular name' ),
      'search_items'               => __( 'Search Categories' ),
      'popular_items'              => __( 'Popular Categories' ),
      'all_items'                  => __( 'All Categories' ),
      'parent_item'                => null,
      'parent_item_colon'          => null,
      'edit_item'                  => __( 'Edit Category' ),
      'update_item'                => __( 'Update Category' ),
      'add_new_item'               => __( 'Add New Category' ),
      'new_item_name'              => __( 'New Category Name' ),
      'separate_items_with_commas' => __( 'Separate categories with commas' ),
      'add_or_remove_items'        => __( 'Add or remove catedgories' ),
      'choose_from_most_used'      => __( 'Choose from the most used categories' ),
      'not_found'                  => __( 'No categories found.' ),
      'menu_name'                  => __( 'Categories' ),
  );

  $args = array(
      'hierarchical'          => true,
      'labels'                => $labels,
      'show_ui'               => true,
      'show_admin_column'     => true,
      'update_count_callback' => '_update_post_term_count',
      'query_var'             => true,
      'rewrite'               => array( 'slug' => 'article-cat' ),
  );

  register_taxonomy( 'article_cat', 'acme_article', $args );

    $labels = array(
      'name'                       => _x( 'Countries', 'taxonomy general name' ),
      'singular_name'              => _x( 'Country', 'taxonomy singular name' ),
      'search_items'               => __( 'Search Countries' ),
      'popular_items'              => __( 'Popular Countries' ),
      'all_items'                  => __( 'All Countries' ),
      'parent_item'                => null,
      'parent_item_colon'          => null,
      'edit_item'                  => __( 'Edit Country' ),
      'update_item'                => __( 'Update Country' ),
      'add_new_item'               => __( 'Add New Country' ),
      'new_item_name'              => __( 'New Country Name' ),
      'separate_items_with_commas' => __( 'Separate categories with commas' ),
      'add_or_remove_items'        => __( 'Add or remove categories' ),
      'choose_from_most_used'      => __( 'Choose from the most used categories' ),
      'not_found'                  => __( 'No categories found.' ),
      'menu_name'                  => __( 'Countries' ),
  );

  $args = array(
      'hierarchical'          => true,
      'labels'                => $labels,
      'show_ui'               => true,
      'show_admin_column'     => true,
      'update_count_callback' => '_update_post_term_count',
      'query_var'             => true,
      'rewrite'               => array( 'slug' => 'article-country-cat' ),
  );

  register_taxonomy( 'article_country_cat', 'acme_article', $args );
}

//to add tags in custom post type
add_action( 'init', 'custom_tag' );
function custom_tag() {
    register_taxonomy_for_object_type( 'post_tag', 'acme_article' );
};

add_action( 'add_meta_boxes', 'add_location_metabox' );
// Add the Location Metabox
function add_location_metabox() {
    add_meta_box('wpt_location', 'Location', 'wpt_location', 'acme_article', 'side', 'default');
}

// The Location Metabox
function wpt_location() {
    global $post;

    // Noncename needed to verify where the data originated
    echo '<input type="hidden" name="location_noncename" id="location_noncename" value="' .
        wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

    // Get the location data if its already been entered
    $location = get_post_meta($post->ID, '_custom_location', true);

    // Echo out the field
    echo '<input type="text" name="location" id="custom-location" value="' . $location  . '" class="widefat" />';

}

// Save the Metabox Data
function wpt_save_location_meta($post_id, $post) {

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if ( !wp_verify_nonce( $_POST['location_noncename'], plugin_basename(__FILE__) )) {
        return $post->ID;
    }

    // Is the user allowed to edit the post or page?
    if ( !current_user_can( 'edit_post', $post->ID ))
        return $post->ID;

    // OK, we're authenticated: we need to find and save the data
    $key = '_custom_location';

    if(get_post_meta($post->ID, $key, FALSE)) {
        update_post_meta($post->ID, $key,  $_POST['location']);
    } else {
        add_post_meta($post->ID, $key, $_POST['location'], true);
    }

    if(!$_POST['location']) delete_post_meta($post->ID, $key); // Delete if blank

}

add_action('save_post', 'wpt_save_location_meta', 1, 2); // save the custom fields


/**
 * Register widget area.
 *
 * @since Twenty Fifteen 1.0
 *
 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
 */
function twentyfifteen_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Ranking Article', 'twentyfifteen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'twentyfifteen' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s sideboxcontent rankwrap rankarticle">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="sidetitle">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Ranking Country', 'twentyfifteen' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'twentyfifteen' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s sideboxcontent rankwrap rankarticle rankcountry">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="sidetitle">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'twentyfifteen_widgets_init' );

if ( ! function_exists( 'twentyfifteen_fonts_url' ) ) :
/**
 * Register Google fonts for Twenty Fifteen.
 *
 * @since Twenty Fifteen 1.0
 *
 * @return string Google fonts URL for the theme.
 */
function twentyfifteen_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Noto Sans, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Noto Sans font: on or off', 'twentyfifteen' ) ) {
		$fonts[] = 'Noto Sans:400italic,700italic,400,700';
	}

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Noto Serif, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Noto Serif font: on or off', 'twentyfifteen' ) ) {
		$fonts[] = 'Noto Serif:400italic,700italic,400,700';
	}

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Inconsolata, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Inconsolata font: on or off', 'twentyfifteen' ) ) {
		$fonts[] = 'Inconsolata:400,700';
	}

	/*
	 * Translators: To add an additional character subset specific to your language,
	 * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
	 */
	$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'twentyfifteen' );

	if ( 'cyrillic' == $subset ) {
		$subsets .= ',cyrillic,cyrillic-ext';
	} elseif ( 'greek' == $subset ) {
		$subsets .= ',greek,greek-ext';
	} elseif ( 'devanagari' == $subset ) {
		$subsets .= ',devanagari';
	} elseif ( 'vietnamese' == $subset ) {
		$subsets .= ',vietnamese';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), '//fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

function count_posts($menu_slug){

	$count = 0;
	query_posts( array( 'post_type' => 'acme_article', 
						'' => '', 
                		'meta_value' => $menu_slug,) );
        	while ( have_posts() ) : the_post(); 
            	$count = $count + 1;
 			endwhile;
 return $count;
}

function get_wpposts(){

	if (isset($_POST['country']) && isset($_POST['category']) ){

   $country = $_POST['country'];
   $category = $_POST['category'];

   $cat = "category";
   global $wpdb;
   $results = $wpdb->get_results( 'SELECT * FROM `wp_postmeta` WHERE `meta_key` = "category" AND `meta_value` = "'.$category.'" ' );
   foreach ($results as $post){
              
      $myresults = $wpdb->get_results( 'SELECT * FROM `wp_postmeta` WHERE `meta_key` = "select_country" AND `meta_value` = "'.$country.'" ' );
          foreach ($myresults as $mypost){

               echo $post->meta_value.'|'.$mypost->meta_value.'|'.$mypost->post_id.'<br>';
               get_post($mypost->post_id);

              return $mypost->id;
           }
             
   }
}
 return $country;
}

/**
 * JavaScript Detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Fifteen 1.1
 */
function twentyfifteen_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'twentyfifteen_javascript_detection', 0 );

/**
 * Enqueue scripts and styles.
 *
 * @since Twenty Fifteen 1.0
 */
function twentyfifteen_scripts() {

	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'twentyfifteen-fonts', twentyfifteen_fonts_url(), array(), null );

	// Add Genericons, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.2' );

	// Load our main stylesheet.
	wp_enqueue_style( 'twentyfifteen-style', get_stylesheet_uri() );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'twentyfifteen-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentyfifteen-style' ), '20141010' );
	wp_style_add_data( 'twentyfifteen-ie', 'conditional', 'lt IE 9' );

	// Load the Internet Explorer 7 specific stylesheet.
	wp_enqueue_style( 'twentyfifteen-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'twentyfifteen-style' ), '20141010' );
	wp_style_add_data( 'twentyfifteen-ie7', 'conditional', 'lt IE 8' );

	wp_enqueue_script( 'twentyfifteen-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20141010', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'twentyfifteen-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20141010' );
	}

	wp_enqueue_script( 'twentyfifteen-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20150330', true );
	wp_localize_script( 'twentyfifteen-script', 'screenReaderText', array(
		'expand'   => '<span class="screen-reader-text">' . __( 'expand child menu', 'twentyfifteen' ) . '</span>',
		'collapse' => '<span class="screen-reader-text">' . __( 'collapse child menu', 'twentyfifteen' ) . '</span>',
	) );



}
add_action( 'wp_enqueue_scripts', 'twentyfifteen_scripts' );

function add_admin_scripts( $hook ) {

    global $post;


    if ( 'acme_article' === $post->post_type ) {
        wp_enqueue_script(  'maps-google-api', 'http://maps.google.com/maps/api/js?v=3.13&sensor=false&libraries=places&language=en' );
        wp_enqueue_script(  'location', get_stylesheet_directory_uri().'/js/location.js' );

    }

}
add_action( 'admin_enqueue_scripts', 'add_admin_scripts', 10, 1 );

/**
 * Add featured image as background image to post navigation elements.
 *
 * @since Twenty Fifteen 1.0
 *
 * @see wp_add_inline_style()
 */
function twentyfifteen_post_nav_background() {
	if ( ! is_single() ) {
		return;
	}

	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
	$css      = '';

	if ( is_attachment() && 'attachment' == $previous->post_type ) {
		return;
	}

	if ( $previous &&  has_post_thumbnail( $previous->ID ) ) {
		$prevthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $previous->ID ), 'post-thumbnail' );
		$css .= '
			.post-navigation .nav-previous { background-image: url(' . esc_url( $prevthumb[0] ) . '); }
			.post-navigation .nav-previous .post-title, .post-navigation .nav-previous a:hover .post-title, .post-navigation .nav-previous .meta-nav { color: #fff; }
			.post-navigation .nav-previous a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
	}

	if ( $next && has_post_thumbnail( $next->ID ) ) {
		$nextthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next->ID ), 'post-thumbnail' );
		$css .= '
			.post-navigation .nav-next { background-image: url(' . esc_url( $nextthumb[0] ) . '); border-top: 0; }
			.post-navigation .nav-next .post-title, .post-navigation .nav-next a:hover .post-title, .post-navigation .nav-next .meta-nav { color: #fff; }
			.post-navigation .nav-next a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
	}

	wp_add_inline_style( 'twentyfifteen-style', $css );
}
add_action( 'wp_enqueue_scripts', 'twentyfifteen_post_nav_background' );

/**
 * Display descriptions in main navigation.
 *
 * @since Twenty Fifteen 1.0
 *
 * @param string  $item_output The menu item output.
 * @param WP_Post $item        Menu item object.
 * @param int     $depth       Depth of the menu.
 * @param array   $args        wp_nav_menu() arguments.
 * @return string Menu item with possible description.
 */
function twentyfifteen_nav_description( $item_output, $item, $depth, $args ) {
	if ( 'primary' == $args->theme_location && $item->description ) {
		$item_output = str_replace( $args->link_after . '</a>', '<div class="menu-item-description">' . $item->description . '</div>' . $args->link_after . '</a>', $item_output );
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'twentyfifteen_nav_description', 10, 4 );

/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @since Twenty Fifteen 1.0
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
function twentyfifteen_search_form_modify( $html ) {
	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}
add_filter( 'get_search_form', 'twentyfifteen_search_form_modify' );

/**
 * Implement the Custom Header feature.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/customizer.php';



/**
 * Custom functions.
 */
require get_template_directory() . '/inc/custom-function.php';

/**
 * Custom messages.
 */
require get_template_directory() . '/inc/flash-message.php';


/**
 * Custom shortcodes.
 */
require get_template_directory() . '/inc/shortcode.php';



function posts_for_current_author($query) {
  
  global $user_ID;
    
    if(is_admin()) {

        if(!is_super_admin( $user_ID )) {

          $query->set('author',  $user_ID);
        }

      return $query;

    }
  
}
add_filter('pre_get_posts', 'posts_for_current_author');


/* Fix nextend facebook connect doesn't remove cookie after logout */
if (!function_exists('clear_nextend_uniqid_cookie')) {
    function clear_nextend_uniqid_cookie(){
        setcookie( 'nextend_uniqid',' ', time() - YEAR_IN_SECONDS, '/', COOKIE_DOMAIN );
        return 0;
    }
}

add_action('clear_auth_cookie', 'clear_nextend_uniqid_cookie');


/*Fix custom taxonomy term page not found*/

add_action('init', 'custom_taxonomy_flush_rewrite');
function custom_taxonomy_flush_rewrite() {
    global $wp_rewrite;
    $wp_rewrite->flush_rules();
}

function my_function_admin_bar(){ return false; }
add_filter( 'show_admin_bar' , 'my_function_admin_bar');

/*Change link of custom post type - Article*/
function article_links($post_link, $post = 0) {
    if($post->post_type === 'acme_article') {
        return home_url('article/' . $post->ID . '/');
    }
    else{
        return $post_link;
    }
}
add_filter('post_type_link', 'article_links', 1, 3);

/*Add the correct rewrites rules to prevent page not found*/
function article_rewrites_init(){
    add_rewrite_rule('article/([0-9]+)?$', 'index.php?post_type=acme_article&p=$matches[1]', 'top');
}
add_action('init', 'article_rewrites_init');


/*Custom breadcrumb in curator detail page only, to display the curator name*/
function custom_breadcrumb() {

	$uri = trim($_SERVER["HTTP_HOST"] . $_SERVER["REDIRECT_URL"], '/');              
  	$uri = explode('/', $uri);
 
  	$breadcrumb = '';

  	if($uri['1'] == 'curator-detail') {
	   
	    $user_id = $_GET['id'];
		$user 	 = get_userdata( $user_id );

		$breadcrumb = '<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" title="Go to Home." href="/" class="home">Home</a></span>';
		$breadcrumb .= '<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" title="Go to Home." href="'.get_permalink().'?id='.$user_id.'" class="curator-detail">Curator Detail</a></span>';
		$breadcrumb .= '<span typeof="v:Breadcrumb"><span property="v:title">'.$user->display_name.'</span></span>';
		
		$breadcrumb.="";

  	}
	
	return $breadcrumb;
}

add_action('init', 'session_ajax');
function session_ajax() {
	
	if (!session_id()) {
      session_start();
    }

    //unset($_SESSION);
}


function tab_ajax_request() {


     	$params = array( 
                'post_type'       => $_POST['post_type'], 
                'posts_per_page'  => CUSTOM_POST_PER_PAGE, 
                'paged'           => $_POST['paged'], 
                'author'          => $_POST['author'], 
                'post_status'     => $_POST['status'],
                'orderby'         => $_POST['orderby'],
                'order'           => $_POST['order']
		);
     	
     	 $ctr = 0;
         
         $wp_query = new WP_Query( $params );
	   	 $html = "";    

         if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();
         	

			$category = wp_get_post_terms($post->ID, 'article_cat', array("fields" => "names"));
			$countries  = wp_get_post_terms($post->ID, 'article_country_cat', array("fields" => "names"));



		    $html .='<li>';

			  $html .='<a href="'.get_permalink().'" class="post-list-thumb-wrap">';
			  $html .='<div class="postimg" style="background: url('.getArticleImage($post->ID).')"></div>';
			  $html .='</a>';

			  $html .='<div class="labels">';
				  if($countries) {
				  	foreach($countries as $country) {
				  		$html .='<a href="/search-results/?country='.$country.'&category=select+category&post_type=post+type+curators-cat" class="countrylabel">';
				  		$html .='<i class="fa fa-map-marker"></i>';
				  		$html .= $country;
				  		$html .='</a>';
				  	}
				  }

				  if($category) {
				  	foreach($category as $cat) {
				  		$html .='<a href="/search-results/?country=select&category='.$cat.'+category&post_type=post+type+curators-cat" class="countrylabel">';
				  		$html .='<i class="fa fa-map-marker"></i>';
				  		$html .= $cat;
				  		$html .='</a>';
				  	}
				  }
			  $html .='</div>';

			$html .='</li>';
		$ctr++;
		endwhile; endif;



    echo json_encode(array('post'=>$_POST, 'paged'=> $_POST['paged'],  'post_status'=> $_POST['status'], 'result' => $html, 'count' => $ctr, 'max' => $wp_query->max_num_pages ));

    die();

}


add_action('wp_ajax_tab_ajax_request', 'tab_ajax_request');
add_action('wp_ajax_nopriv_tab_ajax_request', 'tab_ajax_request');



function favorite_tab_ajax_request() {


     	$params = array(
                  'post_type'       => 'acme_article', 
                  'posts_per_page'  => CUSTOM_POST_PER_PAGE, 
                  'paged'           => $_POST['paged'], 
                  'meta_query'        => array(
                    'relation'  => 'AND',
                      array(
                          'key' => '_user_liked',
                          'value' => $_POST['author'],
                          'compare' => '='
                      )
                  )
              );
     	
     	 $ctr = 0;
         
         $wp_query = new WP_Query( $params );
	   	 $html = "";    

         if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();
         	

			$category = wp_get_post_terms($post->ID, 'article_cat', array("fields" => "names"));
			$countries  = wp_get_post_terms($post->ID, 'article_country_cat', array("fields" => "names"));




		    $html .='<li>';

			  $html .='<a href="'.get_permalink().'" class="post-list-thumb-wrap">';
			  $html .='<div class="postimg" style="background: url('.getArticleImage($post->ID).')"></div>';
			  $html .='</a>';

			  $html .='<div class="labels">';
				  if($countries) {
				  	foreach($countries as $country) {
				  		$html .='<a href="/search-results/?country='.$country.'&category=select+category&post_type=post+type+curators-cat" class="countrylabel">';
				  		$html .='<i class="fa fa-map-marker"></i>';
				  		$html .= $country;
				  		$html .='</a>';
				  	}
				  }

				  if($category) {
				  	foreach($category as $cat) {
				  		$html .='<a href="/search-results/?country=select&category='.$cat.'+category&post_type=post+type+curators-cat" class="countrylabel">';
				  		$html .='<i class="fa fa-map-marker"></i>';
				  		$html .= $cat;
				  		$html .='</a>';
				  	}
				  }
			  $html .='</div>';

			$html .='</li>';
		$ctr++;
		endwhile; endif;



    echo json_encode(array('post'=>$_POST, 'paged'=> $_POST['paged'],  'post_status'=> $_POST['status'], 'result' => $html, 'count' => $ctr, 'max' => $wp_query->max_num_pages ));

    die();

}


add_action('wp_ajax_favorite_tab_ajax_request', 'favorite_tab_ajax_request');
add_action('wp_ajax_nopriv_favorite_tab_ajax_request', 'favorite_tab_ajax_request');



function default_ajax_request() {
global $wpdb;

	$sql = "SELECT * FROM  {$wpdb->prefix}posts WHERE post_type = 'acme_article' AND post_status = 'publish' order by post_date DESC LIMIT {$_POST['paged']},".CUSTOM_POST_PER_PAGE."";
	$results = $wpdb->get_results( $sql );


	$count = "SELECT COUNT(*) FROM  {$wpdb->prefix}posts WHERE post_type = 'acme_article' AND post_status = 'publish' order by post_date DESC";
	$max = $wpdb->get_var( $count );


 	$ctr = 0;

   	$html = "";    

   	foreach($results as $res) {

			$category = wp_get_post_terms($res->ID, 'article_cat', array("fields" => "names"));
			$countries  = wp_get_post_terms($res->ID, 'article_country_cat', array("fields" => "names"));



		    $html .='<li>';

			  $html .='<a href="'.get_permalink($res->ID).'" class="post-list-thumb-wrap">';
			  $html .='<div class="postimg" style="background: url('.getArticleImage($res->ID).')"></div>';
			  $html .='</a>';

			  $html .='<div class="labels">';
				  if($countries) {
				  	foreach($countries as $country) {
				  		$html .='<a href="/search-results/?country='.$country.'&category=select+category&post_type=post+type+curators-cat" class="countrylabel">';
				  		$html .='<i class="fa fa-map-marker"></i>';
				  		$html .= $country;
				  		$html .='</a>';
				  	}
				  }

				  if($category) {
				  	foreach($category as $cat) {
				  		$html .='<a href="/search-results/?country=select&category='.$cat.'+category&post_type=post+type+curators-cat" class="countrylabel">';
				  		$html .='<i class="fa fa-map-marker"></i>';
				  		$html .= $cat;
				  		$html .='</a>';
				  	}
				  }
			  $html .='</div>';

			$html .='</li>';
		$ctr++;
	}

    echo json_encode(array('post'=>	$sql, 'paged'=> $_POST['paged'],  'post_status'=> 'publish', 'result' => $html, 'count' => $ctr + $_POST['paged'], 'max' => (int)$max ));

    die();

}

add_action('wp_ajax_default_ajax_request', 'default_ajax_request');
add_action('wp_ajax_nopriv_default_ajax_request', 'default_ajax_request');


function custom_search_ajax_request() {

	global $wpdb;

  	$sql ="";
  	$sql2 ="";
  	$condition ="";
  	$orderby ="";
  	$orderb2 ="";


  	$sql ="SELECT p.* 
          FROM {$wpdb->prefix}posts p
          INNER JOIN {$wpdb->prefix}term_relationships ON ( p.ID = {$wpdb->prefix}term_relationships.object_id ) 
          INNER JOIN {$wpdb->prefix}term_taxonomy ON ( {$wpdb->prefix}term_relationships.term_taxonomy_id = {$wpdb->prefix}term_taxonomy.term_taxonomy_id ) 
          INNER JOIN {$wpdb->prefix}terms ON ( {$wpdb->prefix}term_taxonomy.term_id = {$wpdb->prefix}terms.term_id ) 
          WHERE p.post_type =  'acme_article' ";

    $sql2 ="SELECT p.*
          FROM {$wpdb->prefix}posts p
          INNER JOIN {$wpdb->prefix}term_relationships ON ( p.ID = {$wpdb->prefix}term_relationships.object_id ) 
          INNER JOIN {$wpdb->prefix}term_taxonomy ON ( {$wpdb->prefix}term_relationships.term_taxonomy_id = {$wpdb->prefix}term_taxonomy.term_taxonomy_id ) 
          INNER JOIN {$wpdb->prefix}terms ON ( {$wpdb->prefix}term_taxonomy.term_id = {$wpdb->prefix}terms.term_id ) 
          WHERE p.post_type = 'acme_article' ";

    if($_SESSION['search_data']['title'] != '' ) {

       // $condition .="AND p.post_title LIKE '".$_SESSION['search_data']['title']."'% ";
        $condition .= ' AND p.post_title LIKE \'%' . esc_sql( like_escape( $_SESSION['search_data']['title'] ) ) . '%\' ';

    } else {

	  if($_SESSION['search_data']['country'] != '' && $_SESSION['search_data']['category'] == ''){

	      $condition .="AND {$wpdb->prefix}terms.name =  '".$_SESSION['search_data']['country']."'
	          AND {$wpdb->prefix}term_taxonomy.taxonomy =  'article_country_cat' ";

	  }elseif($_SESSION['search_data']['country'] == '' && $_SESSION['search_data']['category'] != ''){

	      $condition .="AND {$wpdb->prefix}terms.name =  '".$_SESSION['search_data']['category']."'
          AND {$wpdb->prefix}term_taxonomy.taxonomy =  'article_cat' ";

	  }elseif($_SESSION['search_data']['country'] != '' && $_SESSION['search_data']['category'] != ''){


       $condition .="AND {$wpdb->prefix}terms.name =  '".$_SESSION['search_data']['country']."'
          AND {$wpdb->prefix}term_taxonomy.taxonomy =  'article_country_cat' ";

	       $condition .="AND {$wpdb->prefix}terms.name =  '".$_SESSION['search_data']['category']."'
          AND {$wpdb->prefix}term_taxonomy.taxonomy =  'article_cat' ";

	  }

    }

	    $orderby ="AND p.post_status = 'publish'
	    	  GROUP BY p.ID
	          ORDER BY p.post_date DESC
	          LIMIT {$_POST['paged']}, ".CUSTOM_POST_PER_PAGE."";
	    
	    $orderby2 ="AND p.post_status = 'publish'
	    	  GROUP BY p.ID
	          ORDER BY p.post_date DESC";

$sss = '';
$sss2 = '';

	  if($_SESSION['search_data']['country'] == '' && $_SESSION['search_data']['category'] == '' && $_SESSION['search_data']['title']  == '') {

			$results = $wpdb->get_results( $sql.$orderby );
			$temp_res = $wpdb->get_results( $sql2.$orderby2 );

			$sss = $sql.$orderby;
			$sss2 = $sql2.$orderby2;

	  } else {
	  		
			$results = $wpdb->get_results( $sql.$condition.$orderby );
			$temp_res = $wpdb->get_results( $sql2.$condition.$orderby2 );

			$sss = $sql.$condition.$orderby;
			$sss2 = $sql2.$condition.$orderby2;
	  }

	 $max_count = 0;
	foreach($temp_res as $count) {
		$max_count++;
	}  


 	$ctr = 0;
   	$html = "";    

   	foreach($results as $res) {

			$category = wp_get_post_terms($res->ID, 'article_cat', array("fields" => "names"));
			$countries  = wp_get_post_terms($res->ID, 'article_country_cat', array("fields" => "names"));

		    $html .='<li>';

			  $html .='<a href="'.get_permalink($res->ID).'" class="post-list-thumb-wrap">';
			  $html .='<div class="postimg" style="background: url('.getArticleImage($res->ID).')"></div>';
			  $html .='</a>';

			  $html .='<div class="labels">';
				  if($countries) {
				  	foreach($countries as $country) {
				  		$html .='<a href="/search-results/?country='.$country.'&category=select+category&post_type=post+type+curators-cat" class="countrylabel">';
				  		$html .='<i class="fa fa-map-marker"></i>';
				  		$html .= $country;
				  		$html .='</a>';
				  	}
				  }

				  if($category) {
				  	foreach($category as $cat) {
				  		$html .='<a href="/search-results/?country=select&category='.$cat.'+category&post_type=post+type+curators-cat" class="countrylabel">';
				  		$html .='<i class="fa fa-map-marker"></i>';
				  		$html .= $cat;
				  		$html .='</a>';
				  	}
				  }
			  $html .='</div>';

			$html .='</li>';
		$ctr++;
	}

   echo json_encode(array('test'=>$_SESSION, 'test2'=>$sss,'test3'=>$sss2, 'paged'=> $_POST['paged'],  'post_status'=> 'publish', 'result' => $html, 'count' => $ctr + $_POST['paged'], 'max' => (int)$max_count ));

    die();

}

add_action('wp_ajax_custom_search_ajax_request', 'custom_search_ajax_request');
add_action('wp_ajax_nopriv_custom_search_ajax_request', 'custom_search_ajax_request');



add_action('trashed_post','my_trashed_post_handler');
function my_trashed_post_handler($post_id) {

    if ( filter_input( INPUT_GET, 'frontend', FILTER_VALIDATE_BOOLEAN ) ) {
        wp_redirect( get_option('siteurl').'/curator-detail?id='.get_current_user_id()  );
        exit;
    }
}


function get_post_views($post_id) {

	$meta_key 	= 'post_views_count';
	$count 		= get_post_meta( $post_id, $meta_key, true );

	if($count == '') {
		
		delete_post_meta( $post_id, $meta_key );
		add_post_meta( $post_id, $meta_key, 1 );
		return "1 <span>View</span>";
	}

	return $count.' <span>Views</span>';

}

function set_post_views($post_id) {

	$meta_key 	= 'post_views_count';
	$count 		= get_post_meta( $post_id, $meta_key, true );

	if($count == '') {
		
		$count = 0;
		delete_post_meta( $post_id, $meta_key );
		add_post_meta( $post_id, $meta_key, 1 );
		
	}else{
		
		$count++;
		update_post_meta( $post_id, $meta_key, $count );

	}

}

// Remove issues with prefetching adding extra views
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);


add_action('init', 'custom_send_like_request');
function custom_send_like_request() {
	
  if(isset($_POST['send_like'])) {
	  if($_POST['send_like'] != '') {


	  	$umeta_key 	= '_user_liked';
	  	$meta_key 	= '_total_like';
		$count 		= get_post_meta( $_POST['postid'], $meta_key, true );

		if($count == '') {
			
			$count = 0;
			delete_post_meta( $_POST['postid'], $meta_key );
			add_post_meta( $_POST['postid'], $meta_key, 1 );
			add_post_meta( $_POST['postid'], $umeta_key, $_POST['user'] );
			
		}else{
			
			$count++;
			update_post_meta( $_POST['postid'], $meta_key, $count );
			add_post_meta( $_POST['postid'], $umeta_key, $_POST['user'] );

		}

	  }	
  }		
 
}

function count_like_request($post_id) {

	$meta_key 	= '_total_like';
	$count 		= get_post_meta( $post_id, $meta_key, true );

	if($count == '') {
		
		delete_post_meta( $post_id, $meta_key );
		add_post_meta( $post_id, $meta_key, 0 );
		return 0;
	}

	return $count;

}


function title_filter( $where, &$wp_query ){
    global $wpdb;
    if ( $search_term = $_SESSION['search_data']['title'] ) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( like_escape( $search_term ) ) . '%\'';
    }
    return $where;
}

function my_login_logo() { ?>
    <style type="text/css">
        .login h1 a {
            background-image: url(<?php echo get_template_directory_uri(); ?>/images/kurastarlogo.png);
            padding-bottom: 30px;
            width: 200px
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

function my_login_logo_url_title() {
    return 'Kurastar';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );

function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_stylesheet() {
    wp_enqueue_style( 'custom-login', get_template_directory_uri() . '/css/admin-custom-login.css' );
    // wp_enqueue_script( 'custom-login', get_template_directory_uri() . '/css/style-login.js' );
}
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );