<?php


namespace WPEasyLibrary\WordPress;


use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class WPE_ShortcodeTable
{
    private $_twig;
    private $_shortcodesArray;

    public function __construct($shortcodesArray)
    {
        $loader = new FilesystemLoader(__DIR__ . '/View');
        $twig = new Environment($loader, [
            'cache' => __DIR__ . '/_templateCache'
        ]);

        $this->_shortcodesArray = $shortcodesArray;
        $this->_twig = $twig;
    }

    public function render()
    {
        $this->_twig->render('shortcodeTable.twig', $this->_shortcodesArray);
    }
}