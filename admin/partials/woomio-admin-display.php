<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://digitalzest.co.uk
 * @since      1.0.0
 *
 * @package    Woomio
 * @subpackage Woomio/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php

    /* Handle submit */ 
    $this->woomio_handle_install_submit();

    /* Return notice on successful submission */ 
    if (isset($_GET['wm-settings-updated']) && $_GET['wm-settings-updated'] == 'true') {
        echo '<div class="notice notice-success is-dismissible"><p>Settings updated successfully!</p></div>';
    }

    /* Get Checkbox values */ 
    $options = get_option('_woomio_module_settings', array(
        'run_order_total' => false,
        'top_product_types' => false,
    ));

?>


<div class="wrap woomio-admin-page">

    <?php include_once( 'components/admin-header.php' ); ?>

        <form id="woomio-webhook-form" class="woomio-settings mb-6" method="POST" action="">

         <!-- Nonce field -->
        <?php wp_nonce_field('woomio_save_settings_webhook', 'woomio_settings_nonce_webhook'); ?>

        <div class="pt-20 space-y-6">
            <div class="border-b border-gray-900/10 pb-6">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Installation</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">Required: Add a Webhook URL to push data</p>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-4">
                        <label for="wm-webhook" class="block text-sm font-medium leading-6 text-gray-900">Webhook URL</label>
                        <div class="mt-2">
                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                <input type="text" name="wm-webhook" id="wm-webhook" value="<?php echo esc_attr(get_option('_woomio_webhook_url')); ?>" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="">
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="mt-2 flex items-center justify-start gap-x-6">
                <button type="submit" name="woomio_save_settings_webhook" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
            </div>
        </div>
        </form>

        <form method="post" action="">

        <?php wp_nonce_field('woomio_save_settings_modules', 'woomio_settings_nonce_modules'); ?>
            
            <div class="border-b border-gray-900/10 pb-12 pt-20 space-y-6">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Modules</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">Select which Modules you'd like to use. You must ensure these are setup in Pabbly</p>

                <div class="mt-10 space-y-10">
                    <fieldset>
                        <legend class="text-sm font-semibold leading-6 text-gray-900">Growmio User Account - Modules</legend>
                        <div class="mt-6 space-y-6">
                            <div class="relative flex gap-x-3">
                                <div class="flex h-6 items-center">
                                    <input id="run_order_total" name="run_order_total" type="checkbox" <?php checked($options['run_order_total']); ?> class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                </div>
                                <div class="text-sm leading-6">
                                    <label for="run_order_total" class="font-medium text-gray-900">Running Order Total</label>
                                    <p class="text-gray-500">On New Orders, send order total to Pabbly which then calculates the total running order values for a user.</p>
                                </div>
                            </div>
                            <div class="relative flex gap-x-3">
                                <div class="flex h-6 items-center">
                                    <input id="top_product_types" name="top_product_types" type="checkbox" <?php checked($options['top_product_types']); ?> class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                </div>
                                <div class="text-sm leading-6">
                                    <label for="top_product_types" class="font-medium text-gray-900">Top Product Types</label>
                                    <p class="text-gray-500">Send a users top products sorted by taxonomies</p>
                                </div>
                            </div>
                            
                        </div>
                    </fieldset>
               
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <button type="submit" name="woomio_save_settings_modules" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
            </div>
        </form>

</div>

