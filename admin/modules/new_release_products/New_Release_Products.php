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
    

    // For getting the INT value of the new products
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
        $new_products = $query->post_count;
        
        return $new_products;  // Outputs the count of new products
        
    }

    // Update the new products count in the DB

    public function update_new_products_count(){

        $new_products = $this->get_latest_products();

        update_option( '_woomio_mod_new_prod', $new_products );

    }

    public function get_new_products_count(){

        $new_products = get_option( '_woomio_mod_new_prod' );

        return $new_products;

    }

    // CRON job for when to run the product check and 



}