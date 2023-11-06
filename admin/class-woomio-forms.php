<?php

/**
 * The Form-specific functionality of the plugin.
 *
 * @link       https://digitalzest.co.uk
 * @since      1.0.0
 *
 * @package    Woomio
 * @subpackage Woomio/admin
 */




require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/common/Form_Handlers.php';



class Woomio_Forms {

    use Form_Handlers, Top_Products_Module, Next_Order_Date, New_Release_Module, Utility_Functions, Module_Config, Order_Totals_Module;

	private $plugin_name;
	private $version;

	
	public function __construct( $plugin_name = PLUGIN_NAME, $version = WOOMIO_VERSION) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	

	// TRAITs cannot have constants, these belong to FORM_HANDLERS
	const OPTION_KEYS_FH = [
        'wm-webhook' => '_woomio_webhook_url',
        'wm-webhook-nrp' => '_woomio_webhook_nrp',
        'wm-traderole' => '_woomio_traderole'
    ];

	const NONCE_FIELDS = [
        'woomio_save_settings_webhook' => 'woomio_settings_nonce_webhook',

		'woomio_save_rebuild_run_order_total' => 'woomio_run_order_total_nonce',
        'woomio_save_csv_top_product_types' => 'woomio_tpt_csv_nonce',
        'woomio_save_tools_top_product_types' => 'woomio_tpt_rebuild_nonce',

        'woomio_module_tpt_settings' => 'woomio_settings_nonce_modules',
        'woomio_save_settings_modules' => 'woomio_settings_nonce_modules',
        'woomio_module_next_date_settings' => 'woomio_settings_nonce_modules',
        'woomio_module_new_release_products_settings' => 'woomio_settings_nonce_modules'
    ];

	const POST_HANDLERS = [
        'woomio_save_rebuild_run_order_total' => 'rebuild_users_running_order_total',
        'woomio_save_csv_top_product_types' => 'export_csv',
        'woomio_save_tools_top_product_types' => 'rebuild_user_data',
        'woomio_module_tpt_settings' => 'save_tpt_module_settings',
        'woomio_module_next_date_settings' => 'save_next_date_module_settings',
        'woomio_module_new_release_products_settings' => 'save_new_release_products_module_settings'
    ];

	

}
