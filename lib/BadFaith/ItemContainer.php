<?php

namespace BadFaith;

class ItemContainer implements \IteratorAggregate, \Countable
{
    protected $items = array();

    public function insert(AcceptItemInterface $item) {
        foreach ($this->items as $i => $check) {
            if (1 === $this->compare($item, $check)) {
                array_splice($this->items, $i, 0, array($item));
                return;
            }
        }

        array_push($this->items, $item);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->items);
    }

    public function top()
    {
        reset($this->items);

        return current($this->items);
    }

    /**
     * @param AcceptItemInterface
     * @param AcceptItemInterface
     */
    protected function compare($value1, $value2)
    {
        return ((double)$value1->getQuality() <= (double)$value2->getQuality() ? -1 : 1);
    }
}