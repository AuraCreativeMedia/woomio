<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://digitalzest.co.uk
 * @since      1.0.0
 *
 * @package    Woomio
 * @subpackage Woomio/admin
 */


 trait Utility_Functions {

	use Module_Config;

    
	public function is_order_new_and_notes( $order_id ) {
		// Get order notes
		$notes = wc_get_order_notes( array( 'order_id' => $order_id ) );
	
		// Loop through the notes and check if any of them indicate a status change to completed
		foreach ( $notes as $note ) {
			// Check if the note indicates that the order status was changed to completed
			if ( strpos( strtolower( $note->content ), 'status changed to completed' ) !== false ) {
				// The order was set to completed in the past
				return false;
			}
		}
	
		// The order has never been set to completed in the past
		return true;
	}

	

	public static function get_all_modules(){

		// Fetch the module metadata from the trait
		$module_meta = self::get_module_meta();

		// Construct the default array using the 'slug' property from the metadata
		$default_modules = array();
		foreach ($module_meta as $meta) {
			$default_modules[$meta['slug']] = false;
		}
	
		// Get the saved module settings from the database
		$saved_modules = get_option('_woomio_module_settings', array());
	
		// Merge the saved settings with the default settings
		$modules = array_merge($default_modules, $saved_modules);
	
		return $modules;

	}

	
	// public static function get_enabled_modules(){

	// 	$modules = get_option('_woomio_module_settings', array(
	// 		'order_totals' => false,
    //     	'top_product_types' => false,
    //     	'next_order_date' => false,
	// 		'new_release_products' => false,
    // 	));

	// 	return $modules;

	// }



	public static function check_module_status(string $module){
		
		$modules = Woomio_Admin::get_all_modules();

		if($modules[$module] == true) : return true; endif;

		return false;

	}

	public static function showModulesHTML(string $type){
		// Specify the path to the modules directory
		$modulesPath = plugin_dir_path( __FILE__ ) . '../modules/';
		
		// Check if the directory exists
		if(is_dir($modulesPath)){
			
			// Get all folders in the /modules/ directory
			$folders = new DirectoryIterator($modulesPath);
			
			foreach($folders as $folder){
				// Check if the pointer is a directory and not pointing to current or upper level directory
				if($folder->isDir() && !$folder->isDot()){
					
					// Use the folder name as the module name
					$moduleName = $folder->getFilename();
					
					// Construct path to *_settings.php file within each module folder
					$typeFilePath = $modulesPath . $moduleName . '/' . $moduleName . '_' . $type . '.php';
					
					// Check if the module is enabled and the *_settings.php file exists, then include it
					if(self::check_module_status($moduleName) && file_exists($typeFilePath)){
						include($typeFilePath);
					}
				}
			}
		}
	}
	
	
 }