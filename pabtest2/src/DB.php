<?php
/**
 * Created by PhpStorm.
 * User: Alexey Teterin
 * Email: 7018407@gmail.com
 * Date: 22.12.2015
 * Time: 21:20
 */

namespace errogaht\PABTest2;


use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Yaml\Parser;

class DB
{
    private static $conn;
    private static $conf;

    /**
     * Protected constructor to prevent creating a new instance of the
     * *Singleton* via the `new` operator from outside of this class.
     */
    protected function __construct()
    {
    }

    public static function setConfig($conf)
    {
        self::$conf = $conf;
    }

    /**
     * @return \Doctrine\DBAL\Connection
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Exception
     */
    public static function getConn()
    {
        $doctrineConfig = new Configuration();
        if (!empty(self::$conf)) {
            static::$conn = DriverManager::getConnection(self::$conf, $doctrineConfig);
        } else {
            throw new \Exception('Configuration problems');
        }

        return static::$conn;
    }

    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * Private unserialize method to prevent unserializing of the *Singleton*
     * instance.
     *
     * @return void
     */
    private function __wakeup()
    {
    }

}
