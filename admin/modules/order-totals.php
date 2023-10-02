<?php 


/**
 * Order Totals Module  
 *
 * @link       https://digitalzest.co.uk
 * @since      1.0.0
 *
 * @package    Woomio
 * @subpackage Woomio/admin
 */

 
 trait Order_Totals_Module {

     // Define a function to calculate and update the running order total for each user
	public function rebuild_users_running_order_total() {
		
		// Get all users who have the 'paying_customer' user meta field set
		$users = get_users( array( 'meta_key' => 'paying_customer' ) );
		
		foreach ( $users as $user ) {
			
			// Initialize running order total for the user
			$order_total = 0;
			
			// Get all completed orders for the user
			$customer_orders = wc_get_orders( array(
				'customer_id' => $user->ID,
				'status'      => 'completed',
				'return'      => 'ids',
				'numberposts' => -1
			) );
			
			// Loop through each order and calculate the running order total
			foreach ( $customer_orders as $order_id ) {
				
				// Get the order
				$order = wc_get_order( $order_id );
				
				// Add the order total to the running order total
				$order_total += $order->get_total();
			}

			// Format the running order total to two decimal places
			$order_total = number_format($order_total, 2, '.', '');
			
			// Update the user meta with the running order total
			update_user_meta( $user->ID, 'woomio_order_total', $order_total );
		}
	}

	public function rebuild_single_user_running_order_total($user_id) {
		
			
			// Initialize running order total for the user
			$order_total = 0;
			
			// Get all completed orders for the user
			$customer_orders = wc_get_orders( array(
				'customer_id' => $user_id,
				'status'      => 'completed',
				'return'      => 'ids',
				'numberposts' => -1
			) );
			
			// Loop through each order and calculate the running order total
			foreach ( $customer_orders as $order_id ) {
				
				// Get the order
				$order = wc_get_order( $order_id );
				
				// Add the order total to the running order total
				$order_total += $order->get_total();
			}

			// Format the running order total to two decimal places
			$order_total = number_format($order_total, 2, '.', '');
			
			// Update the user meta with the running order total
			update_user_meta( $user_id, 'woomio_order_total', $order_total );
		
	}

	// UPDATE ORDER TOTALS FOR USER - this will lead to the value incremeting incorrectly i.e. should be 22 but becomes 26
	public function update_order_totals_for_user($user_id, $order) {

		// Get the order total from the $order object
		$total_to_add = $order->get_total();
	
		// Retrieve the existing total from user meta
		$existing_total = get_user_meta($user_id, 'woomio_order_total', true);
	
		// Check if the existing total is not empty, else initialize it to 0
		$existing_total = !empty($existing_total) ? $existing_total : 0;
	
		// Add the new total to the existing total
		$new_total = $existing_total + $total_to_add;
	
		// Update the user meta with the new total
		update_user_meta($user_id, 'woomio_order_total', $new_total);
	}

 }


   
	
?>
