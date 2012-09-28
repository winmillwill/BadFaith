<?php

namespace BadFaith\Tests;

use BadFaith\VariantList;

class VariantListTest extends \PHPUnit_Framework_TestCase
{
    public function setUp() {
        $this->variantDicts = array(
              'var1' => array(
                  'language' => array(
                      'pref' => 'en',
                      'q' => '1.0',
                  ),
                  'mime' => array(
                      'pref' => 'text/html',
                      'q' => '0.4',
                  ),
              ),
              'var2' => array(
                  'language' => array(
                      'pref' => 'de',
                      'q' => '0.5',
                  ),
                  'mime' => array(
                      'pref' => 'text/html',
                      'q' => '0.6',
                  ),
              ),
              'var3' => array(
                  'language' => array(
                      'pref' => 'fr',
                      'q' => '0.4',
                  ),
                  'mime' => array(
                      'pref' => 'ugly/flash',
                      'q' => '0.6',
                  ),
              ),
        );
    }

    public function testInit() {
        $var = new VariantList($this->variantDicts);
    }

    public function testPrefHash() {
        $var = new VariantList($this->variantDicts);
        $mimeHash = $var->getPrefHash('mime');
    }
}
