<?php 
namespace Scormi\Admin;

class SettingsHtml extends SettingsBase{

	protected function PrintForm($scormi_options){
		$this->scormi_options = $scormi_options;
		wp_enqueue_script('jquery');
		wp_enqueue_script( 'Scormi', plugins_url('/Scormi.js', __FILE__), array(), '1.0.0', true );
		echo '<form id="scormi_settings" method="post" '.esc_url($_SERVER['REQUEST_URI']).'>';
			wp_nonce_field('scormi_form','scormi_security'); 
			settings_fields('scormi_plugin_options');

			$this->printGoogle();
			$this->printDailyReport();
			$this->printSendToScormi();
			echo '<h3>Timezone</h3>';
			echo '<p>Finally, be sure the timezone in Settings>General has been set to your local time. This ensures that your report data reflects the 24 hours of your time zone (as opposed to the default GMT/UTC).</p>';
			$this->printSaveButton();
		echo '</form>';
	}

	protected function printSaveButton(){ 
		$attrs = array();
		if ( ! $this->getOption('agree_to_scormi_net') )
			$attrs['disabled'] = 'disabled';

		submit_button('Save Settings', 'primary', 'save-settings', false, $attrs);
	}

	protected function PrintOverview(){ ?>	
		<h3>Overview</h3>
		<p>Scormi creates a daily Google Analytics and Moz summary report via nightly API connection to those services. You must be using Google Analytics for Scormi to work. There is no special requirement for Moz as it’s publicly accessible information.</p>
		<hr>
		<h3>Setup</h3>
	<?php }

	protected function printGoogle(){
		echo '<p>Get a Google Analytics access token for Scormi, copy it, then return to this page and paste it below.</p>';
		echo '<table border="0">';
		if ( ! \Scormi\GoogleApiAccess::inst()->isAccessTokenActive() ){
			printf('<tr><td><a href="%s" target="_blank">Get token</a></td></tr>', \Scormi\GoogleApiAccess::inst()->getAccessTokenUrl());

			echo '<tr>';
			echo '<td><label class="description" for="scormi_options[google_token]">Google Access Code: </label></td>';
			echo '<td><input size="100" maxlength="255" name="scormi_options[google_token]"></td>';
			echo '</tr>';
		} else {
			echo ( $this->scormi_options['google_profile_id'] )
				? '<div class="notice">Site url found in Google Analytics properties</div>'
				: '<div class="error">No site url in Google Analytics properties</div>';
		}
		

		echo '<tr><td></td><td>';
		if ( \Scormi\GoogleApiAccess::inst()->isAccessTokenActive() ){
			echo '<input type="submit" class="button" name="Reauthorize" value="Reauthorize" /> ';
		}
		echo '</td></tr></table><hr>';
	}

	protected function printDailyReport(){ ?>
		<h3>Optional Daily Email Report.</h3>
		<p>Scormi can send your daily report to the email address in Settings &gt; General. This is a convenient alternative to logging into the WordPress admin to see the report. Select below to activate or deactivate this feature. </p>

		<input type="radio" id="send_daily_report" name="scormi_options[send_daily_report]" value="on" <?php echo $this->getOption('send_daily_report') == 'on' ? 'checked' : ''?>>
		<label for="send_daily_report">Send me a daily report</label>

		<input type="radio" id="dontsend_daily_report" name="scormi_options[send_daily_report]" value="off" <?php echo $this->getOption('send_daily_report') != 'on' ? 'checked' : ''?>>
		<label for="dontsend_daily_report">Don’t send me a daily report</label>
		<hr>
	<?php }

	protected function printSendToScormi(){ ?>
		<h3>Permission</h3>
		<p>The plugin sends your Google Analytics token to the Scormi server each night for API access. Scormi does not retain or analyze any of your Google Analytics data.</p>


		<input type="checkbox" id="agreeToScormiNet" name="scormi_options[agree_to_scormi_net]" value="agree" <?php echo $this->getOption('agree_to_scormi_net') == 'agree' ? 'checked' : ''?>>
		<label for="agreeToScormiNet"><strong>I agree to send the Google Analytics access token to the Scormi server to retrieve my Google Analytics data.</strong></label>
		<hr>
	<?php }
}
