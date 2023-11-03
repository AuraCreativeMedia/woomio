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


    $forms = new Woomio_Forms();

    /* Handle submit */ 
    $forms->save_tpt_module_settings();

    /* Return notice on successful submission */ 
    if (isset($_GET['wm-settings-updated']) && $_GET['wm-settings-updated'] == 'true') {
        echo '<div class="notice notice-success is-dismissible"><p>Function run successfully!</p></div>';
    }


?>

<div class="wrap woomio-admin-page">

    <?php 
        include_once( 'components/admin-header.php' );
    ?>

        <?php 

            // Utility_Functions
            Woomio_Admin::showModulesHTML('settings');

    ?>
 

    <?php include_once( 'components/admin-footer.php' ); ?>
</div>