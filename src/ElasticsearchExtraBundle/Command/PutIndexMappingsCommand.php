<?php

namespace GBProd\ElasticsearchExtraBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to put index mappings
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class PutIndexMappingsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('elasticsearch:index:put_mappings')
            ->setDescription('Put index mappings from configuration')
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
            ->addArgument(
                'type_id',
                InputArgument::REQUIRED,
                'Which type ?'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $clientId = $input->getArgument('client_id');
        $indexId  = $input->getArgument('index_id');
        $typeId   = $input->getArgument('type_id');

        $output->writeln(sprintf(
            '<info>Put type <comment>%s</comment> mappings for index <comment>%s</comment> client <comment>%s</comment>...</info>',
            $typeId,
            $indexId,
            $clientId
        ));

        $handler = $this
            ->getContainer()
            ->get('gbprod.elasticsearch_extra.put_index_mappings_handler')
        ;

        $handler->handle($clientId, $indexId, $typeId);

        $output->writeln('done');
    }
}
