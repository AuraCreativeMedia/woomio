<?php 


/**
 * Top_Products_Module  
 *
 * @link       https://digitalzest.co.uk
 * @since      1.0.0
 *
 * @package    Woomio
 * @subpackage Woomio/admin
 */

 
 trait Top_Products_Module {


    // 1. We take the order object, find out the total on the order and then update the user meta with the total
    // We record this on our custom table as we'll use this data later

    public function update_db_customer_data( $order_id ) {

		global $wpdb;  // Declare it as global within your function

		$table_name = $wpdb->prefix . 'woomio_customer_top_types';  // Replace with your table name

		$order = wc_get_order( $order_id );
		$user_id = $order->get_user_id();

		// We don't want data from Guests so escape if they aren't logged in
		if ($user_id === 0) {
			return;  // Exit the function early
		}

		foreach ( $order->get_items() as $item_id => $item ) {

			$product_id = $item->get_product_id();
			$quantity = $item->get_quantity();  // Get the quantity for the item


			// Query Tables and Update with the customer ID, product ID and the amount
			
			// Prepare SQL statement
			$sql = $wpdb->prepare(
				"INSERT INTO $table_name (Product_ID, User_ID, Amount_Sold)
				VALUES (%d, %d, %d)
				ON DUPLICATE KEY UPDATE Amount_Sold = Amount_Sold + VALUES(Amount_Sold);",
				$product_id, $user_id, $quantity
			);

			if ($wpdb->query($sql) === false) {
				error_log("Database error: " . $wpdb->last_error);
			}
						
		}

		// 2. Update the user meta on the wp_users table.
		$this->update_db_wp_user_table( $user_id );

	}

    // 3. Now we actually need to find the Top Tx types from our custom table - given a user ID
    public function get_top_of_taxons($user_id) {
		global $wpdb;
	
		$table_name = $wpdb->prefix . 'woomio_customer_top_types';
	
		$sql = $wpdb->prepare(
			"SELECT Product_ID FROM $table_name
			WHERE User_ID = %d
			ORDER BY Amount_Sold DESC",
			$user_id
		);
	
		$results = $wpdb->get_results($sql, ARRAY_A);
		$taxon_count = [];
		$woomio_tpt_options = get_option('_woomio_mod_tpt');
	
		if (!$woomio_tpt_options) {
			return false;
		}
	
		foreach ($results as $row) {
			$product_id = $row['Product_ID'];
	
			foreach ($woomio_tpt_options as $taxon) {
				$terms = get_the_terms($product_id, $taxon);
				$first_sibling_found = false;  // Flag to track if a parent (and therefore first sibling) has been found yet
	
				if ($terms && !is_wp_error($terms)) {
					foreach ($terms as $term) {
						if ($term->slug === 'uncategorized' || $term->slug === 'trade-only' || $term->slug === 'uncategorised') {
							continue;
						}

						if ($term->parent == 0) {

							if ($first_sibling_found) {
								continue;
							}
	
							if (!isset($taxon_count[$taxon])) {
								$taxon_count[$taxon] = [];
							}
		
							if (isset($taxon_count[$taxon][$term->slug])) {
								$taxon_count[$taxon][$term->slug]++;
							} else {
								$taxon_count[$taxon][$term->slug] = 1;
							}

							$first_sibling_found = true;  // Set flag that we've found the first parent (and therefore first sibling)
						}
					}
				}
			}
		}
	
		$top_taxons = [];
	
		foreach ($woomio_tpt_options as $taxon) {
			if (isset($taxon_count[$taxon])) {
				arsort($taxon_count[$taxon]);
				$top_taxons[$taxon] = array_slice(array_keys($taxon_count[$taxon]), 0, 3, true);
			}
		}
	
		return $top_taxons;
	}


    // Now update the user with the latest taxon data
    public function update_db_wp_user_table( $user_id ){

		$top_taxons = $this->get_top_of_taxons( $user_id );
		update_user_meta( $user_id, 'woomio_tpt_slugs', $top_taxons );

	}


	public function get_db_wp_user_data( $user_id ){

		$top_taxons = get_user_meta( $user_id, 'woomio_tpt_slugs' );
		return $top_taxons;

	}


    public function rebuild_user_data(){

		// Fetch orders in batches of 100 to improve performance
		$batch_size = 100;
		$paged = 1;

		global $wpdb;  // Declare it as global within your function

		// We need to rebuild our database so first empty all amount values before we run through every order and get the existing amount values. Without this, the function will append values to old orders meaning the numbers will be wrong.
		$table_name = $wpdb->prefix . 'woomio_customer_top_types';  // Replace with your table name
		$sql_reset = "UPDATE $table_name SET Amount_Sold = 0";

		if ($wpdb->query($sql_reset) === false) {
            error_log("Database error while resetting Amount_Sold: " . $wpdb->last_error);
        }

		do {
			// Iterate over all orders
			$args = array(
				'post_type' => 'shop_order',
				'post_status' => array('wc-completed', 'wc-processing'), // Add additional order statuses if needed
				'posts_per_page' => $batch_size,
				'paged' => $paged,
			);
			
			$loop = new WP_Query($args);
			
			if ($loop->have_posts()) {
				while ($loop->have_posts()) {

					$loop->the_post();
					$order_id = get_the_ID();
			
					// Your code to work with each $order object
					$this->update_db_customer_data( $order_id );

				}
			}

			wp_reset_postdata();
			$paged++;

		} while (count($loop->posts) === $batch_size);  // Stop if we have less than $batch_size orders
	}



    public function export_csv() {
        // Set appropriate headers for CSV file download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="exported_data.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');
    
        // Create a file header
        $header = array("User ID", "User name", "User email", "product_cat_1", "product_cat_2", "product_cat_3", "product_type_1", "product_type_2", "product_type_3", "product_occasion_1", "product_occasion_2", "product_occasion_3", "product_range_1", "product_range_2", "product_range_3");
        $output = fopen('php://output', 'w');
        fputcsv($output, $header);
    
        // Get all users
        $users = get_users();
    
        // Loop through each user
        foreach ($users as $user) {
            $user_id = $user->ID;
            $user_name = $user->display_name;
            $user_email = $user->user_email;
    
            $meta_data = get_user_meta($user_id, 'woomio_tpt_slugs', true);
    
            $row = [$user_id, $user_name, $user_email];
    
            // Prepare your columns here based on the unserialized data
            foreach(['product_cat', 'type', 'occasion', 'range'] as $taxonomy) {
                for($i = 0; $i < 3; $i++) {
                    if(isset($meta_data[$taxonomy][$i])) {
                        $row[] = $meta_data[$taxonomy][$i];
                    } else {
                        $row[] = ''; // Empty cell if not present
                    }
                }
            }
    
            fputcsv($output, $row);
        }
    
        fclose($output);
        exit();
    }





    



 }


   
	
?>
