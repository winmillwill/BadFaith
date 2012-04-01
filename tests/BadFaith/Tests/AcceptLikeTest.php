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

use AcceptLike;

class AcceptLikeTest extends \PHPUnit_Framework_TestCase {

  public function setUp() {
    $this->headers = array (
      'accept' => 'text/html;level=2;q=0.7,text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
      'accept_encoding' => 'gzip,deflate,sdch',
      'accept_language' => 'en-US,en;q=0.8',
      'accept_charset' => 'ISO-8859-1,utf-8;q=0.7,*;q=0.3',
    );
    $this->accept_split = array(
      'text/html;level=2;q=0.7',
      'text/html',
      'application/xhtml+xml',
      'application/xml;q=0.9',
      '*/*;q=0.8'
    );
    $this->accept_pref_param_split = array(
      'pref' => 'text/html',
      'params' => 'level=2;q=0.7',
    );
    $this->accept_pref_param_split_moreso = array(
      'pref' => 'text/html',
      'params' => array('level=2', 'q=0.7'),
    );
    $this->accept_pref_params_parsed = array(
      'pref' => 'text/html',
      'params' => array('level' => '2', 'q' => '0.7'),
    );
  }

  public function testPrefParamSplit() {
    $pref_param_list_str = $this->accept_split[0];
    $this->assertEquals($this->accept_pref_param_split, \BadFaith\AcceptLike::pref_param_split($pref_param_list_str));
  }

  public function testParamListParse() {
    $param_list_str = $this->accept_pref_param_split['params'];
    $expected = $this->accept_pref_params_parsed['params'];
    $this->assertEquals($expected, \BadFaith\AcceptLike::param_list_parse($param_list_str));
  }

  public function testInitWithStr() {
    $accept = $this->accept_split[0];
    $expected = new \BadFaith\AcceptLike();
    $expected->pref = 'text/html';
    $expected->params = array('level' => 2);
    $expected->q = 0.7;
    $expected = \Badfaith\AcceptLike::__set_state(array(
      'pref' => 'text/html',
      'params' => array('level' => 2),
      'q' => 0.7,
    ));
    $this->assertEquals($expected, new \Badfaith\AcceptLike($accept));
  }
}
