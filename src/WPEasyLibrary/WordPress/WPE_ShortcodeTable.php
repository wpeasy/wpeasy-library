<?php


namespace WPEasyLibrary\WordPress;


use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class WPE_ShortcodeTable
{
    private $_twig;
    private $_shortcodesArray;

    public function __construct($shortcodesArray, $cache = false)
    {
        $loader = new FilesystemLoader(__DIR__ . '/View');
        $cacheDir = $cache === false ? false : WPEasyApplication::TEMPLATE_DIR;
        $twig = new Environment($loader, [
            'cache' => $cacheDir
        ]);

        $this->_shortcodesArray = $shortcodesArray;
        $this->_twig = $twig;
    }

    public function render()
    {
        echo $this->_twig->render(
            'shortcodeTable.twig',
            [
                'shortcodes' => $this->_shortcodesArray
            ]
        );
    }
}