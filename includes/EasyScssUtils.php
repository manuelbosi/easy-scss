<?php

namespace EasyScss\Shared;

class EasyScssUtils {

	private $base_notice_class = "notice is-dismissible";
	private $available_notices = array('success', 'error', 'info', 'warning');

	public function __construct() {}

	/**
	 * Print an admin notice
	 *
	 * @param string $type
	 * @param string $message
	 *
	 * @return void
	 */
	public function admin_notice(string $type, string $message): void {
		if (!in_array($type, $this->available_notices)) {
			return;
		}
		printf('<div class="%s notice-%s"><p>%s</p></div>', $this->base_notice_class, $type, __($message));
	}

	/**
	 * Get filename without esbuild hash
	 *
	 * @param string $file
	 *
	 * @return string
	 */
	public function normalize_filename( string $file ): string {
		$normalized_filename = array_filter(preg_split('/\.([a-zA-Z0-9])+/', basename($file)))[0];
		return $normalized_filename;
	}

	/**
	 * Get assets build folder path.
	 *
	 * Supported scopes are: admin | public
	 * Supported ext are: css | js
	 *
	 * @param string $scope
	 * @param string $ext
	 *
	 * @return array
	 */
	public function get_assets_build_files( string $scope, string $ext): array {
		return glob( EASY_SCSS_FOLDER . '/dist/' . $scope . "/*.[a-zA-Z0-9]*.$ext" );
	}

}
