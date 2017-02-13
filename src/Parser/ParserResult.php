<?php
namespace SqlCs\Parser;

class ParserResult
{
    private $createTableMap = array();

    public function __construct()
    {
    }

    public function getTablenames()
    {
        return $this->createTableMap;
    }

    public function addCreateTable($tablename)
    {
        $this->createTableMap[] = $tablename;
    }
}
