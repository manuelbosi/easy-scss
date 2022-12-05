<?php

namespace EasyScss\Shared;

class EasyScssActivator {

    /**
     * Fired during plugin activation.
     */
	public static function activate() {
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		(new EasyScssActivator())->create_table_easy_scss_options();
	}

	// wp_eas_options table
	private function create_table_easy_scss_options() {
		global $wpdb;
		$table = $wpdb->prefix . EasyScssGlobals::$table_prefix . EasyScssGlobals::$options_table ;
		$query = "
            CREATE TABLE IF NOT EXISTS `".$table."` (
              `id` int NOT NULL AUTO_INCREMENT,
              `meta_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
              `meta_value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci
        ";
		dbDelta($query);
	}

}
