<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://digitalzest.co.uk
 * @since      1.0.0
 *
 * @package    Dz_Woo_Tpt
 * @subpackage Dz_Woo_Tpt/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php

    /* Handle submit */ 
    $this->woomio_handle_tools_submit();

    /* Return notice on successful submission */ 
    if (isset($_GET['wm-settings-updated']) && $_GET['wm-settings-updated'] == 'true') {
        echo '<div class="notice notice-success is-dismissible"><p>Function run successfully!</p></div>';
    }

/* Get Checkbox values */ 
    $options = get_option('_woomio_module_settings', array(
        'run_order_total' => false,
        'top_product_types' => false,
    ));

?>

<div class="wrap woomio-admin-page">

    <?php 
        include_once( 'components/admin-header.php' );
    ?>

    <h1>Tools</h1>
    <p class="mt-1 text-sm leading-6 text-gray-600">I recommend running the rebuild functions on first installing the plugin as they will ensure Growmio gets the correct values. However be warned that they are intensive operations on larger websites so be patient.</p>
    <?php 
    
    if ($options['run_order_total']) : ?>

        <form id="woomio-tools-run-order-total" class="woomio-settings mb-6" method="POST" action="">

        <!-- Nonce field -->
        <?php wp_nonce_field('woomio_save_rebuild_run_order_total', 'woomio_run_order_total_nonce'); ?>

            <div class="pt-20 space-y-6">
                <div class="border-b border-gray-900/10 pb-6">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">Running Order Total - Tools</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600"></p>
                </div>
                <div class="mt-2 flex items-center justify-start gap-x-6">
                    <button type="submit" name="woomio_save_rebuild_run_order_total" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Rebuild Running Order Totals</button>
                    <span style="color:red;">Warning: Intensive operation</span>
                </div>
                
            </div>
        </form>


    <?php endif; ?>

    <?php 
    
    if ($options['top_product_types']) : ?>


        <form id="woomio-tools-top-product-types" class="woomio-settings mb-6" method="POST" action="">

        <!-- Nonce field -->
        <?php wp_nonce_field('woomio_save_csv_top_product_types', 'woomio_tpt_csv_nonce'); ?>
        <?php wp_nonce_field('woomio_save_tools_top_product_types', 'woomio_tpt_rebuild_nonce'); ?>

            <div class="pt-20 space-y-6">
                <div class="border-b border-gray-900/10 pb-6">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">Top Product Types - Tools</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600"></p>
                </div>
                <div class="mt-2 flex items-center justify-start gap-x-6">
                    <button type="submit" name="woomio_save_csv_top_product_types" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Export CSV</button>
                </div>
                <div class="mt-2 flex items-center justify-start gap-x-6">
                    <button type="submit" name="woomio_save_tools_top_product_types" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Rebuild User Database</button>
                    <span style="color:red;">Warning: Intensive operation</span>
                </div>
            </div>
        </form>

    <?php endif; ?>



</div>