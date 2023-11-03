<?php

class Woomio_Webhooks {

    private $plugin_name;
	private $version;

    public function __construct( $plugin_name = PLUGIN_NAME, $version = WOOMIO_VERSION) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	

    const OPTION_KEYS = [
        'general' => '_woomio_webhook_url',
        'new_release_products' => '_woomio_webhook_nrp'
    ];

    
	public function get_webhook_url($option) {
        return isset(self::OPTION_KEYS[$option]) ? get_option(self::OPTION_KEYS[$option]) : null;
    }

	public function update_webhook_url($webhook_url, $option) {
        if (isset(self::OPTION_KEYS[$option])) {
            update_option(self::OPTION_KEYS[$option], $webhook_url);
            return true;
        }
        return false;
    }

    public function post_webhook_data($webhook_type = 'general', $body = []){

        $admin = new Woomio_Admin();

        $webhook_url = $this->get_webhook_url($webhook_type);
        if (!$webhook_url) {
            return false;
        }
        
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
        $response = wp_remote_post($webhook_url, $args);

        // Return the response for further processing
        $admin->log_webhook_response_to_file( $response, $webhook_type );

        return $response;

    }




}
