<?php

namespace Core\src;
class Autoloader
{
    public static function registrate()
    {
        $autoloader = function (string $class) {


            $path = './../' . str_replace('\\', '/', $class) . '.php';

            if (file_exists($path)) {
                require_once $path;
                return true;
            }

            return false;
        };

        spl_autoload_register($autoloader);

    }
}