<?php

namespace GBProd\Tests\Units\ElasticsearchExtraBundle;

use atoum;

/**
 * Tests for bundle
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class ElasticsearchExtraBundle extends atoum
{
    public function testConstruction()
    {
        $this
            ->if($this->newTestedInstance)
            ->then
                ->object($this->testedInstance)->isTestedInstance()
        ;
    }
}