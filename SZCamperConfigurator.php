<?php
/*
    Plugin Name:    Camper Configurator
    Plugin URI:     http://webcrunch.com.au
    Description:    Camper configurator for Australian brands
    Author:         Scott Zonneveldt
    Author URI:     http://webcrunch.com.au
    Version:        1.0.31
*/

define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'SCRIPT_DEBUG', true );
define( 'SAVEQUERIES', true );

//load the admin interface
include( plugin_dir_path( __FILE__ ) . 'SZAdminSettings.php');

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
		
		add_action( 'rest_api_init', function () {
			register_rest_route( 'camperconfigurator/v1', '/send_email', array(
			  'methods' => 'POST',
			  'callback' => [$this, 'route_send_email']
			) );
		  } );

		add_shortcode('camper_configurator', [$this, 'configurator_shortcode']);
		echo '<h2>enquue scripts</h2>';
		add_action('wp_enqueue_scripts', [$this,'load_react_app']);
	}

	function route_send_email(WP_REST_Request $request){

		//gets parsed params
		$json = $request->get_json_params();
		$this->sz_sendmail($json);

	}
	//send email
	function sz_sendmail($buildJson){
		
		$message =  json_encode($buildJson);
		
		$emailTo	 	= CConfiguratorAdminPageFramework::getOption( 'SZAdminSettings', 'self_email_to', '' );
		$fromName 		= CConfiguratorAdminPageFramework::getOption( 'SZAdminSettings', 'self_email_from_name', 'Camper Configurator' );
		$fromEmail 		= CConfiguratorAdminPageFramework::getOption( 'SZAdminSettings', 'self_email_from_email', 'Camper Configurator' );
		$emailReplyTo 	= CConfiguratorAdminPageFramework::getOption( 'SZAdminSettings', 'self_email_reply_to', $fromEmail );
		$emailTemplate 	= CConfiguratorAdminPageFramework::getOption( 'SZAdminSettings', 'self_email_template', '' );
		$emailSubject 	= CConfiguratorAdminPageFramework::getOption( 'SZAdminSettings', 'self_email_subject', 'New Camper Submitted' );
		
		$headers = array(
			'Content-Type: text/html; charset=UTF-8',
			"From: $fromName <$fromEmail>",
			"Reply-To: $replyTo"
		);

		if(wp_mail($emailTo, $this->replaceDynamicTags($buildJson, $emailSubject), $this->replaceDynamicTags($buildJson, $emailTemplate) . '<br>' . $message, $headers)) {
			$response = [
				message => 'this worked',
				success => true,
			];
			echo json_encode($response);

		} else {
			$response = [
				message => 'failed',
				success => false,
			];
			echo json_encode($response);
		}


		die();
	}

	function replaceDynamicTags($buildJson, $string){

		$accessories = '';
		foreach($buildJson->accessories as $accessory){
			$accessories += '<li>'. $accessory->name . ' - ' . $accessory->rrp . '</li>';
		}
		$accessories = '<ul>' . $accessories . '</ul>';

		$replacements = array(
			'[first name]' 		=>  $buildJson->customer->firstName,
			'[surname]' => 			$buildJson->customer->surname,
			'[full name]' => 		$buildJson->customer->firstName . ' ' . $buildJson->customer->surname,
			'[email]' => 			$buildJson->customer->email,
			'[postcode]' => 		$buildJson->customer->postcode,
			'[phone]' => 			$buildJson->customer->phone,
			'[address line 1]' => 	$buildJson->customer->address->{'address-line-1'},
			'[address line 2]' => 	$buildJson->customer->address->{'address-line-2'},
			'[city]' => 			$buildJson->customer->address->city,
			'[country]' => 			$buildJson->customer->address->country,
			'[state]' => 			$buildJson->customer->address->state,
			'[product name]' => 	$buildJson->product->name,
			'[rrp]' => 				$buildJson->model->rrp,
			'[image url]' => 		$buildJson->model->featured_image->url,
			'[accessories list]' =>	$accessories
		);

		foreach($replacements as $placeholder => $literal){
			$string = str_replace($placeholder, $literal, $string);
		}

		return $string;

	}

	function getEmailTemplate(){
		// The extended class name is used as the option key. This can be changed by passing a custom string to the constructor.
		// echo '<h3>Saved Fields</h3>';
		// echo '<pre>my_text_field: ' . CConfiguratorAdminPageFramework::getOption( 'SZAdminSettings', 'self_email_recipients', 'no template filled in' ) . '</pre>';
		// echo '<pre>my_textarea_field: ' . CConfiguratorAdminPageFramework::getOption( 'SZAdminSettings', 'my_textarea_field', 'default text value' ) . '</pre>';
		// echo '<h3>Show all the options as an array</h3>';
		// echo $this->oDebug->get( CConfiguratorAdminPageFramework::getOption( 'SZAdminSettings' ) );


		
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
			echo 'registering ' . RP_REACT_APP_BUILD . $css_file;
			array_push($this->css_scripts, 'react-plugin-' . $index);
		}

		// Register js files. Load them later when required (in shortcode)
		foreach ( $js_files as $index => $js_file ) {
			wp_register_script('react-plugin-' . $index, RP_REACT_APP_BUILD . $js_file, array(), RP_PLUGIN_VERSION, true);
			echo 'registering ' . RP_REACT_APP_BUILD . $js_file;
			array_push($this->js_scripts, 'react-plugin-' . $index);
		}

		// Variables for app use - These variables will be available in window.rpReactPlugin variable.
		wp_localize_script( 'react-plugin-0', 'WPLocalizedReactPlugin',
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