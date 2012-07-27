<?php

namespace BadFaith;

class Variant
{
    private $identifier;
    private $accepts;

    /**
     * @return mixed
     */
    function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param array $dict a dictionary of the dictionaries used to init
     * constituent types.
     */
    function __construct($dictOfDicts)
    {
        foreach ($dictOfDicts as $dimension => $dict) {
            if ($dimension == 'mime') {
                $class = '\\' . __NAMESPACE__ . '\\' . 'Accept';
            }
            else {
                $class = '\\' . __NAMESPACE__ . '\\' . (class_exists(ucwords($dimension)) ? ucwords($dimension) : 'AcceptLike');
            }
            $this->accepts[$dimension] = new $class($dict);
        }
    }

    /**
     * @return array
     */
    function getAccepts($dimension = NULL)
    {
        if ($dimension)
        {
            return $this->accepts[$dimension];
        }
        return $this->accepts;
    }
}
