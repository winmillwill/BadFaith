<?php

namespace BadFaith;

class Variant
{
    private $identifier;
    private $accepts;

    /**
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param array $dictOfDicts a dictionary of the dictionaries used to init
     * constituent types.
     */
    public function __construct(array $dictOfDicts)
    {
        foreach ($dictOfDicts as $dimension => $dict) {
            if ($dimension == 'mime') {
                $class = get_class(new Accept());
            } else {
                $class = '\\' . __NAMESPACE__ . '\\' . (class_exists(ucwords($dimension)) ? ucwords($dimension) : 'AcceptLike');
            }
            $this->accepts[$dimension] = new $class($dict);
        }
    }

    /**
     * @param string|null $dimension
     * @return mixed
     */
    public function getAccepts($dimension = NULL)
    {
        if ($dimension) {
            return $this->accepts[$dimension];
        }

        return $this->accepts;
    }
}
