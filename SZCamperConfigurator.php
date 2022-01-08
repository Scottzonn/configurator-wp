<?php
/*
    Plugin Name:    Camper Configurator
    Plugin URI:     http://webcrunch.com.au
    Description:    Camper configurator for Australian brands
    Author:         Scott Zonneveldt
    Author URI:     http://webcrunch.com.au
    Version:        1.0.38
*/

define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'SCRIPT_DEBUG', true );
define( 'SAVEQUERIES', true );

//load the admin interface
include_once( plugin_dir_path( __FILE__ ) . 'SZAdminSettings.php');
include_once( plugin_dir_path( __FILE__ ) . 'SZEmailNotifications.php');

// Setting react app path constants.
define('RP_PLUGIN_VERSION','0.1.0' );
define('RP_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) . '');
define('RP_REACT_APP_BUILD', RP_PLUGIN_DIR_URL . 'build/');
define('RP_MANIFEST_URL', RP_REACT_APP_BUILD . 'asset-manifest.json');


define('SZ_NONCE', 'sznonce');

/**
 * Calling the plugin class with parameters.
 */
function rp_load_plugin(){
	// Loading the app
	new SZCamperConfigurator();
}

add_action('init','rp_load_plugin');


/**
 * Class SZCamperConfigurator.
 */
class SZCamperConfigurator {

	private $admin_settings;
	private $email_notifications;

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
	 */
	function __construct() {
		$admin_settings = new SZAdminSettings;
		$email_notifications = new SZEmailNotifications();
		add_action( 'rest_api_init', function () {
			register_rest_route( 'camperconfigurator/v1', '/send_email', array(
			  'methods' => 'POST',
			  'callback' => [$this, 'route_send_email']
			) );
		  } );

		  add_action( 'rest_api_init', function () {
			register_rest_route( 'camperconfigurator/v1', '/webhook', array(
			  'methods' => 'POST',
			  'callback' => [$this, 'route_send_email']
			) );
		  } );

		add_action('wp_enqueue_scripts', [$this,'load_react_app']);
		add_shortcode('camper_configurator', [$this, 'configurator_shortcode']);
	}

	public function route_send_email(WP_REST_Request $request){
		//gets parsed params
		$json = $request->get_json_params();
		echo $this . ' xx '. $this->email_notifications;
		$this->email_notifications->sz_sendmail($json, 'self');
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

    /**
	 * Shortcode for the configuator
	 *
	 *
	 * @return string
	 */
	function configurator_shortcode($atts)
	{
        //set up [camper_configurator] shortcode
		$atts = shortcode_atts(array(
			'product' => 'wreath'
		), $atts, 'camper_configurator');

		
		//must localize after script is registered
		$localized_data = array(
			'product' => $atts['product'],
      		'nonce'  => wp_create_nonce( SZ_NONCE ),
			'email_endpoint' => site_url() . '/wp-json/camperconfigurator/v1/send_email',
		);
		// Variables for app use - These variables will be available in window.szReactPlugin variable.
		wp_localize_script(
			'react-plugin-0',
			'szReactPlugin',
			$localized_data
		);
		
		foreach ($this->css_scripts as $css_script) {
			wp_enqueue_style($css_script);
		}
		foreach ($this->js_scripts as $js_script) {
			wp_enqueue_script($js_script);
		}

		return '<div id="sz-root">Loading...</div>';
	}




}