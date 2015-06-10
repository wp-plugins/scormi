<?php
namespace Scormi\Admin;

class Install {

	public function __construct($plugin_file){
		register_activation_hook(	$plugin_file, array( $this, 'plugin_activation') );
		register_deactivation_hook(	$plugin_file, array( $this, 'plugin_deactivation') );
		register_uninstall_hook(	$plugin_file, array( 'Scormi\Admin\Install', 'plugin_uninstall') );
	}

	public static function plugin_activation(){
		// Setting cron task execution time to 00:05 local time of next day

		try {
			$d = \Scormi\Scormi::getLocalTime();
			$d->add(new \DateInterval('P1D'));
			$d->setTime(0,5);
		}
		catch (\Scormi\Exception $e){
			die($e->getMessage());
		}

		wp_schedule_event( $d->format('U'), 'daily', 'scormi_daily_event_hook' );
	}

	public static function plugin_deactivation(){
		wp_clear_scheduled_hook( 'scormi_daily_event_hook' );
		delete_transient('scormi_report_cache');
	}


	public static function plugin_uninstall(){
		delete_option('scormi_options');
		delete_transient('scormi_report_cache');
	}
}
