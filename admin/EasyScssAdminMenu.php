<?php

namespace EasyScss\Admin;

use EasyScss\Shared\EasyScssGlobals;

class EasyScssAdminMenu {

	public function __construct() {}

	public function init_admin_menu() {
        add_menu_page(
            'Easy Scss',
            'Easy Scss',
            'manage_options',
            'easy-scss',
            array($this, 'easy_scss_edit')
        );
        add_submenu_page(
            'easy-scss',
            'WP Easy Scss - Edit',
            __('Edit Scss', 'easy-scss'),
            'manage_options',
            'easy-scss',
            array($this, 'easy_scss_edit')
        );
        add_submenu_page(
            'easy-scss',
            'Easy Scss - Settings',
            __('Settings', 'easy-scss'),
            'manage_options',
            'easy-scss-settings',
            array($this, 'easy_scss_settings')
        );
    }

    public function easy_scss_edit() {
        $this->get_page('edit-file');
    }

    public function easy_scss_settings() {
        $this->get_page('settings');
    }

    private function get_page($page) {
        ob_start();
        $page_file = 'easy-scss-admin-' . $page . '.php';
        require_once('partials/' . $page_file);
        $page = ob_get_contents();
        ob_clean();
        echo $page;
    }

}
