<?php

namespace BadFaith;

class VariantList implements \IteratorAggregate, \Countable
{
    protected $items = array();
    protected $prefHashes = array('mime' => array(), 'language' => array(), 'encoding' => array(), 'charset' => array());

    /**
     * {@inheritdoc}
     */
    public function __construct(array $variants = array())
    {
      $this->init($variants);
    }

    public function init(array $variants)
    {
        $this->items = new \ArrayIterator();
        foreach ($variants as $key => $variant)
        {
            $this->set($key, $variant);
        }
    }

    public function set($key, $variant)
    {
        $this->items[$key] = new Variant($variant);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return $this->items;
    }

    public function getPrefHash($dimension)
    {
        if (empty($this->prefHashes[$dimension])) {
            foreach ($this->items as $key => $variant) {
                $this->prefHashes[$dimension][$variant->getAccepts($dimension)->getPref()][$key] = $variant;
            }
        }
        return $this->prefHashes[$dimension];
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->items);
    }
}
