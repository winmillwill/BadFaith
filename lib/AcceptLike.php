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
class AcceptLike {

  public $pref;
  public $params;
  public $q;

  function __construct($header_str = NULL) {
    if ($header_str) {
      $this->init_with_str($header_str);
    }
  }

  static function __set_state(array $properties) {
    $accept_like = new AcceptLike();
    foreach ($properties as $key=>$prop) {
      if (property_exists($accept_like, $key)) {
        $accept_like->$key = $prop;
      }
    }
    return $accept_like;
  }

  function init_with_str($header_str) {
    $tuple = self::pref_param_split($header_str);
    $tuple['params'] = self::param_list_parse($tuple['params']);
    $q = $tuple['params']['q'];
    unset($tuple['params']['q']);
    $this->params = $tuple['params'];
    $this->q = $q;
    $this->pref = $tuple['pref'];
  }

  /**
   * Given an Accept* request-header field string, returns an array of
   * preference with parameters strings.
   * @param string $pref_with_params
   * @return array
   */
  public static function pref_split($pref_with_params) {
    $parts = array_filter(explode (',', $pref_with_params));
    $parts = array_map('trim', $parts);
    reset($parts);
    return $parts;
  }

  /**
   * Given an Accept* request-header field preference string, returns an array
   * representing a preference-parameters tuple
   * @see pref_split
   * @param string $pref_param_list_str
   * @return array
   */
  static function pref_param_split($pref_param_list_str) {
    $parts = explode(';', $pref_param_list_str, 2);
    $parts = array_map('trim', $parts);
    if (!array_key_exists(1, $parts)) {
      $parts[1] = '';
    }
    reset($parts);
    return array('pref' => $parts[0], 'params' => $parts[1]);
  }

  /**
   * Given an Accept* request-header field preference parameter list string,
   * returns an array of values keyed by parameter name.
   * @see pref_param_split
   * @param string $param_list_str
   * @return array
   */
  static function param_list_parse($param_list_str) {
    $params_url_style = strtr($param_list_str, ';', '&');
    parse_str($params_url_style, $params);
    if (array_key_exists('q', $params)) {
      (float) $params['q'];
    }
    else {
      $params['q'] = 1.0;
    }
    return $params;
  }
}
