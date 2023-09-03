<?php
/* Disable all woocommerce styles
add_filter( 'woocommerce_enqueue_styles', '__return_false' );
*/

/*
add_filter( 'woocommerce_enqueue_styles', 'rcs_woocommerce_stylesheets' );

function rcs_woocommerce_stylesheets(){
    wp_register_style( 'rcs-woocommerce', get_template_directory_uri() . '/woocommerce.css' );
	
	if ( class_exists( 'woocommerce' ) ) {
		wp_enqueue_style( 'rcs-woocommerce' );
	}
}
*/
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

add_filter( 'woocommerce_cart_shipping_packages', 'woocommerce_cart_free_shipping_packages' );


function order_billing_fields($fields) {
    
    $fields['billing']['billing_first_name']['priority'] = 10;
    $fields['billing']['billing_first_name']['class'] = array('form-row-first');

    $fields['billing']['billing_last_name']['priority'] = 20;
    $fields['billing']['billing_last_name']['class'] = array('form-row-last');
    $fields['billing']['billing_last_name']['clear'] = true;

    $fields['billing']['billing_email']['priority'] = 30;
    $fields['billing']['billing_email']['class'] = array('form-row-first');

    $fields['billing']['billing_phone']['priority'] = 40;
    $fields['billing']['billing_phone']['class'] = array('form-row-last');
    $fields['billing']['billing_phone']['clear'] = true;

    $fields['billing']['billing_address_1']['priority'] = 50;
    $fields['billing']['billing_address_1']['class'] = array('form-row-first');
    $fields['billing']['billing_address_1']['clear'] = true;
    
    $fields['billing']['billing_address_2']['priority'] = 60;
    $fields['billing']['billing_address_2']['class'] = array('form-row-first');
    $fields['billing']['billing_address_2']['clear'] = true;
    
    $fields['billing']['billing_city']['priority'] = 70;
    $fields['billing']['billing_city']['class'] = array('form-row-last');
    
    $fields['billing']['billing_state']['priority'] = 70;
    $fields['billing']['billing_state']['class'] = array('form-row-last');

    $fields['billing']['billing_postcode']['priority'] = 90;
    $fields['billing']['billing_postcode']['class'] = array('form-row-last');

    $fields['billing']['billing_country']['priority'] = 100;
    $fields['billing']['billing_country']['class'] = array('form-row-first');
    $fields['billing']['billing_country']['clear'] = true;
    
    unset($fields['billing']['billing_company']);
    return $fields;
}
add_filter("woocommerce_checkout_fields", "order_billing_fields");

function order_shipping_fields($fields) {
    $fields['shipping']['shipping_first_name']['priority'] = 10;
    $fields['shipping']['shipping_first_name']['class'] = array('form-row-first');

    $fields['shipping']['shipping_last_name']['priority'] = 20;
    $fields['shipping']['shipping_last_name']['class'] = array('form-row-last');
    $fields['shipping']['shipping_last_name']['clear'] = true;

    $fields['shipping']['shipping_phone']['priority'] = 40;
    $fields['shipping']['shipping_phone']['class'] = array('form-row-last');
    $fields['shipping']['shipping_phone']['clear'] = true;

    $fields['shipping']['shipping_address_1']['priority'] = 50;
    $fields['shipping']['shipping_address_1']['class'] = array('form-row-first');
    $fields['shipping']['shipping_address_1']['clear'] = true;
    
    $fields['shipping']['shipping_address_2']['priority'] = 60;
    $fields['shipping']['shipping_address_2']['class'] = array('form-row-first');
    $fields['shipping']['shipping_address_2']['clear'] = true;
    
    $fields['shipping']['shipping_city']['priority'] = 70;
    $fields['shipping']['shipping_city']['class'] = array('form-row-last');
    
    $fields['shipping']['shipping_state']['priority'] = 70;
    $fields['shipping']['shipping_state']['class'] = array('form-row-last');

    $fields['shipping']['shipping_postcode']['priority'] = 90;
    $fields['shipping']['shipping_postcode']['class'] = array('form-row-last');

    $fields['shipping']['shipping_country']['priority'] = 100;
    $fields['shipping']['shipping_country']['class'] = array('form-row-first');
    $fields['shipping']['shipping_country']['clear'] = true;
    
    unset($fields['shipping']['shipping_company']);
    return $fields;
}
add_filter("woocommerce_checkout_fields", "order_shipping_fields");


function woocommerce_cart_free_shipping_packages( $packages ) {
	$found_regular = false;
    
    foreach ( WC()->cart->get_cart() as $item ) {
        if ( $item['data']->needs_shipping() ) {
            if ( $item['data']->get_shipping_class() != 'free-shipping' ) {
                $found_regular = true;
            }
        }
    }
	if($found_regular){
		foreach( $packages as $i => $package ){
			 foreach ( $package['contents'] as $key => $item ) {
				 if ( $item['data']->get_shipping_class() == 'free-shipping' ) {
					 unset( $packages[$i]['contents'][$key] );
				 }
			 }
		}
	}
	
    return $packages;
}


$defaults = array(
	'width'      	=> 1600,
	'height'      	=> 600,
	'flex-height' 	=> true,
	'flex-width'	=> true,
	'uploads'		=> true,
);
add_theme_support( 'custom-header', $defaults );

function rcs_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'rcs_add_woocommerce_support' );

add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );

