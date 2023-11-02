<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://digitalzest.co.uk
 * @since      1.0.0
 *
 * @package    Woomio
 * @subpackage Woomio/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woomio
 * @subpackage Woomio/admin
 * @author     Digital Zest <hello@digitalzest.co.uk>
 */



require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/modules/Module_Config.php';

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/modules/order_totals/Order_Totals.php';
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/modules/top_product_types/Top_Product_Types.php';
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/modules/next_order_date/Next_Order_Date.php';
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/modules/new_release_products/New_Release_Products.php';

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/common/Utility_Functions.php';



class Woomio_Admin {

	use Order_Totals_Module, Top_Products_Module, Next_Order_Date, New_Release_Module, Utility_Functions, Module_Config;

	private $plugin_name;
	private $version;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}



	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woomio-admin.css', array(), $this->version, 'all' );
		//wp_enqueue_style('tailwind-css', 'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css');

	}

	public function enqueue_woomio_font_dashicon(){
		wp_enqueue_style('woomio-dashicon', plugin_dir_url(__FILE__) . 'css/woomio-dashicon.css', array(), $this->version, 'all');
		
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts($hook_suffix) {


		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woomio-admin.js', array( 'jquery' ), $this->version, false );

		 if ($hook_suffix == 'toplevel_page_woomio-options' || $hook_suffix == 'woomio_page_woomio-tools' || $hook_suffix == 'woomio_page_woomio-settings') {

			wp_enqueue_script('tailwind-js', 'https://cdn.tailwindcss.com');
		}

	}

	/** Register an admin menu page*/
	public function woomio_admin_parent_page(){
		add_menu_page(
			'WooMio', 
			'WooMio', 
			'manage_options',
			'woomio-options', 
			array( $this, 'admin_page_display' ), 
			'dashicons-woomio-ds' ); 
	}

	public function woomio_tools_submenu_page(){
		add_submenu_page(
			'woomio-options',
			'Tools',
			'Tools',
			'manage_options',
			'woomio-tools',
			array( $this, 'admin_tools_page_display' )
		 );
	}

	public function woomio_settings_submenu_page(){
		add_submenu_page(
			'woomio-options',
			'Settings',
			'Settings',
			'manage_options',
			'woomio-settings',
			array( $this, 'admin_settings_page_display' )
		 );
	}

	public function admin_page_display(){ 
		$page_title = 'Dashboard';
	    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/woomio-admin-display.php';
	}

	public function admin_tools_page_display(){
		$page_title = 'Tools';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/tools-display.php';
	}

	public function admin_settings_page_display(){
		$page_title = 'Module Settings';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/settings-display.php';
	}




	
	public function send_woomio_data_webhook( $order_id ){

		$order = wc_get_order( $order_id );
		$user_id = $order->get_user_id();

		// Make sure order totals meta field is updated with latest values
		// Order totals module
		$this->prepare_Order_Totals_Module( $order_id, $user_id, $order );
		// TPT module
		$this->update_db_customer_data( $order_id );
		// Next order date module
		$this->prepare_Next_Order_Date_Module( $user_id, $order );

		$tradeuser = $this->is_trade_user( $order_id );

		// // Now call webhook to send data
		$this->call_woomio_webhook( $user_id, $order_id, $tradeuser );
	}


	

	public function call_woomio_webhook($user_id = false, $order_id, $tradeuser = false){

		$webhooks = new Woomio_Webhooks($this->plugin_name, $this->version);

		$webhook_url = $webhooks->get_webhook_url('general');

		if(!$webhook_url) : return false; endif;

		if($user_id) : 

			$user_obj = get_user_by('id', $user_id);

			// 0. Initialize an empty $body array
			$body = [
				'user_id' => $user_id, 
				'user_email' => $user_obj->user_email
				];

			if ($tradeuser) : $body['trade_user'] = 'Trade'; endif;
			if ($order_id) : $body['order_id'] = $order_id; endif;


				$modules = Woomio_Admin::get_all_modules();

					if ($modules['order_totals']) : 
			
						$body['running_order_total'] = $this->get_woomio_order_total_meta($user_id);

					endif;

					if ($modules['top_product_types']) : 

						$user_top_types = $this->get_woomio_top_pt_meta($user_id);

						// Define the keys you're interested in . MAGIC VALUES
						$keys = ['product_cat', 'type', 'range', 'occasion'];


						foreach ($keys as $key) {
							for ($i = 1; $i <= 3; $i++) {
								// If the key exists in $user_top_types and its corresponding index exists
								if (isset($user_top_types[$key][$i-1])) {
									// Add it to $body
									$body["top_{$key}_{$i}"] = $user_top_types[$key][$i-1];
								}
							}
						}

					endif;

					if ($modules['next_order_date']) : 

						$metaValueArray = get_user_meta($user_id, 'woomio_next_nudge_date', true);

						if ($metaValueArray && is_array($metaValueArray)) {
							$isoDate = $metaValueArray[0];
							$date = new DateTime($isoDate);
							$body['next_order_date'] = $date->format('Y-m-d');
						} elseif ($metaValueArray && is_string($metaValueArray)) {
							  $date = new DateTime($metaValueArray);
    						  $body['next_order_date'] = $date->format('Y-m-d');
						}


					endif;

		endif;


		// // Set up the arguments for the POST request
		$args = array(
			'body'        => $body,
			'timeout'     => '5',
			'redirection' => '5',
			'httpversion' => '1.0',
			'blocking'    => true,
			'headers'     => array(),
			'cookies'     => array(),
		);

		// Make the POST request
		$response = wp_remote_post( $webhook_url, $args );

		// Check for errors
		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
			echo "Something went wrong: $error_message";
		} else {
			echo 'Response:<pre>';
			print_r( $response );
			echo '</pre>';
		}

	}



	

}
