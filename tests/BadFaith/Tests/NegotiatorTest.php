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

namespace BadFaith\Tests;

use Negotiator;

/**
 * Negotiator Test
 *
 * @package BadFaith
 * @author    William Milton
 */
class NegotiatorTest extends \PHPUnit_Framework_TestCase
{
    protected $server;

    public function setUp()
    {
        $this->server = array (
            'HTTP_ACCEPT' => 'text/html;level=2;q=0.7,text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'HTTP_ACCEPT_ENCODING' => 'gzip,deflate,sdch',
            'HTTP_ACCEPT_LANGUAGE' => 'en-US,en;q=0.8',
            'HTTP_ACCEPT_CHARSET' => 'ISO-8859-1,utf-8;q=0.7,*;q=0.3',
        );
        $this->headers = array (
            'accept' => 'text/html;level=2;q=0.7,text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'accept_encoding' => 'gzip,deflate,sdch',
            'accept_language' => 'en-US,en;q=0.8',
            'accept_charset' => 'ISO-8859-1,utf-8;q=0.7,*;q=0.3',
        );
        $this->media_ranges = array(
            'text/html;level=2;q=0.7',
            'text/html',
            'application/xhtml+xml',
            'application/xml;q=0.9',
            '*/*;q=0.8',
        );
    }

    public function testInitAcceptsWithNothing()
    {
        $_SERVER = $this->server;
        $negotiator = new \BadFaith\Negotiator();

        $this->assertEquals(
            $_SERVER['HTTP_ACCEPT'],
            $negotiator->headerLiterals['accept']
        );
    }

    public function testInitAcceptsWithArg()
    {
        $headers = $this->headers;
        $negotiator = new \BadFaith\Negotiator($headers);

        $this->assertEquals(
            $headers['accept'],
            $negotiator->headerLiterals['accept']
        );
    }
}
