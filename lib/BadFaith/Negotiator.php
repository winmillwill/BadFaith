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

    static protected $keys = array(
        'accept',
        'accept_charset',
        'accept_encoding',
        'accept_language',
    );

    /**
     * Constructor that initializes with given dict or $_SERVER.
     * @param array $headers a dict of header strings
     * @param array $variants What the service can provide
     */
    function __construct($headers = array(), $variants = array())
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
    function headersFromGlobals()
    {
        $headers = array();

        foreach (static::$keys as $key) {
            $headers[$key] = $_SERVER['HTTP_' . strtoupper($key)];
        }

        $this->headersFromArg($headers);
    }

    /**
     * Sets properties using the constructor arg.
     */
    function headersFromArg(array $arg)
    {
        foreach (static::$keys as $key) {
            $value = array_key_exists($key, $arg) ? $arg[$key] : '';

            $this->headerLiterals[$key] = $value;

            $class = $this->listClass($key);
            $this->headerLists[$key] = new $class($value);
        }
    }

    function variantsFromArg(array $arg)
    {
        foreach ($arg as $key => $val) {
            $class = $this->listClass($key);
            $this->variants[$key] = new $class($val);
        }
    }

    /**
     * Maps the type of header field to the list class that will hold its
     * entries.
     * @param $type string the key of the literals array
     * @return the namespaced classname
     */
    function listClass($type)
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

    /**
     * @param string|null
     * @return string|array
     */
    function getPreferred($type = null)
    {
        if (null === $type) {
            $return = array();
            foreach ($this->headerLists as $name => $list) {
                $return[$name] = $list->getPreferred()->getPref();
            }
        } else {
            $return = $this->headerLists["accept_{$type}"]->getPreferred()->getPref();
        }

        return $return;
    }

    /**
     * @param string
     */
    function getBestVariant($type)
    {
        $lookup = "accept_{$type}";

        if (!isset($this->headerLists[$lookup])) {
            throw new \UnexpectedValueException("{$type} not found");
        }

        foreach ($this->headerLists[$lookup]->items as $item) {
            foreach ($this->variants[$lookup]->items as $varItem) {
                if ($item->getPref() == $varItem->getPref()) {
                    return $item->getPref();
                }
            }
        }

        // If the client and server can't negotiate, return the services preference
        return $this->variants["accept_{$type}"]->getPreferred()->getPref();
    }
}
