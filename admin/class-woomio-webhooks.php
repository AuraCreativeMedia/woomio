<?php

class Woomio_Webhooks {

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


}
