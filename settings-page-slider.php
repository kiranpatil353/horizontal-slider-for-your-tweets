<?php

if (is_admin()) {
  add_action('admin_menu', 'hsfyt_menu');
  add_action('admin_init', 'hsfyt_register_settings');
}

function hsfyt_menu() {
	add_options_page('Twit Slider Settings','Twit Slider Settings','manage_options','hsfyt_settings','hsfyt_settings_view');
}

function hsfyt_settings() {
	$hsfyt = array();
	$hsfyt[] = array('name'=>'hsfyt_application_key','label'=>'Application API Key');
	$hsfyt[] = array('name'=>'hsfyt_application_secret','label'=>'Application API Secret');
	$hsfyt[] = array('name'=>'hsfyt_access_token','label'=>'Access Token');
	$hsfyt[] = array('name'=>'hsfyt_access_token_secret','label'=>'Access Token Secret');
	$hsfyt[] = array('name'=>'hsfyt_user_screenname','label'=>'Twitter Screen Name');
	return $hsfyt;
}

function hsfyt_register_settings() {
	$settings = hsfyt_settings();
	foreach($settings as $setting) {
		register_setting('hsfyt_settings',$setting['name']);
	}
}
// Settings page display
function hsfyt_settings_view() {
	$settings = hsfyt_settings();
	
	echo '<div class="wrap">';
	
		echo '<h2>Twitter Application Settings</h2>';
		echo "<p>Please create application at <a href='http://dev.twitter.com/apps'> http://dev.twitter.com/apps .</a> </p><p>
		Copy the consumer secret and consumer key here. Then click the Create Access Token button at the bottom of the Twitter app page.  Copy the Access token and Access token secret here.</p> ";
		
		echo '<form method="post" action="options.php">';
		
    settings_fields('hsfyt_settings');
		
		echo '<table>';
			foreach($settings as $setting) {
				echo '<tr>';
					echo '<td>'.$setting['label'].'*</td>';
					echo '<td><input required type="text" style="width: 400px" name="'.$setting['name'].'" value="'.get_option($setting['name']).'" /></td>';
				echo '</tr>';
				if ($setting['name'] == 'hsfyt_user_screenname') {
				
					echo '<td colspan="2" style="font-size:12px; font-style: italic">This will be your twitter @ScreenName</td>';
				}
			}
		echo '</table>';
		
		submit_button();
		
		echo '</form>';
		
		echo '<hr />';
	echo '</div>';
	}
	
