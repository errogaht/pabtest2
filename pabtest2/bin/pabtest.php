#!/usr/bin/env php
<?php
/**
 * Created by PhpStorm.
 * User: Alexey Teterin
 * Email: 7018407@gmail.com
 * Date: 23.12.2015
 * Time: 8:20
 */

use errogaht\PABTest2\Console\ListCommand;
use errogaht\PABTest2\Console\ResultCommand;
use errogaht\PABTest2\DB;
use errogaht\PABTest2\PABTest2;
use Symfony\Component\Console\Application;

$files = array(__DIR__ . '/../vendor/autoload.php', __DIR__ . '/../../../autoload.php');
$loader = null;
foreach ($files as $file) {
    if (file_exists($file)) {
        $loader = require $file;
        break;
    }
}
if (!$loader) {
    throw new RuntimeException('vendor/autoload.php could not be found. Did you run `php composer.phar install`?');
}

$config = require_once(__DIR__.'/../config.php');

DB::setConfig($config['db'] ?: '');

$application = new Application();
$application->add(new ListCommand());
$application->add(new ResultCommand());
$application->run();