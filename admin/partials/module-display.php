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
    $this->woomio_handle_module_settings_submit();

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

    <h1>Settings - Modules</h1>

    <?php
    
        if ($options['run_order_total']) : ?>

        <?php endif; ?>

        <?php 

        if ($options['top_product_types']) : ?>

            <h2>Top Product Types</h2>

            <form method="post" action="">

            <?php wp_nonce_field('woomio_module_tpt_settings', 'woomio_settings_nonce_modules'); ?>

                <table class="form-table">
                
                <tr valign="top">
                    <th scope="row">Product Taxonomies</th>
                    <td>
                        <table>
                        <?php
                            // Load the available taxonomies
                            $taxonomies = get_taxonomies([], 'names');

                            $woomio_tpt_options = get_option('_woomio_mod_tpt');
                            $tpt_chosen_taxons = isset($woomio_tpt_options) ? $woomio_tpt_options : '';

                            $select_fields = ['product_cat', 'type', 'occasion', 'range'];

                            foreach ($select_fields as $select) : ?>
                                <tr>
                                    <td>
                                        <label for="woomio_tpt_options[<?php echo $select; ?>]"><?php echo $select; ?></label>
                                    </td>
                                    <td>
                                        <select name="woomio_tpt_options[<?php echo $select; ?>]">

                                        <option value="" <?php selected($tpt_chosen_taxon, '', true); ?>>None/Unmapped</option> 

                                        <?php 

                                            $tpt_chosen_taxon = isset($woomio_tpt_options[$select]) ? $woomio_tpt_options[$select] : '';
                                        // $tpt_current_taxon = get_option('woomio_tpt_options["' . $select . '"]');

                                            foreach ($taxonomies as $taxonomy) {
                                                
                                                echo '<option value="' . $taxonomy . '"' . selected($tpt_chosen_taxon, $taxonomy) . '>' . $taxonomy . '</option>';
                                            } 

                                        ?>
                                        </select>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </table>
                    </td>
                </tr>

                </table>

                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <button type="submit" name="woomio_module_tpt_settings" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                </div>

            </form>

        <?php endif; ?>


</div>