<?php

namespace BadFaith\Tests;

use Variant;

class VariantTest extends \PHPUnit_Framework_TestCase
{
    public function setUp() {
        $this->variantDict = array(
            'language' => array(
                'pref' => 'en',
                'q' => '1.0',
            ),
            'mime' => array(
                'pref' => 'text/html',
                'q' => '0.4',
            ),
        );
    }

    public function testInit() {
        $var = new \BadFaith\Variant($this->variantDict);
    }
}
