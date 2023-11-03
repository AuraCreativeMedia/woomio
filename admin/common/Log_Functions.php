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


 trait Log_Functions {

    public function log_webhook_response_to_file( $response, $webhook_type ) {
        // Get the wp-uploads directory path
        $upload_dir = wp_upload_dir();
        $log_dir = $upload_dir['basedir'] . '/woomio-logs';
        
        // Check if directory exists, if not, create it
        if( ! is_dir( $log_dir ) ) {
            wp_mkdir_p( $log_dir );
        }
    
        $log_file = $log_dir . '/webhook_logs.txt';
    
          // Extract status code and message from response
          $status_code = isset($response['response']['code']) ? $response['response']['code'] : 'N/A';
          $status_message = isset($response['response']['message']) ? $response['response']['message'] : 'N/A';
          
          // Prepare log data
          $log_data = "------------------\n" . 
            "Webhook Type: " . $webhook_type . " || Logged at: " . date( "Y-m-d H:i:s" ) . " - " . "Status Code: " . $status_code . " - " . "Status Message: " . $status_message . "\n";
  
          // Append data to the log file
          file_put_contents( $log_file, $log_data, FILE_APPEND );
      }
    

 }