<?php

/*
 * This file is part of the BadFaith project.
 *
 * (c) William Milton <wa.milton@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

spl_autoload_register(function ($class) {
    if (0 === strpos(ltrim($class, '/'), 'BadFaith')) {
        if (file_exists($file = __DIR__.'/../lib/BadFaith'.substr(str_replace('\\', '/', $class), strlen('BadFaith')).'.php')) {
            require_once $file;
        }
        elseif (file_exists($file = __DIR__.'/../tests/BadFaith'.substr(str_replace('\\', '/', $class), strlen('BadFaith')).'.php')) {
            require_once $file;
        }
    }
});

if (file_exists($loader = __DIR__.'/../vendor/autoload.php')) {
    require_once $loader;
}
