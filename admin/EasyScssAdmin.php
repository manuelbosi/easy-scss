<?php

namespace EasyScss\Admin;

use EasyScss\Shared\EasyScssGlobals;
use EasyScss\Shared\EasyScssOption;
use EasyScss\Shared\EasyScssOptionsManager;

class EasyScssAdmin {

	private string $plugin_name;
	private string $version;
	private EasyScssOptionsManager $options_manager;

	public function __construct() {

        $this->version = EasyScssGlobals::$plugin_version;
        $this->plugin_name = EasyScssGlobals::$plugin_name;

		$this->options_manager = new EasyScssOptionsManager();

	}

	/**
	 * Register the stylesheets for the admin area.
	 */
	public function enqueue_styles(): void {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/easy-scss-admin.css', array(), $this->version);

	}

	/**
	 * Register the JavaScript for the admin area.
	 */
	public function enqueue_scripts(): void {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/easy-scss-admin.js', array( 'jquery' ), $this->version);

	}

	public function handle_save_options(): void {

		$options = $_POST['options'];
		$is_token_valid = wp_verify_nonce($_POST['save_options_nonce'], 'save_options');
		$redirect_to_url = $_POST['_wp_http_referer'];

		if (!isset($options) || !$is_token_valid) {
			wp_safe_redirect(esc_url_raw(add_query_arg( 'error', true, $redirect_to_url )));
		}

		$entrypoint = $options[EasyScssGlobals::$option_entrypoint_key];
		$destination = $options[EasyScssGlobals::$option_destination_key];

		$has_empty_values = $this->is_parameter_empty($entrypoint) || $this->is_parameter_empty($destination);
		if ($has_empty_values) {
			wp_safe_redirect(esc_url_raw(add_query_arg( 'empty_values', true, $redirect_to_url )));
			return;
		}

		// Check if option is already saved and update
		// Otherwise create option row in database
		foreach ($options as $option_key => $option_value) {
			$saved_option = $this->options_manager->get($option_key);
			$saved_option_id = $saved_option?->id;
			$option_class = new EasyScssOption(array(
				'id' => $saved_option_id,
				'meta_key' => $option_key,
				'meta_value' => $option_value
			));

			if ($saved_option) {
				$this->options_manager->update($option_class);
			} else {
				$this->options_manager->create($option_class);
			}
		}

		wp_safe_redirect(esc_url_raw(add_query_arg( 'saved', true, $redirect_to_url )));
	}

	public function add_removable_args($args) {
		$args[] = 'empty_values';
		return $args;
	}

	/**
	 * Check if passed parameter is empty
	 *
	 * @param string $parameter_key
	 *
	 * @return bool
	 */
	private function is_parameter_empty(string $parameter_key): bool {
		return empty($parameter_key) || strlen(trim($parameter_key)) === 0;
	}

}
