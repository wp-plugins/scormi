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
			$this->printReportPeriod();
			$this->printDailyReport();
			$this->printSendToScormi();
			echo '<h3>Shortcode Setup</h3>';
			echo '<p>Use the shortcode to display the report on a publicly accessible page. Simply add [scormi] to a newly created page, write a name in the title space so it becomes your report URL (example.com/stats/), password protect the page to keep it invisible to search engines and unauthorized passersby, select full width layout, then save it. Be careful. If you set the WP page visibility to Private or Public it can be found by search engines and others. </p>';
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
		<h3>Setup</h3>
	<?php }

	protected function printGoogle(){
		echo '<p>Get a Google Analytics access token for Scormi by clicking Get Token below. Upon clicking, your Google login page will open in a new browser tab independent of Scormi. After logging in, Google will give you the access token on a new page. Click on the token, copy it, then return to this page and paste it below.</p>';
		echo '<table border="0">';
		if ( ! \Scormi\GoogleApiAccess::inst()->isAccessTokenActive() ){
			printf('<tr><td><a href="%s" target="_blank"><span style="font-size:14pt;font-weight:600;">Get Token</span></a></td></tr>', \Scormi\GoogleApiAccess::inst()->getAccessTokenUrl());

			echo '<tr>';
			echo '<td><label class="description" for="scormi_options[google_token]">Enter your token here: </label></td>';
			echo '<td><input size="100" maxlength="125" name="scormi_options[google_token]"></td>';
			echo '</tr>';
		} else {
			echo ( $this->scormi_options['google_profile_id'] )
				? '<div class="notice">Success. This website was found in your Google Analytics properties.</div>'
				: '<div class="error">The URL for this WordPress domain was not found in your Google Analytics properties</div>';
		}
		

		echo '<tr><td></td><td>';
		if ( \Scormi\GoogleApiAccess::inst()->isAccessTokenActive() ){
			echo '<input type="submit" class="button" name="Reauthorize" value="Reauthorize" /> ';
		}
		echo '</td></tr></table><hr>';
	}

	protected function printReportPeriod(){ ?>
		<h3>Report period.</h3>
		<p>Please choose the report date range.</p>
		

		<select id="report_period" name="scormi_options[report_period]">
		<?php 
			foreach (array(7, 30, 60, 90) as $period) 
				printf('<option value="%s" %s>%s</option>', $period, $this->getOption('report_period') == $period ? 'selected="selected"' : '', $period);
		?>
		</select>
		<label for="report_peroid">Report period</label>
		<hr>
	<?php }


	protected function printDailyReport(){ ?>
		<h3>Optional Daily Email Report.</h3>
		<p>Scormi can send your daily report to the email address in Settings &gt; General. Check your spam folder if the report does not arrive in your inbox. Select below to activate or deactivate this feature. </p>

		<input type="radio" id="send_daily_report" name="scormi_options[send_daily_report]" value="on" <?php echo $this->getOption('send_daily_report') == 'on' ? 'checked' : ''?>>
		<label for="send_daily_report">Send me a daily report</label>

		<input type="radio" id="dontsend_daily_report" name="scormi_options[send_daily_report]" value="off" <?php echo $this->getOption('send_daily_report') != 'on' ? 'checked' : ''?>>
		<label for="dontsend_daily_report">Do not send me a daily report</label>
		<hr>
	<?php }

	protected function printSendToScormi(){ ?>
		<h3>Permission</h3>
		<p>The plugin sends your Google Analytics token to the Scormi server each night for API access. </p>


		<input type="checkbox" id="agreeToScormiNet" name="scormi_options[agree_to_scormi_net]" value="agree" <?php echo $this->getOption('agree_to_scormi_net') == 'agree' ? 'checked' : ''?>>
		<label for="agreeToScormiNet"><strong>I agree to send the Google Analytics access token to the Scormi server to retrieve my Google Analytics data.</strong></label>
		<hr>
	<?php }
}
