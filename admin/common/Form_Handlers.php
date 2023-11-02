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

	

	protected function verify_nonce($action) {
        return isset(self::NONCE_FIELDS[$action]) && wp_verify_nonce($_POST[self::NONCE_FIELDS[$action]], $action);
    }

	protected function redirect_settings_updated() {
        wp_redirect(add_query_arg('wm-settings-updated', 'true', wp_get_referer()));
        exit;
    }

	protected function update_option($key, $value) {
        $sanitized_value = is_string($value) ? sanitize_text_field($value) : $value; // Assuming the value can only be string or array.
        update_option($key, $sanitized_value);
    }


	protected function save_webhook_settings() {
        foreach (self::OPTION_KEYS_FH as $field => $option_key) {
            if (isset($_POST[$field])) {
                $sanitized_value = sanitize_text_field($_POST[$field]);
                update_option($option_key, $sanitized_value);
            }
        }
    }


	public function woomio_handle_install_submit() {

        if (isset($_POST['woomio_save_settings_webhook']) && $this->verify_nonce('woomio_save_settings_webhook')) {
            $this->save_webhook_settings();
            $this->redirect_settings_updated();
        }

        if (isset($_POST['woomio_save_settings_modules']) && $this->verify_nonce('woomio_save_settings_modules')) {
            $this->save_module_settings();
            $this->redirect_settings_updated();
        }
    }

	public function woomio_handle_tools_submit() {
        foreach (self::POST_HANDLERS as $post_field => $handler) {
            if (isset($_POST[$post_field]) && $this->verify_nonce($post_field)) {
                $this->$handler();
                $this->redirect_settings_updated();
            }
        }
    }

	public function save_module_settings() {
        $modules = Woomio_Admin::get_all_modules();
        foreach ($modules as $module_name => $is_enabled) {
            $modules[$module_name] = isset($_POST[$module_name]);
        }
        update_option('_woomio_module_settings', $modules);
    }


	public function save_tpt_module_settings() {
        if (isset($_POST['woomio_tpt_options'])) {
            $value = $_POST['woomio_tpt_options'];
            $this->update_option('_woomio_mod_tpt', $value);
        }
    }

	public function save_next_date_module_settings() {
        if (isset($_POST['woomio_next_date_options'])) {
            $sanitized_value = sanitize_text_field($_POST['woomio_next_date_options']);
            $this->update_option('_woomio_mod_next_date', $sanitized_value);
        }
    }


    public function save_new_release_products_module_settings() {
        if (isset($_POST['woomio_new_release_products_page'])) {
            $sanitized_value = sanitize_text_field($_POST['woomio_new_release_products_page']);
            $this->update_option('_woomio_mod_new_release_prod_page', $sanitized_value);
        }
        if (isset($_POST['woomio_next_date_dow'])) {
            $sanitized_value = sanitize_text_field($_POST['woomio_next_date_dow']);
            $this->update_option('_woomio_mod_new_prod_dow', $sanitized_value);
        }
    }

    

	


	

	

}