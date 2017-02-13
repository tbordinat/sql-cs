<?php

namespace SqlCs\Lexer;

class Lexer extends \Doctrine\ORM\Query\Lexer
{
	const T_ALTER = 257;
	const T_CREATE = 258;
	const T_DATABASE = 259;
	const T_TABLE = 260;

    /**
     * Creates a new query scanner object.
     *
     * @param string $input A query string.
     */
    public function __construct($input)
    {
        $this->setInput($input);
    }




    /**
     * {@inheritdoc}
     */
    protected function getType(&$value)
    {
        $type = self::T_NONE;
        switch (true) {
            // Recognize numeric values
            case (is_numeric($value)):
                if (strpos($value, '.') !== false || stripos($value, 'e') !== false) {
                    return self::T_FLOAT;
                }
                return self::T_INTEGER;
            // Recognize quoted strings
            case ($value[0] === "'"):
                $value = str_replace("''", "'", substr($value, 1, strlen($value) - 2));
                return self::T_STRING;
            // Recognize identifiers, aliased or qualified names
            case (ctype_alpha($value[0]) || $value[0] === '_' || $value[0] === '\\'):
                $name = 'SqlCs\Lexer\Lexer::T_' . strtoupper($value);
                if (defined($name)) {
                    $type = constant($name);
                    if ($type > 100) {
                        return $type;
                    }
                }
                if (strpos($value, ':') !== false) {
                    return self::T_ALIASED_NAME;
                }
                if (strpos($value, '\\') !== false) {
                    return self::T_FULLY_QUALIFIED_NAME;
                }
                return self::T_IDENTIFIER;
            // Recognize input parameters
            case ($value[0] === '?' || $value[0] === ':'):
                return self::T_INPUT_PARAMETER;
            // Recognize symbols
            case ($value === '.'): return self::T_DOT;
            case ($value === ','): return self::T_COMMA;
            case ($value === '('): return self::T_OPEN_PARENTHESIS;
            case ($value === ')'): return self::T_CLOSE_PARENTHESIS;
            case ($value === '='): return self::T_EQUALS;
            case ($value === '>'): return self::T_GREATER_THAN;
            case ($value === '<'): return self::T_LOWER_THAN;
            case ($value === '+'): return self::T_PLUS;
            case ($value === '-'): return self::T_MINUS;
            case ($value === '*'): return self::T_MULTIPLY;
            case ($value === '/'): return self::T_DIVIDE;
            case ($value === '!'): return self::T_NEGATE;
            case ($value === '{'): return self::T_OPEN_CURLY_BRACE;
            case ($value === '}'): return self::T_CLOSE_CURLY_BRACE;
            // Default
            default:
                // Do nothing
        }
        return $type;
    }
}
