<?php

namespace GBProd\ElasticsearchExtraBundle\Handler;

use Elasticsearch\Client;

/**
 * Handler to delete index command
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class DeleteIndexHandler
{
    /**
     * Handle index deletion command
     *
     * @param Client $client
     * @param string $index
     */
    public function handle(Client $client, $index)
    {
        $client
            ->indices()
            ->delete([
                'index' => $index,
            ])
        ;
    }
}
