<?php

namespace GBProd\ElasticsearchExtraBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to delete index
 * 
 * @author gbprod <contact@gb-prod.fr>
 */
class DeleteIndexCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('elasticsearch:index:delete')
            ->setDescription('delete index from configuration')
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
            ->addOption(
                'force', 
                null, 
                InputOption::VALUE_NONE, 
                'Set this parameter to execute this action'
            )
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
        $clientId = $input->getArgument('client_id');
        $indexId  = $input->getArgument('index_id');
        
        $output->writeln(sprintf(
            '<info>Deleting index "%s" for client "%s"...</info>',
            $indexId,
            $clientId
        ));
        
        $handler = $this
            ->getContainer()
            ->get('gbprod.elasticsearch_extra.delete_index_handler')
        ;
        
        $handler->handle($clientId, $indexId);
        
        $output->writeln('<info>done</info>');
    }
    
    private function displayWarningMassage(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<error>ATTENTION</error>');
        $output->writeln(sprintf(
            '<info>Would drop the index <comment>%s</comment> on client <comment>%s</comment>.</info>', 
            $input->getArgument('client_id'),
            $input->getArgument('index_id')
        ));
        $output->writeln('Run the operation with --force to execute');
    }
}