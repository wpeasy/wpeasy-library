<?php


namespace WPEasyLibrary\Interfaces;


interface IWordPressModule
{
    static function activate();
    static function deactivate();
    static function upgrade();
}