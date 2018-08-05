<?php
/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      2.0.0
 * @package    Kk_I_Like_It
 * @subpackage Kk_I_Like_It/includes
 * @author     Krzysztof Furtak <krzysztof.furtak@gmail.com>
 */
class Kk_I_Like_It_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    2.0.0
	 */
	public static function activate() {
		global $wpdb;
		$table_name_new = $wpdb->prefix . "kklikeuser";
		$table_name_new_a = $wpdb->prefix . "kklike";
		
		$sql = "CREATE TABLE " . $table_name_new . " (
				`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
				`idwpuser` INT NULL DEFAULT '0',
				`idlike` INT NOT NULL ,
				`ip` VARCHAR( 255 ) NOT NULL DEFAULT '0',
				`date` DATETIME NOT NULL
				) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		

		$sql = "CREATE TABLE " . $table_name_new_a . " (
				`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
				`idwp` INT NOT NULL ,
				`rating` INT NOT NULL DEFAULT '0',
				`type` VARCHAR( 255 ) NOT NULL
				) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		
		$to = 'krzysztof.furtak@gmail.com';
		$subject = 'Aktywacja KKILikeIt';
		$message = 'Plugin v2! Strona: ' . $_SERVER['SERVER_NAME'];
		
		wp_mail( $to, $subject, $message );
	}

}
