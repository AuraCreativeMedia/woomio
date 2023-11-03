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

    $forms = new Woomio_Forms();

    $forms->woomio_handle_tools_submit();

    /* Return notice on successful submission */ 
    if (isset($_GET['wm-settings-updated']) && $_GET['wm-settings-updated'] == 'true') {
        echo '<div class="notice notice-success is-dismissible"><p>Function run successfully!</p></div>';
    }


    $modules = $this->get_all_modules();
  

?>

<div class="wrap woomio-admin-page">

    <?php 
        include_once( 'components/admin-header.php' );
    ?>

    
    <p class="woomio-pg-desc mb-6 bg-white p-6 text-lg leading-6 text-gray-600">I recommend running the rebuild functions on first installing the plugin as they will ensure Growmio gets the correct values. However be warned that they are intensive operations on larger websites so be patient.</p>
    <?php 


      // Utility_Functions

    Woomio_Admin::showModulesHTML('tools');
    
    

?>  
 
    <?php include_once( 'components/admin-footer.php' ); ?>
</div>