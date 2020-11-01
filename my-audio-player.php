<?php
/**
 * Plugin Name: My Audio Player
 * Plugin URI:  
 * Description: My first audio player plugin practice
 * Version:     1.0
 * Author:      Maraj
 * Author URI:  
 * Text Domain: my-audio-player
 * Domain Path: /languages
 * License:     
 * License URI: 
 *
 * @package     PluginName
 * @author      Author Name
 * @copyright   Year Company
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 *
 * Prefix:      map
 */
require_once(plugin_dir_path(__FILE__)."./lib/codestar-framework/codestar-framework.php");
require_once(plugin_dir_path(__FILE__)."./inc/metabox.php");
defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

/**
 * Load localization files
 *
 * @return void
 */

//////////////////////////////////////////////
//Load Text Domain
/////////////////////////////////////////////
function map_plugin_init() {
    load_plugin_textdomain( 'Plugin Slug', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'map_plugin_init' );
//////////////////////////////////////////////
//Load Js & Css Files
/////////////////////////////////////////////


	function map_load_assets(){
	wp_enqueue_style('map-player-style', plugin_dir_url(__FILE__) . 'assets/css/jQuery.mb.miniAudioPlayer.min.css', null, time(),);
	wp_enqueue_style('map-custom-style', plugin_dir_url(__FILE__) . 'assets/css/style.css', null, time(),);
	wp_enqueue_script('map-player-script', plugin_dir_url(__FILE__) . 'assets/js/jquery.mb.miniAudioPlayer.js', array('jquery'), time(), true);
	wp_enqueue_script('map-custom-script', plugin_dir_url(__FILE__) . 'assets/js/custom.js', array('jquery'), time(), true);
	wp_enqueue_script('map-font-script', plugin_dir_url(__FILE__) . 'assets/js/fontawesome.min.js', array('jquery'), time(), true);

}


add_action('admin_enqueue_scripts','map_load_assets');
add_action('wp_enqueue_scripts','map_load_assets');

//////////////////////////////////////////////
//Custom Post Type
/////////////////////////////////////////////

function map_register_my_map_myaudioplayer() {
	$labels = [
		"name" => __( "My Audio Players", "my-audio-player" ),
		"singular_name" => __( "My Audio Player", "my-audio-player" ),
		"menu_name" => __( "My Audio Player", "my-audio-player" ),
		"all_items" => __( "My Audio Player", "my-audio-player" ),
		"add_new" => __( "Add Audio Player", "my-audio-player" ),
		'add_new_item' => __( 'Add New Player', "my-audio-player" ),
		'edit_item' => __('Edit Player',"my-audio-player"),
	];

	$args = [
		"label" => __( "My Audio Players", "twentynineteen" ),
		"labels" => $labels,
		"description" => "",
		"public" => false,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "page",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "myaudioplayer", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title" ],
		"menu_icon" => "dashicons-controls-forward",
	];
	register_post_type( "myaudioplayer", $args );
}

add_action( 'init', 'map_register_my_map_myaudioplayer' );


//////////////////////////////////////
//sub menu
//////////////////////////////////////

function map_custom_submenu_page() {
    add_submenu_page( 'edit.php?post_type=myaudioplayer', 'Developer', 'Developer', 'manage_options', 'map-developer', 'map_submenu_page_callback' );
};

function map_submenu_page_callback() {
	echo '<div class="wrap"><div id="icon-tools" class="icon32"></div>';
    echo '<h2>Developer</h2>
    <h2>Md Maraj Rashid</h2>
    <h3>Basic Web Developer</h3>';
	echo '</div>';
	
	
}
add_action('admin_menu', 'map_custom_submenu_page');
////////////////////////////////////////////////////////
//Lets genarate our shortcode
////////////////////////////////////////////////////////
function map_genarate_audio_shortcode($attr)
{
	ob_start();
	if (!empty($attr['id'])) {
		$id = $attr['id'];
	}
	$audio = get_post_meta( $id, 'add_audio_' , true );
	$audio_url = $audio['audio-file'];
	$audio_text = $audio['audio-text'];
	$audio_repeat = $audio['audio-repeat'];
	$audio_inline = $audio['audio-inline'];
	$audio_dwn = $audio['audio-download'];
	$audio_color = $audio['audio-color'];
	$audio_shadow = $audio['audio-shadow'];
	$audio_width = $audio['audio-width'];
	$audio_btn = $audio['audio-btn'];
	$audio_time_show = $audio['audio-time-show'];
	$audio_rew_show = $audio['audio-rew-show'];
	?>
	<a id="m1" class="  audio { loop:<?php  echo ((1 == $audio_repeat) ? 'true' : 'false') ?>  , inLine:<?php  echo ((0 == $audio_inline) ? 'true' : 'false') ?>, downloadable:<?php  echo ((1 == $audio_dwn) ? 'true' : 'false') ?>, skin:'<?php  echo $audio_color;?>', addShadow:<?php  echo ((1 == $audio_shadow) ? 'true' : 'false') ?>,width:<?php  echo $audio_width;?>,showTime:<?php  echo ((1 == $audio_time_show) ? 'true' : 'false') ?>,showRew:<?php  echo ((1 == $audio_rew_show) ? 'true' : 'false') ?>   }" href="<?php echo esc_attr( $audio_url) ?>"><?php echo ( $audio_text) ?></a>
			<?php
				if (1 == $audio_btn) { ?>
					<button id="play" >play</button>
                    <button id="stop" >stop</button>
			<?php }
			
			?>
            
	<?php
	
	return ob_get_clean();
}
add_shortcode('audio','map_genarate_audio_shortcode');

/////////////////////////////////////////////
// Add shortcode area 	
////////////////////////////////////////////
function map_shortcode_area()
{
	global $post;
	if ($post->post_type == 'myaudioplayer') {
		?>
		<div>
			<label style="cursor: pointer;font-size: 13px; font-style: italic;" for="h5ap_shortcode">Copy this shortcode and paste it into your post, page, or text widget content:</label>
			<span style="display: block; margin: 5px 0; background:#1e8cbe; ">
				<input type="text" id="" style="font-size: 12px; border: none; box-shadow: none;padding: 4px 8px; width:100%; background:transparent; color:white;" onfocus="this.select();" readonly="readonly" value="[audio id=<?php echo $post->ID; ?>]" />
				
			</span>
		</div>
		<?php
	}
}
add_action('edit_form_after_title', 'map_shortcode_area');


///////////////////////////////////////////////////////////////////////////
// CREATE TWO FUNCTIONS TO HANDLE THE All POST COLUMN
///////////////////////////////////////////////////////////////////////////
function map_columns_head_only_myaudioplayer($defaults)
{
	$defaults['directors_name'] = 'ShortCode';
	return $defaults;
}
function map_columns_content_only_myaudioplayer($column_name, $post_ID)
{
	if ($column_name == 'directors_name') {
		// show content of 'directors_name' column
		echo '<input onClick="this.select();" value="[audio id=' . $post_ID . ']" >';
	}
}
add_filter('manage_myaudioplayer_posts_columns', 'map_columns_head_only_myaudioplayer', 10);
add_action('manage_myaudioplayer_posts_custom_column', 'map_columns_content_only_myaudioplayer', 10, 2);
///////////////////////////////////////////////////////////////////////////
// Hide & Disabled View, Quick Edit and Preview Button
///////////////////////////////////////////////////////////////////////////
function map_remove_row_actions($idtions)
{
	global $post;
	if ($post->post_type == 'myaudioplayer') {
		unset($idtions['view']);
		unset($idtions['inline hide-if-no-js']);
	}
	return $idtions;
}
if (is_admin()) {
	add_filter('post_row_actions', 'map_remove_row_actions', 10, 2);
}
///////////////////////////////////////////////////////////////////////////
// HIDE everything in PUBLISH metabox except Move to Trash & PUBLISH button
///////////////////////////////////////////////////////////////////////////
function map_hide_publishing_actions()
{
	$my_post_type = 'myaudioplayer';
	global $post;
	if ($post->post_type == $my_post_type) {
		echo '
                <style type="text/css">
                    #misc-publishing-actions,
                    #minor-publishing-actions{
                        display:none;
                    }
                </style>
            ';
	}
}
add_action('admin_head-post.php', 'map_hide_publishing_actions');
add_action('admin_head-post-new.php', 'map_hide_publishing_actions');
//////////////////////////////////////////////////////////////////////////
// change publish button to save.
///////////////////////////////////////////////////////////////////////////
function map_change_publish_button($translation, $text)
{
	if ('myaudioplayer' == get_post_type())
	if ($text == 'Publish')
	return 'Save';
	
	return $translation;
}
add_filter('gettext', 'map_change_publish_button', 10, 2);
//////////////////////////////////////////////////////////////////////////
// Remove post update massage and link 
///////////////////////////////////////////////////////////////////////////
function map_updated_messages($messages)
{
	$messages['myaudioplayer'][1] = __('Player Updated ');
	return $messages;
}
add_filter('post_updated_messages', 'map_updated_messages');

add_filter('admin_footer_text', 'map_admin_footer');
function map_admin_footer($text)
{
	if ('myaudioplayer' == get_post_type()) {
		$url = 'https://wordpress.org/support/plugin/html5-audio-player/reviews/?filter=5#new-post';
		$text = sprintf(__('If you like <strong>Html5 Audio Player</strong> please leave us a <a href="%s" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a> rating. Your Review is very important to us as it helps us to grow more. <a href="%s"> <i class="fas fa-share fa-3x"></i></a> ', 'my-audio-player'), $url,$url);

	}
	return $text;
	
	
}