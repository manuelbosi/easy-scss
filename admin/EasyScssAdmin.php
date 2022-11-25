<?php

namespace EasyScss\Admin;

use EasyScss\Shared\EasyScssGlobals;

class EasyScssAdmin {

	private $plugin_name;
	private $version;

	public function __construct() {

        $this->version = EasyScssGlobals::$plugin_version;
        $this->plugin_name = EasyScssGlobals::$plugin_name;

	}

	/**
	 * Register the stylesheets for the admin area.
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/easy-scss-admin.css', array(), $this->version);

	}

	/**
	 * Register the JavaScript for the admin area.
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/easy-scss-admin.js', array( 'jquery' ), $this->version);

	}

}
