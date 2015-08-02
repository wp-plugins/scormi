<?php 
namespace Scormi;

class Report {
	protected function prepareData(){
		$options = get_option('scormi_options');

		if ( ! strlen(trim($options['google_profile_id']) ) )
			throw new \Scormi\Exception('No google profile id, please check settings page');

		return array(
			'ReportPeriod'		=> $options['report_period'],
			'SendDailyReport'	=> $options['send_daily_report'],
			'APIs' => array( 
				'google'	=> array(
					'url'	=> get_option('siteurl'),
					'token'	=> $options['google_token'],
				),
			)
		);
	}

	public function getAsArray(){
		$requestData 	= $this->prepareData();
		$reportPeriod	= $requestData['ReportPeriod'];

		if ( ($cached = get_transient('scormi_report_cache.'.$reportPeriod)) !== false ){
			$cached = json_decode($cached, true);
			if ( $cached && isset($cached['version']) && $cached['version'] == \Scormi\Scormi::VERSION )
				return $cached;
		}

		for ($it=0; ; $it++){
			$res		= wp_remote_post('http://app.scormi.net/reports/generateByApis.json', array(
				'method'	=> 'POST',
				'body'		=> $requestData,
				'timeout'	=> 15,
			));

			$theBody	= wp_remote_retrieve_body( $res );
			$retCode	= wp_remote_retrieve_response_code($res);

			if ( $retCode != 200 ){
				if ( is_wp_error( $res ) ){
					if ( strstr($res->get_error_message(), 'timed out') && $it < 3 )
						continue;
					throw new Exception('Connection to Scormi.net: '.$res->get_error_message());
				}

				throw new Exception('Problem establishing connection to Scormi.net');
			}
			break;
		}

		$data		= json_decode($theBody, true);

		if ( ! isset($data['version']) || ! isset($data['html']) ) 
			throw new Exception('Unrecogized data from Scormi.net');



		if ( $data['version'] > \Scormi\Scormi::VERSION )
			throw new Exception('Scormi.net released new version, please update plugin');

		if ( isset($data['errors']) ){
			$html = '';
			foreach ($data['errors'] as $error){
				$html .= '<div class="error">'.$error.'</div>';
			}
			throw new Exception($html);
		}

			// Getting seconds left till end of day
		$now=\Scormi\Scormi::getLocalTime();
		$end=\Scormi\Scormi::getLocalTime();
		$end->setTime(23,59);

		set_transient('scormi_report_cache.'.$reportPeriod, $theBody, $end->getTimeStamp() - $now->getTimeStamp());

		return $data;
	}
}
