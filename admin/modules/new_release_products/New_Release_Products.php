<?php 


/**
 * New_Release_Products  
 *
 * @link       https://digitalzest.co.uk
 * @since      1.0.0
 *
 * @package    Woomio
 * @subpackage Woomio/admin
 * 
 */

trait New_Release_Module {

    public function get_latest_products(){

        $args = array(
            'post_type'      => 'product',             
            'post_status'    => 'publish',            
            'date_query'     => array(                
                array(
                    'after'     => '7 days ago',      // Products published after this date
                    'inclusive' => true               // Include products published on this exact date
                )
            ),
            'posts_per_page' => -1,                    
            'fields'         => 'ids'                  
        );
        
        $query = new WP_Query($args);
        
        // Count of products published in the last 7 days
        $count_new_products = $query->post_count;
        
        return $count_new_products;  // Outputs the count of new products
        
    }

}