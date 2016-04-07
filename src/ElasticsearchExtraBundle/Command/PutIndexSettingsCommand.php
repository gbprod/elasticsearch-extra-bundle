<?php

namespace GBProd\ElasticsearchExtraBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to put index settings
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class PutIndexSettingsCommand extends ElasticsearchAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('elasticsearch:index:put_settings')
            ->setDescription('Put index settings from configuration')
            ->addArgument('index', InputArgument::REQUIRED, 'Which index ?')
            ->addOption('client', null, InputOption::VALUE_REQUIRED, 'Client to use (if not default)', 'default')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = $this->getClient($input->getOption('client'));
        $index  = $input->getArgument('index');

        $output->writeln(sprintf(
            '<info>Put index <comment>%s</comment> settings for client <comment>%s</comment>...</info>',
            $index,
            $input->getOption('client')
        ));

        $handler = $this
            ->getContainer()
            ->get('gbprod.elasticsearch_extra.put_index_settings_handler')
        ;

        $handler->handle($client, $index);

        $output->writeln('done');
    }
}
