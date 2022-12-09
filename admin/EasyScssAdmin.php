<?php

namespace EasyScss\Admin;

use EasyScss\Shared\EasyScssGlobals;
use EasyScss\Shared\EasyScssOption;
use EasyScss\Shared\EasyScssOptionsManager;
use EasyScss\Shared\EasyScssUtils;

class EasyScssAdmin {

	private string $plugin_name;
	private string $version;
	private EasyScssOptionsManager $options_manager;
	private EasyScssUtils $utils;
	static string $scope = 'admin';

	public function __construct() {

        $this->version = EasyScssGlobals::$plugin_version;
        $this->plugin_name = EasyScssGlobals::$plugin_name;

		$this->options_manager = new EasyScssOptionsManager();
		$this->utils = new EasyScssUtils();

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @return void
	 */
	public function enqueue_styles(): void {

		global $plugin_page;
		if (!$plugin_page) return;

		$cssFilesPath = $this->utils->get_assets_build_files(self::$scope, 'css');
		if (!empty($cssFilesPath)) {
			foreach ($cssFilesPath as $cssFile) {
				$cssFileURI = EASY_SCSS_FOLDER_URL . '/dist/' . self::$scope . '/' . basename($cssFile);
				$normalized_filename = $this->utils->normalize_filename($cssFile);
				wp_enqueue_style( $this->plugin_name .  '-admin-' . $normalized_filename, $cssFileURI, array(), $this->version);
			}
		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @return void
	 */
	public function enqueue_scripts(): void {

		global $plugin_page;
		if (!$plugin_page) return;

		$jsFilesPath = $this->utils->get_assets_build_files(self::$scope, 'js');
		if (!empty($jsFilesPath)) {
			foreach ($jsFilesPath as $jsFile) {
				$jsFileURI = EASY_SCSS_FOLDER_URL . '/dist/' . self::$scope . '/' . basename($jsFile);
				$normalized_filename = $this->utils->normalize_filename($jsFile);
				wp_enqueue_script( $this->plugin_name . '-admin-' . $normalized_filename, $jsFileURI, array('jquery'), $this->version, true);
			}
		}

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
