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


 trait Form_Handlers {

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
			}
			// Sanitize and update the option
			if (isset($_POST['wm-traderole'])) {
				$traderole = sanitize_text_field($_POST['wm-traderole']);
				update_option('_woomio_traderole', $traderole);
			}

			wp_redirect(add_query_arg('wm-settings-updated', 'true', wp_get_referer()));
			exit;
		}

		if (isset($_POST['woomio_save_settings_modules']) ) {

			// Verify nonce
			if (!wp_verify_nonce($_POST['woomio_settings_nonce_modules'], 'woomio_save_settings_modules')) {
				die('Security check failed');
			}
    

			$modules = Woomio_Admin::get_all_modules();
			
			foreach($modules as $module_name => $is_enabled) {
				// If checkbox is checked, update the value to true
				if (isset($_POST[$module_name])) {
					$modules[$module_name] = true;
				} else {
					$modules[$module_name] = false; // If checkbox is unchecked, it's necessary to set it as false
				}
			}

			// Update the options in the database
			update_option('_woomio_module_settings', $modules);
			
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

		if (isset($_POST['woomio_module_next_date_settings'])) {

			// Verify nonce
			if (!wp_verify_nonce($_POST['woomio_settings_nonce_modules'], 'woomio_module_next_date_settings')) {
				die('Security check failed');
			}

			// Sanitize and update the option
			if (isset($_POST['woomio_next_date_options'])) {
				$woomio_next_date_options = $_POST['woomio_next_date_options'];
				update_option('_woomio_mod_next_date', $woomio_next_date_options);

				wp_redirect(add_query_arg('wm-settings-updated', 'true', wp_get_referer()));
				exit;
			}

			
		}

	}

}