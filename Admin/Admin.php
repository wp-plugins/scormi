<?php
namespace Scormi\Admin;

class Admin {
	private static $initiated = false;
	private static $notices = array();


	protected $settings;
	protected $report;

	public function __construct(){
		$this->settings = new Settings();

		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_filter( 'plugin_action_links_scormi/scormi.php', array($this, 'add_action_links') );
	}

	function add_action_links ( $links ) {
		$mylinks = array('<a href="' . admin_url( 'admin.php?page=scormi_settings' ) . '">Settings</a>');
		return array_merge( $links, $mylinks );
	}


	public function admin_menu() {
		$options = get_option('scormi_options');
		if ( $options )
			add_menu_page('Scormi', 'Scormi', 'manage_options', 'scormi_menu', array($this, 'preview'));
		else
			add_menu_page('Scormi', 'Scormi', 'manage_options', 'scormi_menu', array($this->settings, 'settings'));

		add_submenu_page('scormi_menu', 'Scormi Settings', 'Settings', 'manage_options', 'scormi_settings', array($this->settings, 'settings'));
	}


	public function preview(){
		try {
			$report	= new \Scormi\Report();
			$data = $report->getAsArray();
			\Scormi\Scormi::loadBootstrap();

			if ( isset($data['images']) ){
				foreach( $data['images'] as $imgData ){
					if ( ! isset($imgData['name']) || ! isset($imgData['content']) || ! isset($imgData['content-type']) )
						wp_die('Cannot parse Scormi.net response, please report');
					$data['html'] = str_replace('{'.$imgData['name'].'}', 'data:'.$imgData['content-type'].';base64,'.$imgData['content'], $data['html']);
				}
			}
			echo $data['html'];
		} catch ( \Scormi\Exception $e){
			wp_die($e->getMessage());
		}

	}
}
