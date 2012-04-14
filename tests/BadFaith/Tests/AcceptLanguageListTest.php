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

use AcceptLanguageList;

class AcceptLanguageListTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Sets up our fixtures.
     */
    public function setUp()
    {
        $this->headers = array (
            'accept' => 'text/html;level=2;q=0.7,text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'acceptEncoding' => 'gzip,deflate,sdch',
            'acceptLanguage' => 'en-US,en;q=0.8',
            'acceptCharset' => 'ISO-8859-1,utf-8;q=0.7,*;q=0.3',
        );
        $this->languageSplit = array(
            'en-US',
            'en;q=0.8',
        );
        $this->languageParsed = array(
            \BadFaith\AcceptLanguage::__set_state(
                array(
                    'pref' => 'en-US',
                    'lang' => 'en',
                    'sublang' => 'US',
                    'q' => '1.0',
                    'params' => array(),
                )
            ),
            \BadFaith\AcceptLanguage::__set_state(
                array(
                    'pref' => 'en',
                    'lang' => 'en',
                    'q' => '0.8',
                    'params' => array(),
                )
            ),
        );
    }

    public function testInitWithHeaderString ()
    {
        $expected = $this->languageParsed;
        $encoding = $this->headers['acceptLanguage'];
        $list = new \BadFaith\AcceptLanguageList($encoding);
        $this->assertEquals($expected, $list->items);
    }
}
