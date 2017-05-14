<?php
/*
    Our portfolio:  http://themeforest.net/user/tagDiv/portfolio
    Thanks for using our theme!
    tagDiv - 2017
*/


/**
 * Load the speed booster framework + theme specific files
 */

// load the deploy mode
require_once('td_deploy_mode.php');

// load the config
require_once('includes/td_config.php');
add_action('td_global_after', array('td_config', 'on_td_global_after_config'), 9); //we run on 9 priority to allow plugins to updage_key our apis while using the default priority of 10


// load the wp booster
require_once('includes/wp_booster/td_wp_booster_functions.php');


require_once('includes/td_css_generator.php');
require_once('includes/shortcodes/td_misc_shortcodes.php');
require_once('includes/widgets/td_page_builder_widgets.php'); // widgets


/*
 * mobile theme css generator
 * in wp-admin the main theme is loaded and the mobile theme functions are not included
 * required in td_panel_data_source
 * @todo - look for a more elegant solution(ex. generate the css on request)
 */
require_once('mobile/includes/td_css_generator_mob.php');


/* ----------------------------------------------------------------------------
 * Woo Commerce
 */

// breadcrumb
add_filter('woocommerce_breadcrumb_defaults', 'td_woocommerce_breadcrumbs');
function td_woocommerce_breadcrumbs() {
	return array(
		'delimiter' => ' <i class="td-icon-right td-bread-sep"></i> ',
		'wrap_before' => '<div class="entry-crumbs" itemprop="breadcrumb">',
		'wrap_after' => '</div>',
		'before' => '',
		'after' => '',
		'home' => _x('Home', 'breadcrumb', 'woocommerce'),
	);
}

// use own pagination
if (!function_exists('woocommerce_pagination')) {
	// pagination
	function woocommerce_pagination() {
		echo td_page_generator::get_pagination();
	}
}

// Override theme default specification for product 3 per row


// Number of product per page 8
add_filter('loop_shop_per_page', create_function('$cols', 'return 4;'));

if (!function_exists('woocommerce_output_related_products')) {
	// Number of related products
	function woocommerce_output_related_products() {
		woocommerce_related_products(array(
			'posts_per_page' => 4,
			'columns' => 4,
			'orderby' => 'rand',
		)); // Display 4 products in rows of 1
	}
}




/* ----------------------------------------------------------------------------
 * bbPress
 */
// change avatar size to 40px
function td_bbp_change_avatar_size($author_avatar, $topic_id, $size) {
	$author_avatar = '';
	if ($size == 14) {
		$size = 40;
	}
	$topic_id = bbp_get_topic_id( $topic_id );
	if ( !empty( $topic_id ) ) {
		if ( !bbp_is_topic_anonymous( $topic_id ) ) {
			$author_avatar = get_avatar( bbp_get_topic_author_id( $topic_id ), $size );
		} else {
			$author_avatar = get_avatar( get_post_meta( $topic_id, '_bbp_anonymous_email', true ), $size );
		}
	}
	return $author_avatar;
}
add_filter('bbp_get_topic_author_avatar', 'td_bbp_change_avatar_size', 20, 3);
add_filter('bbp_get_reply_author_avatar', 'td_bbp_change_avatar_size', 20, 3);
add_filter('bbp_get_current_user_avatar', 'td_bbp_change_avatar_size', 20, 3);



//add_action('shutdown', 'test_td');

function test_td () {
    if (!is_admin()){
        td_api_base::_debug_get_used_on_page_components();
    }

}


/**
 * tdStyleCustomizer.js is required
 */
if (TD_DEBUG_LIVE_THEME_STYLE) {
    add_action('wp_footer', 'td_theme_style_footer');
		// new live theme demos
	    function td_theme_style_footer() {
			    ?>
			    <div id="td-theme-settings" class="td-live-theme-demos td-theme-settings-small">
				    <div class="td-skin-body">
					    <div class="td-skin-wrap">
						    <div class="td-skin-container td-skin-buy"><a target="_blank" href="http://themeforest.net/item/newspaper/5489609?ref=tagdiv">BUY NEWSPAPER NOW!</a></div>
						    <div class="td-skin-container td-skin-header">GET AN AWESOME START!</div>
						    <div class="td-skin-container td-skin-desc">With easy <span>ONE CLICK INSTALL</span> and fully customizable options, our demos are the best start you'll ever get!!</div>
						    <div class="td-skin-container td-skin-content">
							    <div class="td-demos-list">
								    <?php
								    $td_demo_names = array();

								    foreach (td_global::$demo_list as $demo_id => $stack_params) {
									    $td_demo_names[$stack_params['text']] = $demo_id;
									    ?>
									    <div class="td-set-theme-style"><a href="<?php echo td_global::$demo_list[$demo_id]['demo_url'] ?>" class="td-set-theme-style-link td-popup td-popup-<?php echo $td_demo_names[$stack_params['text']] ?>" data-img-url="<?php echo td_global::$get_template_directory_uri ?>/demos_popup/large/<?php echo $demo_id; ?>.jpg"></a></div>
								    <?php } ?>
									<div class="td-set-theme-style-empty"><a href="#" class="td-popup td-popup-empty1"></a></div>
<!--									<div class="td-set-theme-style-empty"><a href="#" class="td-popup td-popup-empty2"></a></div>-->
								    <div class="clearfix"></div>
							    </div>
						    </div>
						    <div class="td-skin-scroll"><i class="td-icon-read-down"></i></div>
					    </div>
				    </div>
				    <div class="clearfix"></div>
				    <div class="td-set-hide-show"><a href="#" id="td-theme-set-hide"></a></div>
				    <div class="td-screen-demo" data-width-preview="380"></div>
			    </div>
			    <?php
	    }

}

