<?php

namespace EasyScss\Public;

use EasyScss\Shared\EasyScssGlobals;
use EasyScss\Shared\EasyScssUtils;

class EasyScssPublic {

	private $plugin_name;
	private $version;
	private EasyScssUtils $utils;
	static string $scope = 'public';

	public function __construct() {

		$this->version = EasyScssGlobals::$plugin_version;
		$this->plugin_name = EasyScssGlobals::$plugin_name;

		$this->utils = new EasyScssUtils();

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 */
	public function enqueue_styles() {

		global $plugin_page;
		if (!$plugin_page) return;

		$cssFilesPath = $this->utils->get_assets_build_files(self::$scope, 'css');
		if (!empty($cssFilesPath)) {
			foreach ($cssFilesPath as $cssFile) {
				$cssFileURI = EASY_SCSS_FOLDER_URL . '/dist/' . self::$scope . '/' . basename($cssFile);
				$normalized_filename = $this->utils->normalize_filename($cssFile);
				wp_enqueue_style( $this->plugin_name .  '-public-' . $normalized_filename, $cssFileURI, array(), $this->version);
			}
		}

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 */
	public function enqueue_scripts() {

		global $plugin_page;
		if (!$plugin_page) return;

		$jsFilesPath = $this->utils->get_assets_build_files(self::$scope, 'js');
		if (!empty($jsFilesPath)) {
			foreach ($jsFilesPath as $jsFile) {
				$jsFileURI = EASY_SCSS_FOLDER_URL . '/dist/' . self::$scope . '/' . basename($jsFile);
				$normalized_filename = $this->utils->normalize_filename($jsFile);
				wp_enqueue_script( $this->plugin_name . '-public-' . $normalized_filename, $jsFileURI, array(), $this->version, true);
			}
		}

	}

}
