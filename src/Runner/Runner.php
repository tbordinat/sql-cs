<?php

namespace SqlCs\Runner;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Filesystem\Exception\IOException;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Config\Definition\Processor;

use SqlCs\Configuration\SqlCsConfiguration;

use SqlCs\Parser\Parser;
use SqlCs\Report\Report;
use SqlCs\Report\ReportManager;

final class Runner
{
    /**
     * @var Parser
     */
    private $parser;

    /**
     * array()
     */
    private $options;

    /**
     * @var ReportManager
     */
    private $reportManager;

    /**
     * array()
     */
    private $configuration;

    public function __construct($options)
    {
        if (!file_exists($options['file'])) {
            throw new \Exception($options['file'].' not found.');
        }

        $this->reportManager = new ReportManager();

        $sql = file_get_contents($options['file']);

        if (!is_null($options['config-file'])) {
            if (!file_exists($options['config-file'])) {
                throw new \Exception($options['config-file'].' not found.');
            }
            $config = Yaml::parse(file_get_contents($options['config-file']));
        } else {
            $config = array();
            $this->reportManager->report(new Report(Report::TYPE_WARNING, 'No configuration file set, default configuration will be used.'));
        }

        $processor = new Processor();
        $configuration = new SqlcsConfiguration();
        $processedConfiguration = $processor->processConfiguration(
            $configuration,
            $config
        );

        $this->parser = new Parser($sql);
        $this->options = $options;
        $this->configuration = $processedConfiguration;
    }

    public function getReportManager()
    {
        return $this->reportManager;
    }

    /**
     * @return array
     */
    public function check()
    {
        $result = $this->parser->getResult();
        $this->checkTableName($result->getTableNames());
    }

    public function checkTableName($tablenames)
    {
        foreach ($tablenames as $tablename) {
            if (strlen($tablename) > $this->configuration['table']['maxlength']) {
                $this->reportManager->report(new Report(Report::TYPE_ERROR, 'Table '.$tablename.' violates maxlength constraint'));
            } else {
                $this->reportManager->report(new Report(Report::TYPE_VALID, 'Table '.$tablename.' ok'));
            }
        }
    }
}
