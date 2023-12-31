




<form method="post" action="" class="mb-6 woomio-module-form">

<?php wp_nonce_field('woomio_module_tpt_settings', 'woomio_settings_nonce_modules'); ?>
<p class="woomio-module-desc">Please map your website taxonomies to the ones Woomio expects. Or leave empty</p>
<div class="woomio-table">
    <table class="form-table">

    <tr valign="top" class="bg-gray-100">
       
        <td class="p-4">
         
                
                <table class="w-full">
                <?php
                    // Load the available taxonomies
                    $taxonomies = get_taxonomies([], 'names');
                    $woomio_tpt_options = get_option('_woomio_mod_tpt');
                    $tpt_chosen_taxons = isset($woomio_tpt_options) ? $woomio_tpt_options : '';
                    $select_fields = [
                        'Product Categories' => 'product_cat', 
                        'Type' => 'type', 
                        'Occasion' => 'occasion', 
                        'Range' => 'range'
                    ];
                    
                    foreach ($select_fields as $label => $select) : ?>
                        <tr class="border-b border-gray-200">
                            <td class="py-2 px-4">
                                <label for="woomio_tpt_options[<?php echo $select; ?>]" class="text-gray-600 block"><?php echo $label; ?></label>
                            </td>
                            <td class="py-2 px-4">
                                <select name="woomio_tpt_options[<?php echo $select; ?>]" class="form-select mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">

                                <?php 
                                    $tpt_chosen_taxon = isset($woomio_tpt_options[$select]) ? $woomio_tpt_options[$select] : '';
                                    
                                    if(isset($tpt_chosen_taxons)) : 
                                ?>
                                    <option value="" <?php selected($tpt_chosen_taxon, '', true); ?>>None/Unmapped</option> 
                                    
                                    <?php 
                                        foreach ($taxonomies as $taxonomy) {
                                            echo '<option value="' . $taxonomy . '"' . selected($tpt_chosen_taxon, $taxonomy) . '>' . $taxonomy . '</option>';
                                        } 
                                    ?>
                                                    
                                <?php endif; ?>

                                </select>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    
                </table>
         
        </td>
    </tr>

    </table>

    <?php
        $submit_name = 'woomio_module_tpt_settings';
        include( PLUGIN_ROOT . 'admin/partials/components/form-button.php' ); 
    ?>

</div>
           

  

</form>