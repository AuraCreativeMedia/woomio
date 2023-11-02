

<form method="post" action="">

<?php// wp_nonce_field('woomio_module_next_date_settings', 'woomio_settings_nonce_modules'); ?>

<?php wp_nonce_field('woomio_module_new_release_products_settings', 'woomio_settings_nonce_modules'); ?>

    <table class="form-table w-full">
    
        <tr class="border-b border-gray-200">
        <td class="py-2 px-4">
            <p>Choose a page to show the Newly released products (Web Dev's will need to build the page normally). Marketers you'll need this Page URL to use in your emails.</p>
            <select name="woomio_new_release_products_page" class="form-select mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <?php 

                
                $page_ids = get_all_page_ids();

                $woomio_new_release_products_options = get_option('_woomio_mod_new_release_prod_page'); 
                $new_release_page_chosen = isset($woomio_new_release_products_options) ? $woomio_new_release_products_options : '';

                // Define an associative array of the values and labels for the options
                $options = array();

                foreach ($page_ids as $page_id) {
                    $page = get_post($page_id);
                      // Extracting the slug and title of the page
                    $slug = $page->post_name;
                    $title = $page->post_title;
                    
                    // Adding them to the options array
                    $options[$slug] = $title;
                }

            
                // Loop through the options and output the <option> tags
                foreach ($options as $value => $label) : ?>
                    <option value="<?php echo $value; ?>" <?php selected($new_release_page_chosen, $value); ?>>
                        <?php echo $label; ?>
                    </option>
                <?php endforeach; ?>
            </select>

        </td>
        </tr>
        <tr class="border-b border-gray-200">
            <td class="py-2 px-4">
                <p>Select a day of the week for the CRON to run.</p>
                <select name="woomio_next_date_dow" class="form-select mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <?php 
                $woomio_next_date_dow = get_option('_woomio_mod_new_prod_dow'); 
                $new_prod_dow = isset($woomio_next_date_dow) ? $woomio_next_date_dow : '';

                // Define an associative array of the values and labels for the options
                $options = [
                    "Monday"    => "Monday",
                    "Tuesday"   => "Tuesday",
                    "Wednesday" => "Wednesday",
                    "Thursday"  => "Thursday",
                    "Friday"    => "Friday",
                    "Saturday"  => "Saturday",
                    "Sunday"    => "Sunday"
                ];
                

                // Loop through the options and output the <option> tags
                foreach ($options as $value => $label) : ?>
                    <option value="<?php echo $value; ?>" <?php selected($new_prod_dow, $value); ?>>
                        <?php echo $label; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            </td>
        </tr>

    </table>

    <?php
        $submit_name = 'woomio_module_new_release_products_settings';

        include( PLUGIN_ROOT . 'admin/partials/components/form-button.php' ); 
    ?>

</form>


<hr class="mb-6">