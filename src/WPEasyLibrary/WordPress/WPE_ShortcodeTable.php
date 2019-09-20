<?php


namespace WPEasyLibrary\WordPress;


use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class WPE_ShortcodeTable
{
    private $_twig;
    private $_shortcodesArray;

    const TEMPLATE_DIR = __DIR__ . '/_templateCache';

    public function __construct($shortcodesArray, $cache = false)
    {
        $loader = new FilesystemLoader(__DIR__ . '/View');
        $cacheDir = $cache === false ? false : self::TEMPLATE_DIR;
        $twig = new Environment($loader, [
            'cache' => $cacheDir
        ]);

        $this->_shortcodesArray = $shortcodesArray;
        $this->_twig = $twig;
    }

    static function clearCache()
    {
        foreach (glob(self::TEMPLATE_DIR) as $file) {
            if (is_dir($file)) {
                self::clearCache("$file/*");
                self::clearCache($file);
            } else {
                unlink($file);
            }
        }
    }


    public function render()
    {
        echo $this->_twig->render('shortcodeTable.twig', ['shortcodes' => $this->_shortcodesArray]);
    }
}