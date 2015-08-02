<?php 
namespace Scormi\Admin;

abstract class SettingsBase {
	abstract protected function PrintOverview();
	abstract protected function PrintForm($scormi_options);

	protected $scormi_options;

	protected function getOption($name){
		return isset($this->scormi_options[$name]) ? $this->scormi_options[$name] : null;
	}

	protected function saveSettings($options) {
		if ( isset($_POST['Reauthorize']) ){
			$options['google_token'] = '';
		} elseif ( isset($_POST['scormi_options']['google_token']) ){
			$token = wp_filter_nohtml_kses($_POST['scormi_options']['google_token']);

			if ( strlen($token) ){
				try {
					$options['google_token']		= \Scormi\GoogleApiAccess::inst()->handleCode($token);
					$options['google_profile_id']	= \Scormi\GoogleApiAccess::inst()->getProfileId(get_option('siteurl'));
				}
				catch (\Google_Auth_Exception $e){
					echo '<div class="error">'.$e->getMessage().'</div>';
					$options['google_token'] = '';
				}
			}
		}

		foreach (array('send_daily_report', 'agree_to_scormi_net', 'report_period') as $fieldname){
			if ( isset($_POST['scormi_options'][$fieldname]) )
				$options[$fieldname] = wp_filter_nohtml_kses($_POST['scormi_options'][$fieldname]);
		}

		if ( ! isset($options['agree_to_scormi_net']) || $options['agree_to_scormi_net'] != 'agree' )
			wp_die('Please check agreement to Scormi.net');

		update_option('scormi_options', $options);
		return $options;
	}

	public function settings() {
		if (! current_user_can('manage_options')) return;
		$scormi_options = get_option('scormi_options');

		if ( isset($_POST['scormi_security']) ) {
			if ( ! wp_verify_nonce($_POST['scormi_security'], 'scormi_form')){
				wp_die('Error in form');
			}
			$scormi_options=$this->saveSettings($scormi_options);
			echo '<div class="updated"><p>Settings saved.</p></div>';
		}
		?>
		
		<h2>Scormi<small> v<?php echo \Scormi\Scormi::VERSION ?></small></h2>
		<div style="margin-right: 20px">
			<?php $this->PrintOverview(); ?>
			<?php $this->PrintForm($scormi_options); ?>
		</div>
		<?php
	}
}
