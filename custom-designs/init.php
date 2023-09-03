<?php
/**
* Plugin Name: Custom Designer
* Description: This plugin adds a canvas that can be customized. It is used for creating designs for licence plates, signs, etc.
* Version: 1.0.0
* Author: Tara Rowland
* Author URI: https://tararowland.com
*/
if (!defined( 'ABSPATH' )) { exit; }

function remove_cart_btn(){
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
//	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
}
add_action('wp_head', 'remove_cart_btn');

function Load_Scripts($position, $options){
	?>  <script src="<?php echo plugin_dir_url( __FILE__ ) ?>fabric.js-master/dist/fabric.min.js"></script>
	    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script class="jsbin" src="<?php echo plugin_dir_url( __FILE__ ) ?>spectrum-master/spectrum.js"></script>
        <link rel="stylesheet" href="<?php echo plugin_dir_url( __FILE__ ) ?>spectrum-master/spectrum.css">
        <script src="<?php echo plugin_dir_url( __FILE__ ) ?>angular/angular.min.js"></script>
        <script src="<?php echo plugin_dir_url( __FILE__ ) ?>rcs-start.js"></script>
        <link rel="stylesheet" href="<?php echo plugin_dir_url( __FILE__ ) ?>design.css">
        <script src="<?php echo plugin_dir_url( __FILE__ ) ?>FileSaver/FileSaver.js"></script>
        <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
        <script src="<?php echo plugin_dir_url( __FILE__ ) ?>cropperjs/dist/cropper.js"></script>
        <link rel="stylesheet" href="<?php echo plugin_dir_url( __FILE__ ) ?>cropperjs/dist/cropper.css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>
        <script>
          WebFont.load({
            google: {
              families: ['Baloo Tamma', 'Days One', 'Great Vibes', 'Lobster', 'Milonga', 'Tangerine']
            }
          });
        </script>
	<?php
		echo "<script>
		var cd_canv_height = " . esc_attr( $options[cd_height][$position] ) . ";
		var cd_canv_width = " . esc_attr( $options[cd_width][$position] ) . ";
		var cd_template_overlay = '" . esc_attr( $options[cd_template_overlay][$position] ) . "';
		var cd_guidelines_overlay = '" . esc_attr( $options[cd_guidelines_overlay][$position] ) . "';
		</script>";
}
//add_action('woocommerce_before_single_product', 'load_scripts');

		
function Give_JS_Variables(){
	$position = -1;
	$options = get_option('custom_designer_options');
	
	for($i = 0; $i < 15 && $position == -1; $i++){
		if( !empty(esc_attr( $options[cd_product_tag][$i] ) ) ){
			if ( has_term( esc_attr( $options[cd_product_tag][$i] ), 'product_tag' ) ) {
				$position = $i;
				Load_Scripts($position, $options);
				create_cd_modal();

				$btn_text = 'Create Design';

				echo '<input type="button" id="cdBtn" value="'.$btn_text.'">';
				echo 	'<style>
						.single_add_to_cart_button {
							display: none !important;
						}
						</style>';

				add_action('woocommerce_after_single_product', 'bottom_scripts');
			}
		}
	}		
}
add_action('woocommerce_single_product_summary', 'Give_JS_Variables');

/*
function create_cd_btn(){
	if ( has_term( 'Custom', 'product_tag' ) || has_term( 'custom', 'product_tag' ) ) {

	}
}
add_action('woocommerce_single_product_summary', 'create_cd_btn');
*/

function create_cd_modal(){
    echo file_get_contents(plugins_url( 'rcs-designer.php', __FILE__ ), false);
}
//add_action('woocommerce_before_single_product', 'create_cd_modal');
  
function bottom_scripts(){
    /* Scripts at bottom */
    wp_enqueue_script('modal-handler-js',  plugin_dir_url( __FILE__ ) .'rcs-modal-handler.js');
    wp_enqueue_script('fabric-handler-js',  plugin_dir_url( __FILE__ ) .'rcs-fabric-handler.js');
    wp_enqueue_script('image-filters-js',  plugin_dir_url( __FILE__ ) .'imageFilters.js');
    wp_enqueue_script('offline-js',  plugin_dir_url( __FILE__ ) .'offline.js');
    wp_enqueue_script('rcs-cropper-js',  plugin_dir_url( __FILE__ ) .'rcs-cropper.js');
//    wp_enqueue_script('rcs-spectrum-js',  plugin_dir_url( __FILE__ ) .'spectrum-master/spectrum.js');
    wp_enqueue_script('rcs-spectrum-js',  plugin_dir_url( __FILE__ ) .'rcs-spectrum.js');
    wp_enqueue_script('rcs-end-js',  plugin_dir_url( __FILE__ ) .'rcs-end.js');
    wp_enqueue_script('fabric-listener-js',  plugin_dir_url( __FILE__ ) .'fabric-listener.js');
    wp_enqueue_script('submit-feedback-js',  plugin_dir_url( __FILE__ ) .'rcs-submit-feedback.js');
    wp_enqueue_script('clipart-handler.js',  plugin_dir_url( __FILE__ ) .'rcs-clipart-handler.js');
}

//add_action('woocommerce_after_single_product', 'bottom_scripts');
















function custom_designer_options_page() {
 // add top level menu page
 	add_menu_page(
		'Custom Designer',
		'Custom Designer Options',
 		'manage_options',
 		'custom_designer',
 		'custom_designer_options_page_html',
		'',
		57
 	);
}
 
