<?php
/**
 * Created by PhpStorm.
 * User: Alexey Teterin
 * Email: 7018407@gmail.com
 * Date: 22.12.2015
 * Time: 20:07
 */

use errogaht\PABTest2\PABTest2;

require 'vendor/autoload.php';
$config = require_once('config.php');

PABTest2::init($config['db'] ?: '');
