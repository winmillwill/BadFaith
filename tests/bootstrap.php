<?php

/*
 * This file is part of the BadFaith project.
 *
 * (c) William Milton <wa.milton@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

error_reporting(E_ALL);

$loader = require __DIR__.'/../vendor/autoload.php';
$loader->add('BadFaith\Tests', __DIR__);
Ladybug\Loader::loadHelpers();