//print_r(td_global::$all_theme_panels_list);
//CUSTOM LOGIN PAGE
function my_custom_login() {
echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/login/custom-login-styles.css" />';
}
add_action('login_head', 'my_custom_login');

function my_login_logo_url() {
return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
return 'Treats';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );
function login_error_override()
{
    return 'Incorrect login details.';
}
add_filter('login_errors', 'login_error_override');
function my_login_head() {
remove_action('login_head', 'wp_shake_js', 12);
}
add_action('login_head', 'my_login_head');
function login_checked_remember_me() {
add_filter( 'login_footer', 'rememberme_checked' );
}
add_action( 'init', 'login_checked_remember_me' );

function rememberme_checked() {
echo "<script>document.getElementById('rememberme').checked = true;</script>";
}
//Custom color on ADMIN BAr On Mobile Devices
add_action('wp_head','color_address_bar');

function color_address_bar() {
	
	$color ="#CB9558";
	
	// Forgive user if no "#" before color
	$color = (strpos($color,'#') !== false ? $color : '#' . $color);
	
	// HTML to add to header
	$color_meta = '
	<!-- Chrome, Firefox OS and Opera -->
	<meta name="theme-color" content="' . $color . '">
	<!-- Windows Phone -->
	<meta name="msapplication-navbutton-color" content="' . $color . '">
	<!-- iOS Safari , works only in black. to set this off, comment the next line -->
	<meta name="apple-mobile-web-app-status-bar-style" content="black">';

	echo $color_meta;

}
//* Adding DNS Prefetching
function stb_dns_prefetch() {
echo '<meta http-equiv="x-dns-prefetch-control" content="on">
<link rel="dns-prefetch" href="//www.googletagmanager.com/" />
<link rel="dns-prefetch" href="//www.googletagservices.com/" />
<link rel="dns-prefetch" href="//fonts.googleapis.com" />
<link rel="dns-prefetch" href="//fonts.gstatic.com" />
<link rel="dns-prefetch" href="//0.gravatar.com/" />
<link rel="dns-prefetch" href="//2.gravatar.com/" />
<link rel="dns-prefetch" href="//1.gravatar.com/" />
<link rel="dns-prefetch" href="//www.youtube.com/" />';
}
add_action('wp_head', 'stb_dns_prefetch', 0);

/*CHRISTOPHER's CUSTOM MODS - 1.10.15 rev15A - (c) 2010-2015 Chris Simmons */

 remove_action( 'wp_head', 'wp_generator' ) ;
 remove_action( 'wp_head', 'wlwmanifest_link' ) ;
 remove_action( 'wp_head', 'rsd_link' ) ;
 remove_action( 'wp_head', 'feed_links', 2 );
 remove_action( 'wp_head', 'feed_links_extra', 3 );

 add_filter( 'pre_comment_content', 'wp_specialchars' );

 function no_errors_please(){
   return 'You appear to be up to no good. Please stop now!';
 }
 add_filter( 'login_errors', 'no_errors_please' );

 /* Disable YOAST SEO Admin Bar. */
 function mytheme_admin_bar_render() {
 	global $wp_admin_bar;
 	$wp_admin_bar->remove_menu('wpseo-menu');
 }
 // and we hook our function via
 add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );

 function delete_enclosure(){
  return '';
  }
  add_filter( 'get_enclosed', 'delete_enclosure' );
  add_filter( 'rss_enclosure', 'delete_enclosure' );
  add_filter( 'atom_enclosure', 'delete_enclosure' );

 function remove_cssjs_ver( $src ) {
     if( strpos( $src, '?ver=' ) )
         $src = remove_query_arg( 'ver', $src );
     return $src;
 }
 add_filter( 'style_loader_src', 'remove_cssjs_ver', 10, 2 );
 add_filter( 'script_loader_src', 'remove_cssjs_ver', 10, 2 );

 add_filter( 'jpeg_quality', create_function( '', 'return 50;' ) );

 function remove_pingback_url( $output, $show ) {
     if ( $show == 'pingback_url' ) $output = '';
     return $output;
 }
 add_filter( 'bloginfo_url', 'remove_pingback_url', 10, 2 );

 add_action('init', 'myoverride', 100);
 function myoverride() {
     remove_action('wp_head', array(visual_composer(), 'addMetaData'));
}

function dequeue_visual_composer_css() {
if (is_single()) {
    wp_dequeue_style('js_composer_front');
}
}
add_action('wp_enqueue_scripts', 'dequeue_visual_composer_css', 1003);