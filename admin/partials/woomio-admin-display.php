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
    $forms = new Woomio_Forms();
    $webhooks = new Woomio_Webhooks();

    $forms->woomio_handle_install_submit();

    /* Return notice on successful submission */ 
    if (isset($_GET['wm-settings-updated']) && $_GET['wm-settings-updated'] == 'true') {
        echo '<div class="notice notice-success is-dismissible"><p>Settings updated successfully!</p></div>';
    }

    /* Get Checkbox values */ 
    $modules = Woomio_Admin::get_all_modules();
    $active_mods = Woomio_Admin::get_all_modules();
    $descriptions = Woomio_Admin::get_module_meta();

    $all_roles = wp_roles()->roles;
    $editable_roles = apply_filters('editable_roles', $all_roles);

    $traderole = get_option('_woomio_traderole');

?>


<div class="wrap woomio-admin-page">

    <?php include_once( 'components/admin-header.php' ); ?>

        <form id="woomio-webhook-form" class="woomio-settings mb-6" method="POST" action="">

         <!-- Nonce field -->
        <?php wp_nonce_field('woomio_save_settings_webhook', 'woomio_settings_nonce_webhook'); ?>

        <div class="pt-2 space-y-6">
            <div class="bg-gray-100 p-6 border-b border-gray-900/10 pb-6">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Installation</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">Add Webhook URL's to push data to Growmio</p>

                <div class="mt-10 grid grid-cols-2 gap-x-6 gap-y-8 sm:grid-cols-8">
                    <div class="sm:col-span-2">
                        <label for="wm-webhook" class="block text-sm font-medium leading-6 text-gray-900">Contacts - Webhook URL</label>
                        <small>General webhook for a range of functions - required by Woomio</small>
                        <div class="mt-2">
                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                <input type="text" name="wm-webhook" id="wm-webhook" value="<?php echo esc_attr($webhooks->get_webhook_url('general')); ?>" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="wm-webhook-nrp" class="block text-sm font-medium leading-6 text-gray-900">Newly Released Products - Webhook URL</label>
                        <small>Webhook used by module - Optional</small>
                        <div class="mt-2">
                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                <input type="text" name="wm-webhook-nrp" id="wm-webhook-nrp" value="<?php echo esc_attr($webhooks->get_webhook_url('new_release_products')); ?>" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-4">
                        <label for="wm-traderole" class="block text-sm font-medium leading-6 text-gray-900">Select the Trade User Role (if exists)</label>
                        <div class="mt-2">
                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                <select name="wm-traderole" id="wm-traderole" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6 max-w-max" style="max-width:100%;">
                                  <!-- Adding a "None" option -->
                                  <option value="">None</option>
                                <?php
                                    foreach ($editable_roles as $role_slug => $role_details) {
                                        $isSelected = ($traderole == $role_slug) ? 'selected' : '';
                                        echo '<option value="' . esc_attr($role_slug) . '" ' . $isSelected . '>' . esc_html($role_details['name']) . '</option>';
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 

                    $submit_name = 'woomio_save_settings_webhook';
                    include( PLUGIN_ROOT . 'admin/partials/components/form-button.php' ); 

                ?>
            </div>

            

        
        </div>
        </form>

        <form method="post" action="">

        <?php wp_nonce_field('woomio_save_settings_modules', 'woomio_settings_nonce_modules'); ?>
            
            <div class="bg-gray-100 p-6 border-b border-gray-900/10 mb-6 pb-6">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Modules</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">Select which Modules you'd like to use. You must ensure these are setup in Pabbly</p>

                <div class="mt-10 space-y-10">
                    <fieldset>
                        <legend class="text-sm font-semibold leading-6 text-gray-900">Growmio User Account - Modules</legend>
                        <div class="mt-6 space-y-6">

                        <?php

                            foreach ($modules as $module_name => $is_enabled) {
                                // Get module description from the metadata array
                                
                                $mod_desc = $descriptions[$module_name]['description'] ?? 'No description available.';
                                $mod_title = $descriptions[$module_name]['title'] ?? 'No title available.';
                                
                                // Your HTML template
                                ?>
                                <div class="relative flex gap-x-3">
                                    <div class="flex h-6 items-center">
                                        <input 
                                            id="<?php echo $module_name; ?>" 
                                            name="<?php echo $module_name; ?>" 
                                            type="checkbox" 
                                            <?php checked($modules[$module_name]); ?> 
                                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                        >
                                    </div>
                                    <div class="text-sm leading-6">
                                        <label for="<?php echo $module_name; ?>" class="font-medium text-gray-900"><?php echo $mod_title; ?></label>
                                        <p class="text-gray-500"><?php echo $mod_desc; ?></p>
                                    </div>
                                </div>
                                <?php
                            }

                            ?>

                     
                            
                        </div>
                    </fieldset>
               
                </div>
                
            <?php 

                $submit_name = 'woomio_save_settings_modules';
                include( PLUGIN_ROOT . 'admin/partials/components/form-button.php' ); 

                ?>
            </div>
           
        </form>

        <div class="bg-gray-100 p-6 border-b border-gray-900/10 pb-6">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Webhook Logs</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">Show's the latest webhook transactions. Find the entire log in /wp-uploads/woomio/</p>

                <div class="mt-10 space-y-10">
                   
                <?php

                    $upload_dir = wp_upload_dir();
                    $log_file = $upload_dir['basedir'] . '/woomio-logs/webhook_logs.txt';

                    // Read the file into an array
                    $lines = file($log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

                    // Get the last 100 lines
                    $last_100_lines = array_slice($lines, -100);

                    // Convert special characters to HTML entities and join the lines
                    $output = implode("\n", array_map('htmlspecialchars', $last_100_lines));

                    // Return the content wrapped in a <pre> tag
                    $logs = '<textarea readonly style="width: 100%; height:250px; overflow-y: scroll;">' . $output . '</textarea>';

                    echo $logs;

                ?>
               
                </div>
       
        </div>

        <?php include_once( 'components/admin-footer.php' ); ?>




</div>