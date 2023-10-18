
<h2>Next Order Date</h2>
<p>When a user makes an order, the selected date below will act as a reminder to say 'The last time you ordered was X days ago'.</p>
<form method="post" action="">

<?php wp_nonce_field('woomio_module_next_date_settings', 'woomio_settings_nonce_modules'); ?>

    <table class="form-table w-full">
    
        <tr class="border-b border-gray-200">
        <td class="py-2 px-4">
            <select name="woomio_next_date_options" class="form-select mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <?php 
                $woomio_next_date_options = get_option('_woomio_mod_next_date'); 
                $next_date_chosen = isset($woomio_next_date_options) ? $woomio_next_date_options : '';

                // Define an associative array of the values and labels for the options
                $options = [
                    "2" => "2 days",
                    "7" => "1 week",
                    "14" => "2 weeks",
                    "21" => "3 weeks",
                    "30" => "1 month",
                    "60" => "2 months",
                    "90" => "3 months",
                    "180" => "6 months",
                    "365" => "1 year"
                ];

                // Loop through the options and output the <option> tags
                foreach ($options as $value => $label) : ?>
                    <option value="<?php echo $value; ?>" <?php selected($next_date_chosen, $value); ?>>
                        <?php echo $label; ?>
                    </option>
                <?php endforeach; ?>
            </select>

        </td>
        </tr>

    </table>

    <?php
        $submit_name = 'woomio_module_next_date_settings';
        //var_dump(PLUGIN_ROOT . 'admin/partials/components/form-button.php');
        include( PLUGIN_ROOT . 'admin/partials/components/form-button.php' ); 
    ?>

</form>


