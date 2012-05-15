<?php

namespace BadFaith;

interface AcceptItemInterface
{
    /**
     * @return string
     */
    function getPref();

    /**
     * @return double
     */
    function getQuality();
}
