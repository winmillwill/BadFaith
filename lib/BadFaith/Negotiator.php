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
 * BadFaith content negotiation class.
 *
 * @package BadFaith
 * @author William Milton
 */
class Negotiator {
  public $accept;
  public $accept_charset;
  public $accept_encoding;
  public $accept_language;

  function __construct($headers = array()) {
    if (empty($headers)) {
      $this->headers_from_globals();
    }
    else {
      $this->headers_from_arg($headers);
    }
  }

  /**
   * Sets properties using the $_SERVER array
   */
  function headers_from_globals() {
    $keys = array(
      'accept',
      'accept_charset',
      'accept_encoding',
      'accept_language',
    );
    foreach ($keys as $key) {
      $this->$key = $_SERVER['HTTP_' . strtoupper($key)];
    }
  }

  /**
   * Sets properties using the constructor arg.
   */
  function headers_from_arg($arg) {
    foreach ($arg as $key => $value) {
      if (property_exists('Negotiator', $key)) {
        $this->$key = $value;
      }
    }
  }

  /**
   * Splits the Accept header media ranges
   */
  function accept_range_split($header) {
    $media_ranges = explode(',', $header);
    return $media_ranges;
  }

  /**
   * Splits the Accept header media range types
   */
  function accept_range_type_split() {
    $type_subtype = explode('/', $this->accept);
    return $media_ranges;
  }

  /**
   * Splits the Accept header media range parameters
   */
  function accept_range_parameter_split($range) {
    $parameters = explode(';', $this->accept);
    $type = array_pop($parameters);
    return array('type' => $type, 'parameters' => $parameters);
  }

  /**
   * Parses the Accept header media ranges
   */
  function accept_range_parse() {
    $media_ranges = $this->accept_range_split($this->accept);
    $type_with_params = $this->accept_range_parameter_split($range);
    $parsed_ranges = array();
    return $parsed_ranges;
  }
}
