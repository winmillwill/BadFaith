<?php

namespace BadFaith;

interface AcceptItemInterface
{
    /**
     * @return string
     */
    public function getPref();

    /**
     * @return double
     */
    public function getQuality();
}
