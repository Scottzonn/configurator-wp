<?php
/*
    Plugin Name:    Camper Configurator
    Plugin URI:     http://webcrunch.com.au
    Description:    Camper configurator for Australian brands
    Author:         Scott Zonneveldt
    Author URI:     http://webcrunch.com.au
    Version:        1.0.6
*/

define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'SCRIPT_DEBUG', true );
define( 'SAVEQUERIES', true );

//load the admin interface
include( dirname( __FILE__ ) . './SZAdminSettings.php');

// Setting react app path constants.
define('RP_PLUGIN_VERSION','0.1.0' );
define('RP_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) . 'react-app/');
define('RP_REACT_APP_BUILD', RP_PLUGIN_DIR_URL . 'build/');
define('RP_MANIFEST_URL', RP_REACT_APP_BUILD . 'asset-manifest.json');

/**
 * Calling the plugin class with parameters.
 */
function rp_load_plugin(){
	// Loading the app
	new SZCamperConfigurator( '#site-footer');
}

add_action('init','rp_load_plugin');


/**
 * Class SZCamperConfigurator.
 */
class SZCamperConfigurator {

	/**
	 * @var string
	 */
	private $selector = '';
	
	/**
	 * @var array
	 */
	private $js_scripts = array();

	/**
	 * @var array
	 */
	private $css_scripts = array();

	/**
	 * SZCamperConfigurator constructor.
	 *
	 * @param string $css_selector Css selector to render react app.
	 */
	function __construct( $css_selector)  {
		$this->selector = $css_selector;
		add_action('wp_enqueue_scripts', [$this,'load_react_app']);
	}

	/**
	 * Load react app files in WordPress admin.
	 *
	 * @param $hook
	 *
	 * @return bool|void
	 */
	function load_react_app( $hook ) {



		// Get assets links.
		$assets_files = $this->get_assets_files();

		$js_files  = array_filter( $assets_files,  fn($file_string) => pathinfo( $file_string, PATHINFO_EXTENSION ) === 'js');
		$css_files  = array_filter( $assets_files,  fn($file_string) => pathinfo( $file_string, PATHINFO_EXTENSION ) === 'css');

		// Register css files. Load them later when required (in shortcode)
		foreach ( $css_files as $index => $css_file ) {
			wp_register_style('react-plugin-' . $index, RP_REACT_APP_BUILD . $css_file);
			array_push($this->css_scripts, 'react-plugin-' . $index);
		}

		// Register js files. Load them later when required (in shortcode)
		foreach ( $js_files as $index => $js_file ) {
			wp_register_script('react-plugin-' . $index, RP_REACT_APP_BUILD . $js_file, array(), RP_PLUGIN_VERSION, true);
			array_push($this->js_scripts, 'react-plugin-' . $index);
		}

		// Variables for app use - These variables will be available in window.rpReactPlugin variable.
		wp_localize_script( 'react-plugin-0', 'rpReactPlugin',
			array( 'appSelector' => $this->selector )
		);
	}

	/**
	 * Get app entry points assets files.
	 *
	 * @return bool|void
	 */
	private function get_assets_files(){
		// Request manifest file.
		$request = file_get_contents( RP_MANIFEST_URL );

		// If the remote request fails.
		if ( !$request  )
			return false;

		// Convert json to php array.
		$files_data = json_decode( $request );
		if ( $files_data === null )
			return;

		// No entry points found.
		if ( ! property_exists( $files_data, 'entrypoints' ) )
			return false;

		return $files_data->entrypoints;
	}
}