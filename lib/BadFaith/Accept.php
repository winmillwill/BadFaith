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
 * BadFaith container for Accept parsing
 *
 * @package BadFaith
 * @author William Milton <wa.milton@gmail.com>
 */
class Accept extends AcceptLike
{

    public $pref;
    public $params;
    public $q;
    public $type;
    public $subtype;

    /**
     * @param string|null $headerIsh the raw text of the header string or null
     */
    function __construct($headerIsh = null)
    {
        parent::__construct($headerIsh);
        $this->init();
    }

    /**
     * Initializes attributes unique to this subclass.
     */
    function init()
    {
        $parts = explode('/', $this->pref, 2);
        if (!array_key_exists(1, $parts)) {
            $parts[1] = null;
        }
        $this->type = $parts[0];
        $this->subtype = $parts[1];
    }
}
