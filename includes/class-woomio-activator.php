<?php

/**
 * Fired during plugin activation
 *
 * @link       https://digitalzest.co.uk
 * @since      1.0.0
 *
 * @package    Woomio
 * @subpackage Woomio/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Woomio
 * @subpackage Woomio/includes
 * @author     Digital Zest <hello@digitalzest.co.uk>
 */
class Woomio_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		global $wpdb;
			$table_name = $wpdb->prefix . 'woomio_customer_top_types';
			$charset_collate = $wpdb->get_charset_collate();
			
			$sql = "CREATE TABLE $table_name (
				ID bigint(20) NOT NULL AUTO_INCREMENT,
				Product_ID bigint(20) NOT NULL,
				User_ID bigint(20) NOT NULL,
				Amount_Sold mediumint(9) NOT NULL,
				UNIQUE (User_ID, Product_ID),
				PRIMARY KEY  (ID)
			) $charset_collate;";
			
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );

	}

}
