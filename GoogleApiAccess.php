<?php
namespace Scormi;

class GoogleApiAccess {
	var $apiKey			= "AIzaSyCVZgO2tSzOpT40n6nwrh4lkVATLh4MwFA"; 
	var $clientId		= "495385332340-vigv0u416p5ss95hbnunf4rujm4kplsu.apps.googleusercontent.com";
	var $clientSecret	= "rcZlyead6DLqpb2FLJH4d0QI";

	static	$_instance	= null;

	public static function inst(){
		if ( ! self::$_instance )
			self::$_instance = new GoogleApiAccess();
		return self::$_instance;
	}

	public function __construct(){
		require_once \Scormi\Scormi::pluginDirPath() . '/google-api-php-client/src/Google/autoload.php';
		$this->client = new \Google_Client();
		$this->client->setApplicationName('Scormi');
		$this->client->setDeveloperKey($this->apiKey);
		$this->client->setClientId($this->clientId);
		$this->client->setClientSecret($this->clientSecret);
		$this->client->setRedirectUri('urn:ietf:wg:oauth:2.0:oob');
		$this->client->setScopes(array(\Google_Service_Analytics::ANALYTICS_READONLY));
		$this->client->setAccessType('offline');
		$this->isAccessTokenActive();
		$this->analytics = new \Google_Service_Analytics($this->client);
	}

/*	public function handleCode(){	// for callback handling, version with redirect url
		if (isset($_GET['code'])) {
			$this->client->authenticate($_GET['code']);
			$_SESSION['token'] = $this->client->getAccessToken();
			$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
			header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
			return;
		}
	}*/

	public function handleCode($code){	// for callback handling, for devices without redirect url
		$this->client->authenticate($code);
  		$token = $this->client->getAccessToken();
		return $token;
	}


	public function isAccessTokenActive(){
		$options = get_option('scormi_options'); 
		if ( !isset($options['google_token']) || ! strlen($options['google_token']) ) 
			return false;
		$this->client->setAccessToken($options['google_token']);
		return true;
	}

	public function getAccessTokenUrl(){
		if (!$this->client->getAccessToken()) {
			return $this->client->createAuthUrl();
		}
	}


	public function getGaTypes(){
		$results = $this->analytics->metadata_columns->listMetadataColumns('ga');


		$columns = $results->getItems();
		foreach ($columns as $column) {
			echo '<h3>' . $column->getId() . '</h3>';
			$column_attributes = $column->getAttributes();
			foreach ($column_attributes as $name=>$value) {
				echo "$name: $value<br>";
			}
		}

		$attributes = $results->getAttributeNames();
		foreach ($attributes as $attribute) {
			var_dump($attribute);
		}
	}



	public function getAccounts(){
		$accounts = $this->analytics->management_accounts->listManagementAccounts();
		return $accounts->getItems();
	}

	public function getProperties($accountId){
		$webProperties = $this->analytics->management_webproperties->listManagementWebproperties($accountId);
		return $webProperties->getItems();
	}

	public function getProfiles($account, $webProperty){
		$profiles = $this->analytics->management_profiles->listManagementProfiles($account->getId(), $webProperty->getId());
		return $profiles->getItems();
	}

	public function getProfileId($url){
		$profiles = $this->analytics->management_profiles->listManagementProfiles('~all', '~all')->getItems();
		foreach ($profiles as $profile){
			if ( $profile->getWebsiteUrl() == $url || $profile->getWebsiteUrl() == $url.'/' )
				return $profile->getId();
		}

		return false;
	}


	public function getAllProfiles(){
		return $this->analytics->management_profiles->listManagementProfiles('~all', '~all')->getItems();
	}



	protected function formatGaData($ga_data){
		if ( ! is_array($ga_data->rows) ) 
			return array();
		$data = array();
		$columns = $ga_data->getColumnHeaders();
		foreach ($ga_data->rows as $row){
			$new_row = array();
			for($i=0; $i<count($columns); $i++)
				$new_row[$columns[$i]->name] = $row[$i];
			$data[] = $new_row;
		}
		return $data;
	}

	public function batchRequest($profileId, $start_date, $end_date, Array $elements){
		$this->client->setUseBatch(true);
		$this->analytics = new \Google_Service_Analytics($this->client);
		$batch = new \Google_Http_Batch($this->client);

		foreach ($elements as $name  => $elem){
			$metrics = $elem['metrics'];
			unset($elem['metrics']);

			$req = $this->analytics->data_ga->get('ga:'.$profileId, $start_date, $end_date, $metrics, $elem);
			$batch->add($req, $name);
		}
		$results = $batch->execute();

		$data = array();
		foreach ($results as $key => $result){
			$key = str_replace('response-', '', $key);
			$data[$key] = $this->formatGaData($result);
		}
		return $data;
	}


	public function getData($from, $till, $profile_id){
		if ( ! strlen(trim($profile_id)) )
			return array();

		$data = get_transient('ScormiGAData'.$profile_id.$from->format('Y-m-d').$till->format('Y-m-d'), $data);
		if ( $data )
			return $data;

		$data = $this->batchRequest(
			$profile_id, 
			$from->format('Y-m-d'),
			$till->format('Y-m-d'),
			array(
			'TopPages' => array(
				'metrics'		=> 'ga:pageviews,ga:users,ga:bounceRate,ga:percentNewSessions', 
				'dimensions'	=> 'ga:pageTitle',
				'sort'			=> '-ga:pageviews',
				'max-results'	=> 10,
			),
			'UsersPageView' => array(
				'metrics'		=> 'ga:users,ga:pageviews',
				'dimensions'	=> 'ga:month,ga:day',
				'sort'			=> 'ga:month,ga:day',
			),

			'TopCountries' => array(
				'metrics'		=> 'ga:users',
				'dimensions'	=> 'ga:country',
				'sort'			=> '-ga:users',
				'max-results'	=> 3,
   				'filters'		=> 'ga:country!=(not set)',
			),
			'WeekRows' => array(
				'metrics'		=> 'ga:pageviews,ga:users,ga:percentNewSessions',
			),

			'Medium' => array(
				'metrics'		=> 'ga:users', 
				'dimensions'	=> 'ga:medium',
				'sort'			=> '-ga:users',
				'segment'		=> 'gaid::-1',
			),

			'Devices' => array(
				'metrics'		=> 'ga:users', 
				'dimensions'	=> 'ga:deviceCategory',
				'sort'			=> '-ga:users',
			),

			'Social' => array(
  				'metrics'		=> 'ga:users',
				'dimensions'	=> 'ga:hasSocialSourceReferral',
				'filters'		=> 'ga:socialNetwork!=(not set);ga:socialNetwork!=(none)',
				'max-results'	=> 10,
				'sort'			=> '-ga:users'
			)
		));

		if ( isset($data['WeekRows'][0]) )
			$data['Week'] = $data['WeekRows'][0];

		set_transient('ScormiGAData'.$profile_id.$from->format('Y-m-d').$till->format('Y-m-d'), $data, 3600);

		return $data;
	}
}
