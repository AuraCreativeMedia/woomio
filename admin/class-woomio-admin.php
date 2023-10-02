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


// [29-Sep-2023 09:22:58 UTC] PHP Fatal error:  require_once(): Failed opening required '/home/auracrea/public_html/superdev.auracreativemedia.co.uk/wp-content/plugins/woomio/modules/order-totals.php' (include_path='.:/opt/alt/php74/usr/share/pear') in /home/auracrea/public_html/superdev.auracreativemedia.co.uk/wp-content/plugins/woomio/admin/class-woomio-admin.php on line 26
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/modules/order-totals.php';
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/modules/top-product-types.php';


class Woomio_Admin {

	use Order_Totals_Module, Top_Products_Module;

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

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woomio_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woomio_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

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


		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woomio_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woomio_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

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
	    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/woomio-admin-display.php';
	}

	public function admin_tools_page_display(){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/submenu-display.php';
	}

	public function admin_settings_page_display(){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/module-display.php';
	}


	// Handle the form submission for the Settings page
	public function woomio_handle_install_submit() {

		if (isset($_POST['woomio_save_settings_webhook'])) {

			// Verify nonce
			if (!wp_verify_nonce($_POST['woomio_settings_nonce_webhook'], 'woomio_save_settings_webhook')) {
				die('Security check failed');
			}

			// Sanitize and update the option
			if (isset($_POST['wm-webhook'])) {
				$webhook_url = sanitize_text_field($_POST['wm-webhook']);
				update_option('_woomio_webhook_url', $webhook_url);

				wp_redirect(add_query_arg('wm-settings-updated', 'true', wp_get_referer()));
				exit;
			}
		}

		if (isset($_POST['woomio_save_settings_modules']) ) {

			// Verify nonce
			if (!wp_verify_nonce($_POST['woomio_settings_nonce_modules'], 'woomio_save_settings_modules')) {
				die('Security check failed');
			}
    
			// Default values for checkboxes are false
			$options = array(
				'run_order_total' => false,
				'top_product_types' => false,
			);
			
			// If checkboxes are checked, update the value to true
			if (isset($_POST['run_order_total'])) {
				$options['run_order_total'] = true;
			}
			
			if (isset($_POST['top_product_types'])) {
				$options['top_product_types'] = true;
			}
			
			// Update the options in the database
			update_option('_woomio_module_settings', $options);
			
			// Redirect back with a success message
			wp_redirect(add_query_arg('wm-settings-updated', 'true', wp_get_referer()));
			exit;
		}
		

	}

	// Handle the form submission for the Tools page
	public function woomio_handle_tools_submit() {

		if (isset($_POST['woomio_save_rebuild_run_order_total'])) {

			// Verify nonce
			if (!wp_verify_nonce($_POST['woomio_run_order_total_nonce'], 'woomio_save_rebuild_run_order_total')) {
				die('Security check failed');
			}

			 // Check if Button 1 was clicked
			 if (isset($_POST['woomio_save_rebuild_run_order_total'])) {
				$this->rebuild_users_running_order_total();
			}

			wp_redirect(add_query_arg('wm-settings-updated', 'true', wp_get_referer()));
			exit;
			
		}

		if (isset($_POST['woomio_save_csv_top_product_types'])) {

			// Verify nonce
			if (!wp_verify_nonce($_POST['woomio_tpt_csv_nonce'], 'woomio_save_csv_top_product_types')) {
				die('Security check failed');
			}

			$this->export_csv();

			wp_redirect(add_query_arg('wm-settings-updated', 'true', wp_get_referer()));
			exit;
			
		}

		if (isset($_POST['woomio_save_tools_top_product_types'])) {

			// Verify nonce
			if (!wp_verify_nonce($_POST['woomio_tpt_rebuild_nonce'], 'woomio_save_tools_top_product_types')) {
				die('Security check failed');
			}

			$this->rebuild_user_data();

			wp_redirect(add_query_arg('wm-settings-updated', 'true', wp_get_referer()));
			exit;
			
		}

	
	}

	public function woomio_handle_module_settings_submit() {

		if (isset($_POST['woomio_module_tpt_settings'])) {

			// Verify nonce
			if (!wp_verify_nonce($_POST['woomio_settings_nonce_modules'], 'woomio_module_tpt_settings')) {
				die('Security check failed');
			}

			// Sanitize and update the option
			if (isset($_POST['woomio_tpt_options'])) {
				$woomio_tpt_options = $_POST['woomio_tpt_options'];
				update_option('_woomio_mod_tpt', $woomio_tpt_options);

				wp_redirect(add_query_arg('wm-settings-updated', 'true', wp_get_referer()));
				exit;
			}

			
		}

	}


	
	public function send_woomio_data_webhook( $order_id ){

		$order = wc_get_order( $order_id );
		$user_id = $order->get_user_id();

		// Checking a users order history can be slow so we first check to see if the order is free
		// of notes, if it is it's very likely new and therefore we can skip the thorough check and do
		// a basic increment on the order total
		if($this->is_order_new_and_notes( $order_id )) {
			// return true and therefore we do a quick increment
			$this->update_order_totals_for_user( $user_id, $order );
		} else {
			// return false and therefore order notes exist, we do the long check
			$this->rebuild_single_user_running_order_total( $user_id );
		}

		// // Now call webhook to send data
		$this->call_woomio_webhook( $user_id );
	}


	public function call_woomio_webhook($user_id){

		$webhook_url = get_option('_woomio_webhook_url');

		if(!$webhook_url) : return false; endif;

		$user_obj = get_user_by('id', $user_id);

		// 0. Initialize an empty $body array
		$body = [
			'user_id' => $user_id, 
			'user_email' => $user_obj->user_email
			];

		
				// 1 Order total added to body obj
				$order_total = get_user_meta($user_id, 'woomio_order_total', true);

				if ($order_total) {
					$body['running_order_total'] = $order_total;
				}

				// 2 TPT added to body obj
				$user_top_types_unflat = $this->get_db_wp_user_data($user_id);
				$user_top_types = $user_top_types_unflat[0] ?? [];

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



	
    // public function is_order_new_and_notes( $order_id ) {
    //     // Get order notes
    //     $notes = wc_get_order_notes( array( 'order_id' => $order_id ) );

    //     // Loop through the notes and check if any of them indicate a status change
    //     foreach ( $notes as $note ) {
    //         if ( strpos( strtolower( $note->content ), 'status changed' ) !== false ) {
    //             // The order status has been changed in the past
    //             // Do something if needed
    //             return false;
    //         }
    //     }

    //     // The order is entirely new and has not had its status changed in the past
    //     // Perform your actions for a new order here
    //     return true;
    // }

	public function is_order_new_and_notes( $order_id ) {
		// Get order notes
		$notes = wc_get_order_notes( array( 'order_id' => $order_id ) );
	
		// Loop through the notes and check if any of them indicate a status change to completed
		foreach ( $notes as $note ) {
			// Check if the note indicates that the order status was changed to completed
			if ( strpos( strtolower( $note->content ), 'status changed to completed' ) !== false ) {
				// The order was set to completed in the past
				return false;
			}
		}
	
		// The order has never been set to completed in the past
		return true;
	}
	

	

}
