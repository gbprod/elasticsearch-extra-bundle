<?php

namespace GBProd\ElasticsearchExtraBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to put index mappings
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class PutIndexMappingsCommand extends ElasticsearchAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('elasticsearch:index:put_mappings')
            ->setDescription('Put index mappings from configuration')
            ->addArgument('index', InputArgument::REQUIRED, 'Which index ?')
            ->addArgument('type', InputArgument::REQUIRED, 'Which type ?')
            ->addOption('client', null, InputOption::VALUE_REQUIRED, 'Client to use (if not default)', 'default')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = $this->getClient($input->getOption('client'));
        $index  = $input->getArgument('index');
        $type   = $input->getArgument('type');

        $output->writeln(sprintf(
            '<info>Put type <comment>%s</comment> mappings for index <comment>%s</comment> ' .
            'client <comment>%s</comment>...</info>',
            $type,
            $index,
            $input->getOption('client')
        ));

        $handler = $this
            ->getContainer()
            ->get('gbprod.elasticsearch_extra.put_index_mappings_handler')
        ;

        $handler->handle($client, $index, $type);

        $output->writeln('done');
    }
}
