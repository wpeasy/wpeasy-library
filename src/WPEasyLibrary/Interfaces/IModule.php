<?php


namespace WPEasyLibrary\Interfaces;


interface IModule
{
    static function activate();
    static function deactivate();
    static function upgrade();
}