<?php

/**
 * This file is part of BadFaith.
 *
 * Copyright (c) 2012 William Milton
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * Badfaith tests for Accept-* parsing
 *
 * @package BadFaith
 * @author William Milton
 */

namespace BadFaith\Tests;

use BadFaith\AcceptLike;

class AcceptLikeTest extends \PHPUnit_Framework_TestCase
{

    public function setUp() {
        $this->headers = array (
            'accept' => 'text/html;level=2;q=0.7,text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'acceptEncoding' => 'gzip,deflate,sdch',
            'acceptLanguage' => 'en-US,en;q=0.8',
            'acceptCharset' => 'ISO-8859-1,utf-8;q=0.7,*;q=0.3',
        );
        $this->acceptSplit = array(
            'text/html;level=2;q=0.7',
            'text/html',
            'application/xhtml+xml',
            'application/xml;q=0.9',
            '*/*;q=0.8'
        );
        $this->acceptPrefParamSplit = array(
            'pref' => 'text/html',
            'params' => 'level=2;q=0.7',
        );
        $this->acceptPrefParamSplitMoreso = array(
            'pref' => 'text/html',
            'params' => array('level=2', 'q=0.7'),
        );
        $this->acceptPrefParamsParsed = array(
            'pref' => 'text/html',
            'params' => array('level' => '2', 'q' => '0.7'),
        );
    }

    public function testPrefParamSplit() {
        $prefParamListStr = $this->acceptSplit[0];
        $this->assertEquals($this->acceptPrefParamSplit, AcceptLike::prefParamSplit($prefParamListStr));
    }

    public function testParamListParse() {
        $paramListStr = $this->acceptPrefParamSplit['params'];
        $expected = $this->acceptPrefParamsParsed['params'];
        $this->assertEquals($expected, AcceptLike::paramListParse($paramListStr));
    }

    public function testInitWithStr() {
        $accept = $this->acceptSplit[0];
        $expected = new AcceptLike();
        $expected->pref = 'text/html';
        $expected->params = array('level' => 2);
        $expected->q = 0.7;
        $expected = AcceptLike::__set_state(
            array(
                'pref' => 'text/html',
                'params' => array('level' => 2),
                'q' => 0.7,
            )
        );
        $this->assertEquals($expected, new AcceptLike($accept));
    }
}
