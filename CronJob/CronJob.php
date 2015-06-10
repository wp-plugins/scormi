<?php
namespace Scormi\CronJob;

class CronJob {
	public function __construct(){
		add_action( 'scormi_daily_event_hook', array($this, 'cronjob' ));
	}

	public static function cronjob(){
		$scormi_options = get_option('scormi_options');
		if ( ! isset($scormi_options['send_daily_report']) || $scormi_options['send_daily_report'] != 'on' )
			return;

		if ( ! class_exists( 'PHPMAiler' ) )
			require_once ABSPATH . WPINC . '/class-phpmailer.php';

		$options = get_option('scormi_options');
		$token = $options['scormi_token'];

		$mail = new \PHPMailer;

		if ( ! \Scormi\GoogleApiAccess::inst()->isAccessTokenActive() ){
			$html = 'Google access token expired';
		} else {
			try {
				$report	= new \Scormi\Report();
				$data = $report->getAsArray();

				$html = $data['html'];

				if ( isset($data['images']) ){
					foreach( $data['images'] as $imgData ){
						if ( ! isset($imgData['name']) || ! isset($imgData['content']) || ! isset($imgData['content-type']) )
							throw new \Scormi\Exception('Cannot parse Scormi.net response, please report');

						$imgName = $imgData['name'];

						$html = str_replace('{'.$imgName.'}', 'cid:'.$imgName, $html);
						$mail->addStringEmbeddedImage(base64_decode($imgData['content']), $imgName, $imgName.str_replace('image/', '.', $imgData['content-type']), 'base64', $imgData['content-type']);
					}
				}
			} catch ( \Scormi\Exception $e){
				$html = $e->getMessage();
			}
		}

		$mail->setFrom(get_option('admin_email'), 'Scormi plugin');
		$mail->addAddress(get_option('admin_email'));
		$mail->Subject = 'Scormi report';

		$mail->msgHTML($html);

		$mail->IsMail();
		$mail->Send();
	}

	public function admin_menu() {
		add_menu_page('Scormi', 'Scormi', 'manage_options', 'scormi_settings', array('ScormiSettings', 'settings'));
	}
}
