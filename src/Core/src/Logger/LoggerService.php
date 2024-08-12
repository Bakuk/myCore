<?php

namespace Core\src\Logger;

use Throwable;

class LoggerService
{
    private const STORAGE_PATH = './../Storage/Logs/';
    public static function error(Throwable $exception)
    {
        error_reporting(E_ALL);
        ini_set('error_log', self::STORAGE_PATH . 'error.txt');
        error_log($exception, 0);
    }

    public static function info()
    {
        ob_start();
        // Вывод заголовков браузера.
        foreach (getallheaders() as $name => $value) {
            echo "$name: $value\n";
        }

        $log = date('Y-m-d H:i:s') . PHP_EOL . ob_get_clean() . PHP_EOL;
        file_put_contents( self::STORAGE_PATH . 'info.txt', $log, FILE_APPEND);
    }
}