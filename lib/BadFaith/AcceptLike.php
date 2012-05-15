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
class AcceptLike implements AcceptItemInterface
{

    public $pref;
    public $params;
    public $q;

    /**
     * @param string|null $headerStr the raw test of the header string or null
     */
    function __construct($headerStr = NULL)
    {
        if ($headerStr) {
            $this->initWithStr($headerStr);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getPref()
    {
        return $this->pref;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuality()
    {
        return $this->q;
    }

    /**
     * @param array $properties the array this method always gets
     */
    static function __set_state(array $properties)
    {
        $acceptLike = new static();
        foreach ($properties as $key=>$prop) {
            if (property_exists($acceptLike, $key)) {
                $acceptLike->$key = $prop;
            }
        }

        return $acceptLike;
    }

    /**
     * @param string $headerStr the raw header text
     */
    function initWithStr($headerStr)
    {
        $tuple = self::prefParamSplit($headerStr);
        $tuple['params'] = self::paramListParse($tuple['params']);
        $q = $tuple['params']['q'];
        unset($tuple['params']['q']);
        $this->params = $tuple['params'];
        $this->q = $q;
        $this->pref = $tuple['pref'];
    }

    /**
     * Given an Accept* request-header field preference string, returns an array
     * representing a preference-parameters tuple
     * @see prefSplit
     * @param string $prefParamListStr pref with ';' delimited list of param=val
     * @return array
     */
    static function prefParamSplit($prefParamListStr)
    {
        $parts = explode(';', $prefParamListStr, 2);
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
     * @see prefParamSplit
     * @param string $paramListStr ';' delimited list of param=val
     * @return array
     */
    static function paramListParse($paramListStr)
    {
        $paramsUrlStyle = strtr($paramListStr, ';', '&');
        parse_str($paramsUrlStyle, $params);
        if (array_key_exists('q', $params)) {
            (float) $params['q'];
        }
        else {
            $params['q'] = 1.0;
        }
        return $params;
    }
}
