<?php

/*
 * Sets up a root Application to be used by all WPEasy plugins
 *
 * Common styles and scripts will be found in https://www.wpeasy.net/ext
 * @See the WPEasy project
 *
 */

namespace WPEasyLibrary\WordPress;

class WPEasyApplication
{
    private static $_init;

    const MENU_PAGE_TITLE = 'WPEasy Options';
    const MENU_PAGE_NAME = 'WPEasy';
    const MENU_PAGE_PERMISSIONS = 'manage_options';
    const MENU_PAGE_SLUG = 'wpe-menu';
    const WPEASY_EXTERNAL_URL = 'https://www.wpeasy.net/ext/';
    const ADMIN_SCRIPT_SLUG = 'wpe-admin';

    static function init()
    {
        if(self::$_init) return;
        self::$_init = true;
        add_action('admin_menu', [__CLASS__, 'adminMenuTop']);
        add_action('admin_enqueue_scripts', [__CLASS__, 'admin_enqueue_scripts'], 1);
    }

    static function admin_enqueue_scripts()
    {
        wp_register_style(self::ADMIN_SCRIPT_SLUG , self::WPEASY_EXTERNAL_URL . 'assets/css/wpe-admin.style.css');
        wp_register_script(self::ADMIN_SCRIPT_SLUG, self::WPEASY_EXTERNAL_URL . 'assets/js/wpe-admin.bundle.js',['jquery'], false, true );
    }

    /**
     * Add the top level menu
     * Note: Adding submenus shoudl use a priority of 11 rto work properly.
     */
    static function adminMenuTop()
    {
        global $admin_page_hooks;
        if(!empty($admin_page_hooks[self::MENU_PAGE_SLUG])) return;

        add_menu_page(
            self::MENU_PAGE_TITLE,
            self::MENU_PAGE_NAME,
            self::MENU_PAGE_PERMISSIONS,
            self::MENU_PAGE_SLUG,
            [__CLASS__, 'menuPageOutput'],
            self::WPEASY_EXTERNAL_URL . 'img/trans-wpeasy-icon.png'
        );
    }

    /**
     * Print out a basic page for the root menu
     */
    static function menuPageOutput()
    {
        ?>
        <div class="wrap">
            <h1>WPEasy functions</h1>
            <h2>Please select sub menu items</h2>
        </div>
        <?php
    }
}