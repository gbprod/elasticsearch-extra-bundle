<?php

namespace GBProd\ElasticsearchExtraBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to delete index
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class DeleteIndexCommand extends ElasticsearchAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('elasticsearch:index:delete')
            ->setDescription('delete index from configuration')
            ->addArgument('index', InputArgument::REQUIRED, 'Which index ?')
            ->addOption('force', null, InputOption::VALUE_NONE, 'Set this parameter to execute this action')
            ->addOption('client', null, InputOption::VALUE_REQUIRED, 'Client to use (if not default)', 'default')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('force')) {
            $this->deleteIndex($input, $output);
        } else {
            $this->displayWarningMassage($input, $output);
        }
    }

    private function deleteIndex(InputInterface $input, OutputInterface $output)
    {
        $client = $this->getClient($input->getOption('client'));
        $index  = $input->getArgument('index');

        $output->writeln(sprintf(
            '<info>Deleting index <comment>%s</comment> for client <comment>%s</comment>...</info>',
            $index,
            $input->getOption('client')
        ));

        $handler = $this
            ->getContainer()
            ->get('gbprod.elasticsearch_extra.delete_index_handler')
        ;

        $handler->handle($client, $index);

        $output->writeln('done');
    }

    private function displayWarningMassage(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<error>ATTENTION</error>');
        $output->writeln(sprintf(
            '<info>Will delete the index <comment>%s</comment> on client <comment>%s</comment>.</info>',
            $input->getOption('client'),
            $input->getArgument('index')
        ));
        $output->writeln('Run the operation with --force to execute');
    }
}
