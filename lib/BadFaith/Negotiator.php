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

    /**
     * Constructor that initializes with given dict or $_SERVER.
     * @param array $headers a dict of header strings
     */
    function __construct($headers = array())
    {
        if (empty($headers)) {
            $this->headersFromGlobals();
        } else {
            $this->headersFromArg($headers);
        }
        $this->initLists();
    }

    /**
     * Sets properties using the $_SERVER array
     */
    function headersFromGlobals()
    {
        $keys = array(
            'accept',
            'accept_charset',
            'accept_encoding',
            'accept_language',
        );
        foreach ($keys as $key) {
            $this->headerLiterals[$key] = $_SERVER['HTTP_' . strtoupper($key)];
        }
    }

    /**
     * Sets properties using the constructor arg.
     */
    function headersFromArg(array $arg)
    {
        foreach ($arg as $key => $value) {
            $this->headerLiterals[$key] = $value;
        }
    }

    /**
     * Initializes the list objects for the different Accept* headers.
     */
    function initLists()
    {
        foreach ($this->headerLiterals as $key => $value) {
            $class = $this->listClass($key);
            $this->headerLists[$key] = new $class($value);
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
}
