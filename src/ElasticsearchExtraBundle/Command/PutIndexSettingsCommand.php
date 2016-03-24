<?php

namespace GBProd\ElasticsearchExtraBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to put index settings
 * 
 * @author gbprod <contact@gb-prod.fr>
 */
class PutIndexSettingsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('elasticsearch:index:put_settings')
            ->setDescription('Put index settings from configuration')
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
            '<info>Put index <comment>%s</comment> settings for client <comment>%s</comment>...</info>',
            $indexId,
            $clientId
        ));
        
        $handler = $this
            ->getContainer()
            ->get('gbprod.elasticsearch_extra.put_index_settings_handler')
        ;
        
        $handler->handle($clientId, $indexId);
        
        $output->writeln('done');
    }
}