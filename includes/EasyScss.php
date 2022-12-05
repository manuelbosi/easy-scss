<?php

namespace EasyScss\Shared;

use EasyScss\Admin\EasyScssAdmin;
use EasyScss\Admin\EasyScssAdminMenu;
use EasyScss\Public\EasyScssPublic;

class EasyScss {

	/**
	 * The loader responsible for maintaining and registering all hooks that power the plugin.
	 */
	protected $loader;

	protected $plugin_name;
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 */
	public function __construct() {

        $this->version = EasyScssGlobals::$plugin_version;
		$this->plugin_name = EasyScssGlobals::$plugin_name;

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - EasyScssLoader. Orchestrates the hooks of the plugin.
	 * - EasyScssLocale. Defines internationalization functionality.
	 * - EasyScssAdmin. Defines all hooks for the admin area.
	 * - EasyScssPublic. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 */
	private function load_dependencies() {

		$this->loader = new EasyScssLoader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 */
	private function set_locale() {

		$plugin_i18n = new EasyScssLocale();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all the hooks related to the admin area functionality of the plugin.
	 */
	private function define_admin_hooks() {

		$plugin_admin = new EasyScssAdmin();

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_post_save_options', $plugin_admin, 'handle_save_options' );
		$this->loader->add_filter('removable_query_args', $plugin_admin, 'add_removable_args');

        $plugin_admin_menu = new EasyScssAdminMenu();
        $this->loader->add_action( 'admin_menu', $plugin_admin_menu, 'init_admin_menu' );

    }

	/**
	 * Register all the hooks related to the public-facing functionality of the plugin.
	 */
	private function define_public_hooks() {

		$plugin_public = new EasyScssPublic();

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all the hooks with WordPress.
	 */
	public function run() {
		$this->loader->run();
	}

}
