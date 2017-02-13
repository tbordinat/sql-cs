<?php

namespace SqlCs\Runner;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Filesystem\Exception\IOException;

use SqlCs\Parser\Parser;

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

    public function __construct($options) {
        $content = file_get_contents($options['file']);

        $this->parser = new Parser($content);
        $this->options = $options;
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
        foreach($tablenames as $tablename)
        {
            if(strlen($tablename) > $this->options['tablename_maxlength'])
            {
                echo 'tablename_maxlength constraint violated for '.$tablename;
            }
        }
    }
}
