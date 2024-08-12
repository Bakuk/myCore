<?php

namespace bakuk\Core\Model;

use PDO;

class Model
{
    protected static PDO $pdo;

    public static function init(PDO $pdo): void
    {
        static::$pdo = $pdo;
    }
    public static function getPDO(): PDO
    {
        return self::$pdo;
    }

}