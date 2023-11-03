<?php


require_once plugin_dir_path(dirname(__FILE__)) . 'new_release_products/New_Release_Products.php';  

class Woomio_new_release_products_Cron extends Woomio_Cron {

    use New_Release_Module;

    protected function get_cron_interval() {
        return 'hourly'; 
    }

    protected function get_cron_hook_name() {
        return 'woomio_mod_new_release_prod';
    }

    public function cron_task() {
        // This is where the actual task to be done is defined.
        $this->update_new_products_count();
        
    }
}

class Woomio_send_new_releases_growmio_Cron extends Woomio_Cron {

    use New_Release_Module;

    protected function get_cron_interval() {
        return 'weekly_based_on_option'; 
    }

    protected function get_cron_hook_name() {
        return 'woomio_mod_new_release_send_data_growmio';
    }

    public function cron_task() {
        
        $webhooks = new Woomio_Webhooks();

		$webhook_url = $webhooks->get_webhook_url('new_release_products');

		if(!$webhook_url) : return false; endif;

        $newly_released = get_option( '_woomio_mod_new_prod' );

        // 0. Initialize an empty $body array
		$body = [
				'newly_released_products' => $newly_released, 
				];


		$response = $webhooks->post_webhook_data('new_release_products', $body);

        return $response;
				
        
    }
}


