<?php

namespace BadFaith;

class ItemContainer extends \SplHeap {
    /**
     * @param AcceptItemInterface
     * @param AcceptItemInterface
     */
    public function compare($value1, $value2)
    {
        // Can't do typehinting because of E_STRICT 
        if (!($value1 instanceof AcceptItemInterface) || !($value2 instanceof AcceptItemInterface)) {
            throw new \UnexpectedValueException("Comparables must implement AcceptItemInterface");
        }

        return ((double)$value1->getQuality() < (double)$value2->getQuality() ? -1 : 1);
    }
}