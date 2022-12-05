<?php

namespace EasyScss\Shared;

use mysqli_result;
use wpdb;

class EasyScssOptionsManager {

	private wpdb $wpdb;
	private string $table_name;

	public function __construct()
	{
		global $wpdb;
		$this->wpdb = $wpdb;
		$this->table_name = $this->wpdb->prefix . EasyScssGlobals::$table_prefix . EasyScssGlobals::$options_table;
	}

	/**
	 * Get plugin option by name from options table
	 *
	 * @param string $option_key
	 *
	 * @return EasyScssOption|null
	 */
	public function get(string $option_key): ?EasyScssOption {
		$option = $this->wpdb->get_row(
			$this->wpdb->prepare('SELECT * FROM '.$this->table_name.' WHERE meta_key = %s', $option_key),
			ARRAY_A
		);
		if ($option) {
			return new EasyScssOption($option);
		}
		return null;
	}

	/**
	 * Create option row in database
	 *
	 * @param $option EasyScssOption
	 *
	 * @return mysqli_result|bool|int|null
	 */
	public function create(EasyScssOption $option): mysqli_result|bool|int|null {
		$query = $this->wpdb->prepare(
			'INSERT INTO '.$this->table_name.' VALUES(NULL, %s, %s)',
			$option->meta_key,
			$option->meta_value,
		);
		return $this->wpdb->query($query);
	}

	/**
	 * Update option row in database
	 *
	 * @param $option EasyScssOption
	 *
	 * @return mysqli_result|bool|int|null
	 */
	public function update(EasyScssOption $option): mysqli_result|bool|int|null {
		$query = $this->wpdb->prepare(
			'UPDATE '.$this->table_name.' SET meta_key=%s, meta_value=%s WHERE id=%d',
			$option->meta_key,
			$option->meta_value,
			$option->id,
		);
		return $this->wpdb->query($query);
	}

}
