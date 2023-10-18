<?php 

/**
 * Module Configuration - We'll store all the module configuration here, text, any general details about each module.
 *
 * @link       https://digitalzest.co.uk
 * @since      1.0.0
 *
 * @package    Woomio
 * @subpackage Woomio/admin
 */





trait Module_Config {

    public static function get_module_meta() {
        return array(
            'order_totals' => array(
                'title' => 'Order Totals',
                'slug' => 'order_totals',
                'description' => 'On New Orders, send order total to Pabbly...',
            ),
            'top_product_types' => array(
                'title' => 'Top Product Types',
                'slug' => 'top_product_types',
                'description' => 'Send a users top products sorted by taxonomies',
            ),
            'next_order_date' => array(
                'title' => 'Next Order Date',
                'slug' => 'next_order_date',
                'description' => 'Set date in the future so that once date hits email is sent to user to remind them to order again.',
            ),
            'new_release_products' => array(
                'title' => 'Newly Released Products (Under Construction)',
                'slug' => 'new_release_products',
                'description' => 'Send the number of newly released products to Growmio',
            ),
        );
    }

}