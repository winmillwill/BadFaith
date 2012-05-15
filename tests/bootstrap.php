<?php

/*
 * This file is part of the BadFaith project.
 *
 * (c) William Milton <wa.milton@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

    $loaderFile = dirname(__DIR__) . '/vendor/autoload.php';

    if (file_exists($loaderFile)) {
        $loader = require_once $loaderFile;

        $loader->add('BadFaith\\Tests', __DIR__);
        $loader->register();
    } else {
        require_once __DIR__.'/../lib/BadFaith/AcceptItemInterface.php';
        require_once __DIR__.'/../lib/BadFaith/ItemContainer.php';
        require_once __DIR__.'/../lib/BadFaith/Negotiator.php';
        require_once __DIR__.'/../lib/BadFaith/AcceptLike.php';
        require_once __DIR__.'/../lib/BadFaith/AcceptLikeList.php';
        require_once __DIR__.'/../lib/BadFaith/Accept.php';
        require_once __DIR__.'/../lib/BadFaith/AcceptCharset.php';
        require_once __DIR__.'/../lib/BadFaith/AcceptEncoding.php';
        require_once __DIR__.'/../lib/BadFaith/AcceptLanguage.php';
        require_once __DIR__.'/../lib/BadFaith/AcceptList.php';
        require_once __DIR__.'/../lib/BadFaith/AcceptCharsetList.php';
        require_once __DIR__.'/../lib/BadFaith/AcceptEncodingList.php';
        require_once __DIR__.'/../lib/BadFaith/AcceptLanguageList.php';
    }