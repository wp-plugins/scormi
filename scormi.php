<?php
/*
    Plugin Name: Scormi for Google Analytics
    Plugin URI: http://www.scormi.net
    Description: Scores your blog post engagement strength.
    Tags: Google Analytics, Scorecard
    Author: Aleksey Korenkov, Dave Goodwin
    Author URI: http://www.scormi.net
    Requires at least: WordPress 4.0
    Tested up to: 4.3.1
    Version: 3.1
    License: GPL v2 or later

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
*/

namespace Scormi;

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}


class Scormi{
	const VERSION = 3.0;

	public function __construct(){
		add_action('init',		array($this, 'ScormiStartSession'), 1);
		add_action('wp_logout',	array($this, 'ScormiEndSession'));
		add_action('wp_login',	array($this, 'ScormiEndSession'));


		spl_autoload_register(array($this, 'autoload'));

		new \Scormi\CronJob\CronJob();

		if ( is_admin() ) {
			new \Scormi\Admin\Install(__FILE__);
			new \Scormi\Admin\Admin();
		}

		add_shortcode( 'scormi', array( $this, 'shortcode'));
	}

	public static function pluginDirPath(){
		return plugin_dir_path(__FILE__);
	}

	protected function autoload($class) {
		if ( substr($class, 0, 7) != 'Scormi\\' )
			return;

		if ( ! is_file ( $this->pluginDirPath() . '/'.str_replace('Scormi/','', str_replace('\\', '/', $class)).'.php' ) )
			throw new Exception('Unable to load class: '. $class);

		require_once( $this->pluginDirPath() . '/'.str_replace('Scormi/','', str_replace('\\', '/', $class)).'.php' );
	}


	function ScormiStartSession() {
		if(!session_id())
			session_start();
	}

	function ScormiEndSession() {
		session_destroy ();
	}


	public static function loadBootstrap(){
		wp_enqueue_style('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css');
		wp_enqueue_style('bootstrap-theme', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css');
	}

	public function shortcode($attrs){
		$this->loadBootstrap();
		try {
			$report	= new \Scormi\Report();
			$data = $report->getAsArray();

			if ( isset($data['images']) ){
				foreach( $data['images'] as $imgData ){
					if ( ! isset($imgData['name']) || ! isset($imgData['content']) || ! isset($imgData['content-type']) )
						wp_die('Cannot parse Scormi.net response, please report');
					$data['html'] = str_replace('{'.$imgData['name'].'}', 'data:'.$imgData['content-type'].';base64,'.$imgData['content'], $data['html']);
				}
			}
			return $data['html'];
		} catch ( \Scormi\Exception $e){
			wp_die($e->getMessage());
		}
	}


	public static function getLocalTime(){
			// date_i18n doesn't handle 'P' when timezone set to 'Manual Offsets'
			// getting timezone P formatted
		$offset	= get_option( 'gmt_offset' );
		$hours  = intval($offset);
		$mins   = abs($offset-$hours)*60;
		$tz = sprintf("%+03d:%02d", $hours, $mins);

			// create local date with correct timezone
		$d = \DateTime::createFromFormat('Y-m-d\TH:i:sP', date_i18n('Y-m-d\TH:i:s').$tz);
		if ( ! $d )
			throw new Exception('Cannot parse date');

		return $d;
	}
}

new Scormi();
