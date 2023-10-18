<?php 

/**
 * Next Order Date - Nudger Reminder Email
 *
 * @link       https://digitalzest.co.uk
 * @since      1.0.0
 *
 * @package    Woomio
 * @subpackage Woomio/admin
 */




// ON NEW ORDER
// Order Date - Date in X months.
// (Set date in the future so that once date hits email is sent.)

// To say to user ‘you haven’t ordered in x months’

// Admin needs to be able to set custom date/time. 
// Use days 

trait Next_Order_Date {
    
   

	public function prepare_Next_Order_Date_Module( $user_id, $order ) {
		 // Get set date from options table - _woomio_mod_next_date
        // calculate date in the future
        // Get latest order

        $next_date = get_option('_woomio_mod_next_date'); // Assuming this returns an integer like 14

        if ($next_date):
            // Create a DateTime object for today's date
            $order_date = $order->get_date_created();

            // Calculate the future date
            $futureDate = clone $order_date; // Clone to avoid modifying the original $order_date object
            $futureDate->add(new DateInterval("P{$next_date}D"));

            $nudge_date = $futureDate->format('c');

            // Update the user meta with the nudge date
            update_user_meta( $user_id, 'woomio_next_nudge_date', $nudge_date );

            return true;

        endif;

        return false;
        
    }

}


?>