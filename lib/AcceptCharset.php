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
 * BadFaith container for Accept-Charset parsing
 *
 * @package BadFaith
 * @author William Milton <wa.milton@gmail.com>
 */
class AcceptCharset extends AcceptLike
{

    public $pref;
    public $params;
    public $q;
    public $charset;

    /**
     * @param string|null $headerStr the raw test of the header string or null
     */
    function __construct($headerStr = null)
    {
        parent::__construct($headerStr);
        $this->init();
    }

    /**
     * @param array $properties the array this method always gets
     * @return Accept the object version of that array
     */
    static function __set_state(array $properties)
    {
        parent::__set_state($properties);
        $accept = new AcceptCharset();
        foreach ($properties as $key=>$prop) {
            if (!property_exists('AcceptLike', $key)) {
                if (property_exists($accept, $key)) {
                    $accept->$key = $prop;
                }
            }
        }
        return $accept;
    }

    /**
     * Initializes attributes unique to this subclass.
     */
    function init()
    {
        $this->charset = $this->pref;
    }
}
