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


?>

<div class="wrap woomio-admin-page">

    <?php 
        include_once( 'components/admin-header.php' );
    ?>

    <h1>Settings - Modules</h1>

    <?php 

        // Utility_Functions

        Woomio_Admin::showModulesHTML('settings');

?>
 



</div>