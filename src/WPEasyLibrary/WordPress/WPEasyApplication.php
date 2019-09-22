<?php

/*
 * Sets up a root Application to be used by all WPEasy plugins
 *
 * Common styles and scripts will be found in https://www.wpeasy.net/ext
 * @See the WPEasy project
 *
 */

namespace WPEasyLibrary\WordPress;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class WPEasyApplication
{
    /**@var $twig Environment */
    public static $twig;

    private static $_init;
    static $loadedPlugins = [];
    const TEMPLATE_DIR = __DIR__ . '/_templateCache';
    const MENU_PAGE_TITLE = 'WPEasy Options';
    const MENU_PAGE_NAME = 'WPEasy';
    const MENU_PAGE_PERMISSIONS = 'manage_options';
    const MENU_PAGE_SLUG = 'wpe-menu';
    const WPEASY_EXTERNAL_URL = 'https://www.wpeasy.net/ext/';
    const ADMIN_SCRIPT_SLUG = 'wpe-admin';
    const COMMON_SCRIPT_SLUG = 'wpe-common';
    const FRONTEND_SCRIPT_SLUG = 'wpe-frontend';

    static function init()
    {
        if (self::$_init) return;
        self::$_init = true;
        add_action('admin_menu', [__CLASS__, 'adminMenuTop'], 1);
        add_action('admin_enqueue_scripts', [__CLASS__, 'admin_enqueue_scripts'], 1);
        add_action('wp_enqueue_scripts', [__CLASS__, 'wp_enqueue_scripts'], 1);

        $loader = new FilesystemLoader(__DIR__ . '/View');
        $twig = new Environment($loader, [
            'cache' => false
        ]);

        self::$twig = $twig;
    }

    static function registerLoadedPlugin($name, $description, $modules)
    {
        self::$loadedPlugins[$name] = [
            'description' => $description,
            'modules' => $modules
        ];
    }

    static function admin_enqueue_scripts()
    {
        wp_register_style(self::ADMIN_SCRIPT_SLUG, self::WPEASY_EXTERNAL_URL . 'assets/css/wpe-admin.style.css');

        wp_register_script(self::COMMON_SCRIPT_SLUG, self::WPEASY_EXTERNAL_URL . 'assets/js/common.bundle.js', ['jquery']);

        wp_register_script(
            self::ADMIN_SCRIPT_SLUG,
            self::WPEASY_EXTERNAL_URL . 'assets/js/wpe-admin.bundle.js',
            [self::COMMON_SCRIPT_SLUG],
            false,
            true
        );
    }

    static function wp_enqueue_scripts()
    {
        wp_register_style(self::FRONTEND_SCRIPT_SLUG, self::WPEASY_EXTERNAL_URL . 'assets/css/wpe-front.style.css');

        wp_register_script(self::COMMON_SCRIPT_SLUG, self::WPEASY_EXTERNAL_URL . 'assets/js/common.bundle.js', ['jquery']);

        wp_register_script(
            self::FRONTEND_SCRIPT_SLUG,
            self::WPEASY_EXTERNAL_URL . 'assets/js/wpe-front.bundle.js',
            [self::COMMON_SCRIPT_SLUG],
            false,
            true
        );
    }

    /**
     * Add the top level menu
     * Note: Adding submenus should use a priority of 11 to work properly.
     */
    static function adminMenuTop()
    {
        global $admin_page_hooks;
        if (!empty($admin_page_hooks[self::MENU_PAGE_SLUG])) return;

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
        self::$twig->render(
                'commonMenuView.twig',
                ['plugins' => self::$loadedPlugins]
        );
    }
}