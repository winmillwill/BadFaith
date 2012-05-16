<?php

namespace BadFaith\Tests;

use BadFaith\AcceptItemInterface;

class ItemStub implements AcceptItemInterface
{
    /**
     * @var string
     */
    public $pref;

    /**
     * @var double
     */
    public $q;

    /**
     * @param string
     * @param int
     */
    public function __construct($pref, $quality)
    {
        $this->pref = $pref;
        $this->q    = $quality;
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
}