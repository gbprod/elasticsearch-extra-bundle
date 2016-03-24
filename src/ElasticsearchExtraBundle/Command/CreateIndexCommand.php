<?php

namespace GBProd\ElasticsearchExtraBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to create index
 * 
 * @author gbprod <contact@gb-prod.fr>
 */
class CreateIndexCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('elasticsearch:create_index')
            ->setDescription('Create index from configuration')
            ->addArgument(
                'client_id',
                InputArgument::REQUIRED,
                'Which client ?'
            )
            ->addArgument(
                'index_id',
                InputArgument::REQUIRED,
                'Which index ?'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $clientId = $input->getArgument('client_id');
        $indexId  = $input->getArgument('index_id');
        
        $output->writeln(sprintf(
            'Creating index "%s" for client "%s"...',
            $indexId,
            $clientId
        ));
        
        $handler = $this
            ->getContainer()
            ->get('gbprod.elasticsearch_extra.create_index_handler')
        ;
        
        $handler->handle($clientId, $indexId);
        
        $output->writeln("Done");
    }
}