add_action( 'admin_menu', 'custom_designer_options_page' );

 
add_action( 'admin_init', function() {
	// Loop to register the settings...? Or shove in an array. Something.
    $args = array(
		'cd_product_tag' => '',
        'cd_height' => '',
        'cd_width' => '',
        'cd_template_overlay' => '',
        'cd_guidelines_overlay' => ''
    );
	
    register_setting( 'custom_designer_plugin_settings', 'custom_designer_options', $args);
});

function Get_Options_Line($num){    
	$options = get_option('custom_designer_options');
	
	$option_line = '<tr>
		<td><input type="text" placeholder="" name="custom_designer_options[cd_product_tag]['.$num.']" value="' . esc_attr( $options[cd_product_tag][$num] ) .'" size="15">
		<td><input type="text" placeholder="" name="custom_designer_options[cd_height]['.$num.']" value="' . esc_attr( $options[cd_height][$num] ) . '" size="5"> in </td>
		<td><input type="text" placeholder="" name="custom_designer_options[cd_width]['.$num.']" value="' . esc_attr( $options[cd_width][$num] ) . '" size="5"> in </td>
		<td><input id="cd_template_overlay" type="text" placeholder="" name="custom_designer_options[cd_template_overlay]['.$num.']" value="' . esc_attr( $options[cd_template_overlay][$num] ) . '" size="2"> <input id="cd_template_overlay_btn" type="button" class="button cd_upload_button" value="Upload" /></td>
		<td><input id="cd_guidelines_overlay" type="text" placeholder="" name="custom_designer_options[cd_guidelines_overlay]['.$num.']" value="' . esc_attr( $options[cd_guidelines_overlay][$num] ) . '" size="2"> <input id="cd_guidelines_overlay_btn" type="button" class="button cd_upload_button" value="Upload" /></td>'
        /*<a href="#" class="remove_field">Remove</a>*/ 
		. '</tr>';
	
	return $option_line;
}
 function my_enqueue_media_lib_uploader() {

    //Core media script
    wp_enqueue_media();

    // Your custom js file
    wp_register_script( 'media-lib-uploader-js', plugins_url( 'media-lib-uploader.js' , __FILE__ ), array('jquery') );
    wp_enqueue_script( 'media-lib-uploader-js' );
}
add_action('admin_enqueue_scripts', 'my_enqueue_media_lib_uploader');

function custom_designer_options_page_html() {
    if ( isset( $_GET['settings-updated'] ) ) {
        add_settings_error( 'custom_designer_messages', 'custom_designer_message', __( 'Settings Saved', 'custom_designer' ), 'updated' );
    }
    settings_errors( 'custom_designer_messages' );
?>

<script>
jQuery(document).ready(function($){
  var mediaUploader;

  $('.cd_upload_button').click(function(e) {
    e.preventDefault();
	
    // Extend the wp.media object
    mediaUploader = wp.media.frames.file_frame = wp.media({
        title: 'Choose Image',
        button: { text: 'Choose Image' }, 
        multiple: false 
    });

    // When a file is selected, grab the URL and set it as the text field's value
    var cd_img_box = "#" + this.id.replace('_btn', '');  
    mediaUploader.on('select', function() {
		attachment = mediaUploader.state().get('selection').first().toJSON();
      	$(cd_img_box).val(attachment.url);
    });
    // Open the uploader dialog
    mediaUploader.open();
  });

});
</script>

<style>
table {
  border-collapse: collapse;
}
table td, table th {
  border: 1px solid black; 
}
table tr:first-child td, table tr:first-child th {
  border-top: 0;
}
table tr td:first-child, table tr th:first-child {
  border-left: 0;
}
table tr:last-child td, table tr:last-child th {
  border-bottom: 0;
}
table tr td:last-child, table tr th:last-child {
  border-right: 0;
}
td {
	padding: 3px 10px 3px 10px;
}
</style>


  <div class="wrap">
	  <h1>Custom Designer Options</h1>
	  <i>
		  <b>Product Tag:</b> This option is set under Woocommerce's Products. The Woocommerce Product tag is set on the right hand side of any single product in the Wordpress Dashboard. The box on this page must match exactly with the Woocommerce product tag.<br>
		  <b>Height & Width:</b> This is the height and width of the product including the allowances. Only numbers can be set.<br>
		  <b>Template Overlay:</b> This is the product template without guidelines. For example, on a licence plate it would include the edge and the bullet holes.<br>
		  <b>Guidelines Overlay:</b> This is what is shown by default. It should include the template overlay in the image, along with markers for the allowances.<br>
		  Note: The template overlay and the guidelines overlay are shown separately. If you want them to be shown together, you need to put them together in the file itself before uploading it.<br><br>
	  </i>
    <form action="options.php" method="post">
		<table>
			<tr>
				<th>Product Tag</th>
				<th>Height</th>
				<th>Width</th>
				<th>Template Overlay</th>
				<th>Guidelines Overlay</th>
			</tr>
		
			<?php
				settings_fields( 'custom_designer_plugin_settings' );
				do_settings_sections( 'custom_designer_plugin_settings' );
	
				for($i = 0; $i < 15; $i++){
					echo Get_Options_Line($i);
				}

			?>
 		</table>
        <?php submit_button(); ?>
    </form>
  </div>

<?php
}
?>