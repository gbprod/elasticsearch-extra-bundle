<?php

namespace GBProd\ElasticsearchExtraBundle\Command;

use Elasticsearch\Client;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Command tha use elasticsearch client from container
 *
 * @author gbprod <contact@gb-prod.fr>
 */
abstract class ElasticsearchAwareCommand extends ContainerAwareCommand
{
    /**
     * Get elasticsearch client from his name
     *
     * @param string $clientName
     *
     * @return Client
     */
    public function getClient($clientName)
    {
        $clientServiceName = sprintf(
            'm6web_elasticsearch.client.%s',
            $clientName
        );

        $client = $this->getContainer()
            ->get(
                $clientServiceName,
                ContainerInterface::NULL_ON_INVALID_REFERENCE
            )
        ;

        if (!$client) {
            throw new \InvalidArgumentException(sprintf(
                'No client "%s" found',
                $clientName
            ));
        }

        return $client;
    }
}
