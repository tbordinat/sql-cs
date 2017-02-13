<?php

namespace SqlCs\Console\Command;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Stopwatch\Stopwatch;

use SqlCs\Runner\Runner;

final class SqlCsCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('check')
            ->setDefinition(
                array(
                    new InputOption('config', '', InputOption::VALUE_REQUIRED, 'Configuration file'),
                    new InputOption('dbms', '', InputOption::VALUE_REQUIRED, 'Database management system'),
                    new InputOption('file', '', InputOption::VALUE_REQUIRED, '.sql file to check'),
                    new InputOption('tablename_maxlength', '', InputOption::VALUE_REQUIRED, 'Maxlength for table names'),
                )
            )
            ->setDescription('Checks a SQL database creation statement.')
            ->setHelp('Aide TODO')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $verbosity = $output->getVerbosity();

        $resolver = new OptionsResolver();
        $resolver->setDefaults(array(
            'ansi' => '', 'help' => '', 'no-ansi' => '', 'no-interaction' => '', 'quiet' => '', 'verbose' => '', 'version' => '', // There is a better way...
            'config' => null,
            'dbms' => 'default',
            'file' => null,
            'tablename_maxlength' => null
        ));

        $options = $resolver->resolve($input->getOptions());

        $runner = new Runner($options);
        $runner->check();

        return 0;
    }
}
