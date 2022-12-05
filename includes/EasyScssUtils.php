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

}
