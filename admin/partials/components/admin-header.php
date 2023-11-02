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
 * @subpackage Woomio/admin/partials/components
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="woomio-admin-header">
    
    <nav class="bg-gray-800">
        <div class="max-w-7xl px-2 sm:px-6 lg:px-8 pt-4 pb-2">
            <div class="relative flex h-16 items-center justify-between">
            
            <div class="flex flex-1 items-center justify-center sm:justify-start sm:items-end">
                <div class="flex flex-shrink-0 items-center">
                <img  class="h-16 w-auto" src="<?php echo PLUGIN_ROOT_URI . 'admin/assets/img/woomio-logo.png'; ?>" alt="WooMio - WooCommerce to Growmio" width="150"/>
                </div>
                <div class="hidden sm:ml-12 sm:block pb-2">
                <div class="flex space-x-4">
                    <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                    <a href="<?php echo admin_url('admin.php?page=woomio-options'); ?>" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-base font-medium">Dashboard</a>
                    <a href="<?php echo admin_url('admin.php?page=woomio-tools'); ?>" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-base font-medium">Tools</a>
                    <a href="<?php echo admin_url('admin.php?page=woomio-settings'); ?>" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-base font-medium">Module Settings</a>
                </div>
                </div>
            </div>
            
            </div>
        </div>


        </nav>

</div>

<div class="inner-wrap px-8 pt-6">

    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900"><?php echo $page_title; ?></h1>

    <div class="woomio-content px-12 py-8 bg-gray-200">

