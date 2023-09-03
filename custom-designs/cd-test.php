<?php
/**
* Plugin Name: Custom Designer - Test
* Description: This plugin adds a canvas that can be customized. It is used for creating designs for licence plates, signs, etc.
* Version: 1.0.0
* Author: Tara Rowland
* Author URI: https://tararowland.com
*/

if (!defined( 'ABSPATH' )) { exit; }




class Cd {
	
	var 
	   	/* Version number and root path details - could be accessed by "wcff()->info" */
	   	$info,
	   	/* Data Access Object reference - could be accessed by "wcff()->dao" */
	   	$dao,
	   	/* Fields interface - could be accessed by "wcff()->field" */
	   	$field,
		/* Fields injector instance - could be accessed by "wcff()->injector" */
		$injector,
		/* Fields Persister instance (which mine the REQUEST object and store the custom fields as Cart Item Data) - could be accessed by "wcff()->persister" */
	    $persister,
	    /* Fields Data Renderer instance - on Cart & Checkout - could be accessed by "wcff()->renderer" */
		$renderer,
		/* Fields Editor instance - on Cart & Checkout (though editing option won't works on Checkout) - could be accessed by "wcff()->editor" */
		$editor,
		/* Pricing & Fee handler instance - could be accessed by "wcff()->negotiator" */
		$negotiator,
		/* Order handler instance - could be accessed by "wcff()->order" */
		$order,
	   	/* Option object - could be accessed by "wcff()->option" */
	   	$option,
	   	/* Html builder object reference - could be accessed by "wcff()->builder" */
	   	$builder,
	   	/* Fields Validator instance - could be accessed by "wcff()->validator" */
	   	$validator,
	   	/* Fields Translator instance - could be accessed by "wcff()->locale" */
		$locale,
	   	/* Holds the Ajax request object comes from WC Fields Factory Admin Interfce - could be accessed by "wcff()->request" */
	   	$request,
	   	/* Holds the Ajax response object which will be sent back to Client - could be accessed by "wcff()->response" */
	   	$response;
	
	public function __construct() {		
	    /* Put some most wanted values on info property */
		$this->info = array(
			'path'				=> plugin_dir_path( __FILE__ ),
			'dir'				=> plugin_dir_url( __FILE__ ),
			'version'			=> '1.0.0'
		);		
		/* Load the Bootstrap Script */
		include_once('includes/wcff-loader.php');
		$loader = new Wcff_Loader($this);		
		/* Load the necessary fiels to prepare the Env */
		$loader->load_environment();
		/* Hook up with 'init' for setting up the Environment */
		add_action('init', array($loader, 'prepare_environment'), 1);		
	}	
	
}

function cd() {
	global $cd;
	
	/* Make sure woocommerce installed and activated */
	if (!function_exists('WC')) {
		add_action('admin_notices', 'cd_woocommerce_not_found_notice');
	}
	
	if (!isset($cd)) {
		$cd = new Cd();
	}
	return $cd;
} 

add_action('plugins_loaded', 'cd', 11);

/* Woocommerce missing notice */
if (!function_exists('cd_woocommerce_not_found_notice')) {
	function cd_woocommerce_not_found_notice() {
	?>
        <div class="woocommerceError">
            <p><?php _e('Custom Designer requires WooCommerce. Please make sure that it is installed and activated.', 'custom-designer'); ?></p>
        </div>
    <?php
    }
}

?>