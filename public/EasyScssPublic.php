<?php

namespace EasyScss\Public;

use EasyScss\Shared\EasyScssGlobals;

class EasyScssPublic {

	private $plugin_name;
	private $version;


	public function __construct() {

		$this->version = EasyScssGlobals::$plugin_version;
		$this->plugin_name = EasyScssGlobals::$plugin_name;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/easy-scss-public.css', array(), $this->version);

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/easy-scss-public.js', array( 'jquery' ), $this->version);

	}

}
