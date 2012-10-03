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
 * BadFaith content negotiation class.
 *
 * @package BadFaith
 * @author William Milton
 */
class Negotiator
{
    public $headerLiterals = array();

    public $headerLists = array();

    public $variants = array();

    protected static $keys = array(
        'accept'          => '',
        'accept_charset'  => 'utf-8',
        'accept_encoding' => '',
        'accept_language' => 'en-US',
    );

    /**
     * Constructor that initializes with given dict or $_SERVER.
     * @param array $headers  a dict of header strings
     * @param array $variants What the service can provide
     */
    public function __construct($headers = array(), $variants = array())
    {
        if (empty($headers)) {
            $this->headersFromGlobals();
        } else {
            $this->headersFromArg($headers);
        }

        $this->variantsFromArg($variants);
    }

    /**
     * Sets properties using the $_SERVER array
     */
    public function headersFromGlobals()
    {
        $headers = array();

        foreach (static::$keys as $key => $default) {
            $headers[$key] = (isset($_SERVER['HTTP_' . strtoupper($key)])) ? $_SERVER['HTTP_' . strtoupper($key)] : $default;
        }

        $this->headersFromArg($headers);
    }

    /**
     * Sets properties using the constructor arg.
     */
    public function headersFromArg(array $arg)
    {
        foreach (static::$keys as $key => $default) {
            $value = array_key_exists($key, $arg) ? $arg[$key] : '';

            $this->headerLiterals[$key] = $value;

            $class = $this->listClass($key);
            $this->headerLists[$key] = new $class($value);
        }
    }

    public function variantsFromArg(array $arg)
    {
        $this->variants = new VariantList($arg);
    }

    /**
     * Maps the type of header field to the list class that will hold its
     * entries.
     * @param $type string the key of the literals array
     * @return the namespaced classname
     */
    public function listClass($type)
    {
        switch (strtoupper($type)) {

            case 'ACCEPT':
                $class = 'AcceptList';
                break;
            case 'ACCEPT_CHARSET':
                $class = 'AcceptCharsetList';
                break;
            case 'ACCEPT_ENCODING':
                $class = 'AcceptEncodingList';
                break;
            case 'ACCEPT_LANGUAGE':
                $class = 'AcceptLanguageList';
                break;
        }

        return __NAMESPACE__ . '\\' . $class;
    }

    public function apacheNegotiate()
    {

    }
}
