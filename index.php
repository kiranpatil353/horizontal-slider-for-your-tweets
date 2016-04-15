<?php 
	/**
 * Plugin Name:		   Horizontal Slider for your twits
 * Plugin URI:		   http://clariontechnologies.co.in
 * Description:		   Slider for Tweeter feeds , one at a time horizontal.
 * Version: 		   1.0
 * Author: 		       kiranpatil353
 */
 
// include library and configurations for app 
include_once('twitteroauth/twitteroauth.php'); 
require('settings-page-slider.php');

// Add styles and scripts 
 wp_enqueue_style('hsfyt_style', plugins_url('css/hsfyt-style.css', __FILE__));
 wp_enqueue_script( 
        'hsfyt_js', 
        plugins_url('js/hsfyt_script.js', __FILE__), 
        array('jquery'), 
        '1.0', 
        true 
);
//Create shortcode 
function hsfyt_slider_shortcode() {

    return hsfyt_slider_view();
}

add_shortcode('tphs-slider', 'hsfyt_slider_shortcode');

//Frontend view from shortcode 
function hsfyt_slider_view(){
	// app tokens 
 $twitter_customer_key           = sanitize_text_field(get_option('hsfyt_application_key'));
 $twitter_customer_secret        = sanitize_text_field(get_option('hsfyt_application_secret'));
 $twitter_access_token           = sanitize_text_field(get_option('hsfyt_access_token'));
 $twitter_access_token_secret    = sanitize_text_field(get_option('hsfyt_access_token_secret'));
 $twiiter_user_screenname        = sanitize_text_field(get_option('hsfyt_user_screenname'));
// conntect to api
$connection = new TwitterOAuth($twitter_customer_key, $twitter_customer_secret, $twitter_access_token, $twitter_access_token_secret);

$my_tweets = $connection->get('statuses/user_timeline', array('screen_name' => $twiiter_user_screenname));

echo '<div class="twitter-bubble">';
if(isset($my_tweets->errors))
{           
    echo 'Error :'. $my_tweets->errors[0]->code. ' - '. $my_tweets->errors[0]->message;
	
}else{
	?>
		<div id="slides">
			  <ul>
		<?php 
		foreach($my_tweets as $tweet){ ?>
				<li class="slide">
				 <?php echo $tweet->text; ?>
				</li>
		<?php } ?>
			 </ul>
		</div>
		<div class="btn-bar">
		  <div id="buttons">
			<a id="prev" href="#">&lt;</a>
			<a id="next" href="#">&gt;</a> 
		  </div>
		</div>
	
<?php }
echo '</div>';
}
 /* Plugin Activation Hook
         * 
         */

        function hsfyt_hook_activate() {
            if (!current_user_can('activate_plugins'))
                return;
            $plugin = isset($_REQUEST['plugin']) ? $_REQUEST['plugin'] : '';
            check_admin_referer("activate-plugin_{$plugin}");
        }
		register_activation_hook(__FILE__, 'hsfyt_hook_activate');
        /* Plugin Deactivation Hook
         * 
         */

        function hsfyt_hook_deactivate() {

            if (!current_user_can('activate_plugins'))
                return;
            $plugin = isset($_REQUEST['plugin']) ? $_REQUEST['plugin'] : '';
            check_admin_referer("deactivate-plugin_{$plugin}");
        }
		
		register_deactivation_hook(__FILE__, 'hsfyt_hook_deactivate');
        
?>