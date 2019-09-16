<?php


namespace WPEasyLibrary\WordPress;


class WPEasyApplication
{
    private static $_init;

    const MENU_PAGE_TITLE = 'WPEasy Options';
    const MENU_PAGE_NAME = 'WPEasy';
    const MENU_PAGE_PERMISSIONS = 'manage_options';
    const MENU_PAGE_SLUG = 'wpe-menu';
    const WPEASY_EXTERNAL_URL = 'https://www.wpeasy.net/ext/';

    static function init()
    {
        if(self::$_init) return;
        self::$_init = true;
        add_action('admin_menu', [__CLASS__, 'adminMenuTop']);
    }

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