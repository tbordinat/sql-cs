<?php
namespace SqlCs\Parser;

use SqlCs\Lexer\Lexer;

class Parser
{
    private $parserResult;
    private $lexer;

    public function __construct($string)
    {
        $this->parserResult = new ParserResult();
        $this->lexer = new Lexer($string);
        $this->walk();
    }

    public function getResult()
    {
        return $this->parserResult;
    }

    public function walk()
    {
        while ($this->lexer->moveNext()) {
            switch ($this->lexer->lookahead['type']) {
                case Lexer::T_CREATE:
                    $this->walkCreateStatement();
                    break;
                default:
                    $this->walk();
            }
        }
    }

    private function walkCreateStatement()
    {
        $this->lexer->moveNext();
        
        switch ($this->lexer->lookahead['type']) {
            case Lexer::T_TABLE:
                $this->CreateTable();
                break;
            case Lexer::T_DATABASE:
                $this->CreateDatabase();
                break;
        }
    }

    private function CreateTable()
    {
        $this->lexer->moveNext();
        $this->parserResult->addCreateTable($this->lexer->lookahead['value']);
    }
    private function CreateDatabase()
    {
        echo 'Create database';
    }
}
