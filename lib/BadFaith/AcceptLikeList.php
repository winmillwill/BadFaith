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
 * @author William Milton <wa.milton@gmail.com>
 */
class AcceptLikeList
{
    /**
     * @var ItemContainer
     */
    public $items;

    const ELEMENT_CLASS = 'AcceptLike';

    /**
     * Calls the appropriate initializer.
     * @param string|null $headerStr
     */
    public function __construct($headerIsh = null)
    {
        if (is_string($headerIsh)) {
            $this->initWithStr($headerIsh);
        } elseif (is_array($headerIsh)) {
           $this->initWithArray($headerIsh);
        }
    }

    /**
     * @return AcceptItemInterface
     */
    public function getPreferred()
    {
        return $this->items->top();
    }

    /**
     * Helper for initializing with a string.
     * @param string $headerStr
     */
    public function initWithStr($headerStr)
    {
        $this->items = self::prefParse($headerStr);
    }

    /**
     * Helper for initializing with an array.
     * @param array $headerIshList
     */
    public function initWithArray($headerIshList)
    {
        $this->items = self::initList($headerIshList);
    }

    /**
     * Given an Accept* request-header string, returns an array of AcceptLike
     * objects.
     * @param string $headerStr
     * @return ItemContainer
     */
    public static function prefParse($headerStr)
    {
        $parts = self::prefSplit($headerStr);
        return self::initList($parts);
    }

    /**
     * @return ItemContainer with proper element classes for members.
     */
    static function initList($acceptIshes)
    {
        $items = new ItemContainer();
        $class = self::elementClass();

        foreach ($acceptIshes as $entity) {
            $items->insert(new $class($entity));
        }

        return $items;
    }

    /**
     * Provides the class name of the constituent list elements in overridable
     * static context..
     * @param string $headerStr
     * @return array
     */
    protected static function elementClass()
    {
        $class = static::ELEMENT_CLASS;

        return __NAMESPACE__ . '\\' . $class;
    }

    /**
     * Given an Accept* request-header field string, returns an array of
     * preference with parameters strings.
     * @param string $prefWithParams ',' delimited list of prefs with params
     * @return array
     */
    public static function prefSplit($prefWithParams)
    {
        $parts = array_filter(explode(',', $prefWithParams));
        $parts = array_map('trim', $parts);
        reset($parts);

        return $parts;
    }
}
