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

namespace BadFaith;
/**
 * BadFaith container for Accept-* parsing
 *
 * @package BadFaith
 * @author William Milton
 */
class Accept extends AcceptLike {

  public $pref;
  public $params;
  public $q;
  public $type;
  public $subtype;

  function __construct($header_str = NULL) {
    parent::__construct($header_str);
    $this->init();
  }

  static function __set_state(array $properties) {
    parent::__set_state($properties);
    $accept = new Accept();
    foreach ($properties as $key=>$prop) {
      if (!property_exists('AcceptLike', $key)) {
        if (property_exists($accept, $key)) {
          $accept->$key = $prop;
        }
      }
    }
    return $accept_like;
  }

  function init() {
    $parts = explode('/', $this->pref, 2);
    if (!array_key_exists(1, $parts)) {
      $parts[1] = NULL;
    }
    $this->type = $parts[0];
    $this->subtype = $parts[1];
  }
}