function front_page_customizer( $wp_customize ) {
    $wp_customize->add_section( 'front_page_section' , array(
		'title'       => __( 'Front Page Settings', 'fp_settings' ),
		'priority'    => 30,
	) );


	$wp_customize->add_setting( 'background_image' );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'background_image', array(
		'label'    => __( 'Background Image', 'background_image' ),
		'section'  => 'front_page_section',
		'settings' => 'background_image',
	) ) );
	
	
	$wp_customize->add_setting( 'column_img1' );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'column_img1', array(
		'label'    => __( 'Column Image 1', 'column_img1' ),
		'section'  => 'front_page_section',
		'settings' => 'column_img1',
	) ) );
	$wp_customize->add_setting( 'column_name1' );
	$wp_customize->add_control('column_name1', array(
		'label'    => __( 'Column Name 1', 'column_name1' ),
		'section'  => 'front_page_section',
		'settings' => 'column_name1',
	) );	
	$wp_customize->add_setting( 'column_text1' );
	$wp_customize->add_control('column_text1', array(
		'label'    => __( 'Column Text 1', 'column_text1' ),
		'section'  => 'front_page_section',
		'settings' => 'column_text1',
	) );	
	$wp_customize->add_setting( 'column_link1' );
	$wp_customize->add_control('column_link1', array(
		'label'    => __( 'Column Link 1', 'column_link1' ),
		'section'  => 'front_page_section',
		'settings' => 'column_link1',
	) );

	

	$wp_customize->add_setting( 'column_img2' );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'column_img2', array(
		'label'    => __( 'Column Image 2', 'column_img2' ),
		'section'  => 'front_page_section',
		'settings' => 'column_img2',
	) ) );
	$wp_customize->add_setting( 'column_name2' );
	$wp_customize->add_control('column_name2', array(
		'label'    => __( 'Column Name 2', 'column_name2' ),
		'section'  => 'front_page_section',
		'settings' => 'column_name2',
	) );
	$wp_customize->add_setting( 'column_text2' );
	$wp_customize->add_control('column_text2', array(
		'label'    => __( 'Column Text 2', 'column_text2' ),
		'section'  => 'front_page_section',
		'settings' => 'column_text2',
	) );
	$wp_customize->add_setting( 'column_link2' );
	$wp_customize->add_control('column_link2', array(
		'label'    => __( 'Column Link 2', 'column_link2' ),
		'section'  => 'front_page_section',
		'settings' => 'column_link2',
	) );
	



	$wp_customize->add_setting( 'column_img3' );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'column_img3', array(
		'label'    => __( 'Column Image 3', 'column_img3' ),
		'section'  => 'front_page_section',
		'settings' => 'column_img3',
	) ) );
	$wp_customize->add_setting( 'column_name3' );
	$wp_customize->add_control('column_name3', array(
		'label'    => __( 'Column Name 3', 'column_name3' ),
		'section'  => 'front_page_section',
		'settings' => 'column_name3',
	) );
	$wp_customize->add_setting( 'column_text3' );
	$wp_customize->add_control('column_text3', array(
		'label'    => __( 'Column Text 3', 'column_text3' ),
		'section'  => 'front_page_section',
		'settings' => 'column_text3',
	) );
	$wp_customize->add_setting( 'column_link3' );
	$wp_customize->add_control('column_link3', array(
		'label'    => __( 'Column Link 3', 'column_link3' ),
		'section'  => 'front_page_section',
		'settings' => 'column_link3',
	) );

} add_action( 'customize_register', 'front_page_customizer' );

function register_shop_menu() {
  register_nav_menu('shop-menu',__( 'Shop Menu', 'rcs' ));
}
add_action( 'init', 'register_shop_menu' );

function rcs_setup() {
	load_theme_textdomain( 'rcs', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-texts' );
	add_theme_support( 'post-thumbnails' );
	global $content_width;
	if ( ! isset( $content_width ) ) $content_width = 640;
		register_nav_menus( array ( 'main-menu' => __( 'Main Menu', 'rcs' ) ) );
}
add_action( 'after_setup_theme', 'rcs_setup' );


function rcs_enqueue_comment_reply_script() {
	if ( get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }
}
add_action( 'comment_form_before', 'rcs_enqueue_comment_reply_script' );


function rcs_title( $title ) {
	if ( $title == '' )
		{ return '&rarr;'; } 
	else
		{ return $title; }
}
add_filter( 'the_title', 'rcs_title' );


function rcs_filter_wp_title( $title ) {
	return $title . esc_attr( get_bloginfo( 'name' ) );
}
add_filter( 'wp_title', 'rcs_filter_wp_title' );


function rcs_widgets_init() {
	register_sidebar( array (
		'name' => __( 'Sidebar Widget Area', 'rcs' ),
		'id' => 'primary-widget-area',
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</li>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
		) 
	);
}
add_action( 'widgets_init', 'rcs_widgets_init' );


function rcs_custom_pings( $comment ) {
	$GLOBALS['comment'] = $comment;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo comment_author_text(); ?></li>
	<?php 
}


function rcs_comments_number( $count )
{
	if ( !is_admin() ) {
		global $id;
		$comments_by_type = &separate_comments( get_comments( 'status=approve&post_id=' . $id ) );
		return count( $comments_by_type['comment'] );
	} 
	else 
		{ return $count; }
}
add_filter( 'get_comments_number', 'rcs_comments_number' );