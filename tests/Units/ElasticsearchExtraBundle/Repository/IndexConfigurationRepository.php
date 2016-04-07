<?php

namespace GBProd\Tests\Units\ElasticsearchExtraBundle\Repository;

use atoum;

/**
 * Tests for IndexConfigurationRepository
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class IndexConfigurationRepository extends atoum
{
    public function testGetReturnsConfig()
    {
        $this
            ->given($configs = ['my_index' => ['my' => 'config']])
            ->and($this->newTestedInstance($configs))
            ->if($config = $this->testedInstance->get('my_index'))
            ->then
                ->array($config)
                    ->isEqualTo(['my' => 'config'])
        ;

    }

    public function testGetReturnsNullIfIndexNotExists()
    {
        $this
            ->given($configs = ['my_index' => ['my' => 'config']])
            ->and($this->newTestedInstance($configs))
            ->if($config = $this->testedInstance->get('not_a_index'))
            ->then
                ->variable($config)
                    ->isNull()
        ;
    }
}
