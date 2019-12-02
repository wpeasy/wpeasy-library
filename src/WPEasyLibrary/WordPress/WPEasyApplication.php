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

    static $callingPluginConfig;

    /*
     * Initialised by the first plugin using this library
     */
    static function init($callingPluginConfig)
    {
        if (self::$_init) return;
        self::$_init = true;

        self::$callingPluginConfig = $callingPluginConfig;

        self::registerLoadedPlugin($callingPluginConfig['pluginName'], $callingPluginConfig['pluginDescription'], $callingPluginConfig['modules']);


        add_action('admin_menu', [__CLASS__, 'adminMenuTop'], 1);
        add_action('admin_enqueue_scripts', [__CLASS__, 'admin_enqueue_scripts'], 1);
        add_action('wp_enqueue_scripts', [__CLASS__, 'wp_enqueue_scripts'], 1);

        $loader = new FilesystemLoader(__DIR__ . '/View');
        $twig = new Environment($loader, [
            'cache' => false
        ]);
        $twig->addGlobal('wpeExtUrl', self::WPEASY_EXTERNAL_URL);

        self::$twig = $twig;
    }

    static function registerLoadedPlugin($name, $description, $modules = [])
    {
        self::$loadedPlugins[$name] = [
            'description' => $description,
            'modules' => $modules
        ];
    }

    static function admin_enqueue_scripts()
    {
        $callingPluginURL = self::$callingPluginConfig['pluginURL'];
        $assetsURL = $callingPluginURL . 'vendor/alanblair/wpeasy-library/assets/';
        wp_register_style( 'wpe-lib-common', $assetsURL . 'css/wpe-lib-common.style.css');
        wp_register_style( 'wpe-lib-admin', $assetsURL . 'css/wpe-lib-admin.style.css', ['wpe-lib-common']);

        wp_register_script('wpe-lib-vendor', $assetsURL . 'js/wpe-lib-vendor.bundle.js');
        wp_register_script('wpe-lib-common', $assetsURL . 'js/wpe-lib-common.bundle.js', ['wpe-lib-vendor']);
        wp_register_script('wpe-lib-admin', $assetsURL . 'js/wpe-lib-admin.bundle.js', ['jquery','wpe-lib-common']);

        wp_register_script('popper', '//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js', ['jquery'], false, true);
        wp_enqueue_script('bootstrap', '//stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', ['popper'], false, true );

    }

    static function wp_enqueue_scripts()
    {
        $callingPluginURL = self::$callingPluginConfig['pluginURL'];
        $assetsURL = $callingPluginURL . 'vendor/alanblair/wpeasy-library/assets/';
        wp_register_style( 'wpe-lib-common', $assetsURL . 'css/wpe-lib-common.style.css');
        wp_register_style( 'wpe-lib-frontend', $assetsURL . 'css/wpe-lib-frontend.style.css', ['wpe-lib-common']);
        wp_enqueue_style('wpe-lib-frontend');

        wp_register_script('wpe-lib-vendor', $assetsURL . 'js/wpe-lib-vendor.bundle.js');
        wp_register_script('wpe-lib-common', $assetsURL . 'js/wpe-lib-common.bundle.js', ['wpe-lib-vendor']);
        wp_register_script('wpe-lib-frontend', $assetsURL . 'js/wpe-lib-frontend.bundle.js', ['jquery','wpe-lib-common']);
        wp_enqueue_script('wpe-lib-frontend',[], false, true);
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
        /*
         * Enqueued here because only needed if the admin page is displayed.
         */
        wp_enqueue_script( 'wpe-lib-admin');
        wp_enqueue_style('wpe-lib-admin');

        echo self::$twig->render(
                'commonMenuView.twig',
                [
                    'plugins' => self::$loadedPlugins
                ]
        );
    }
}