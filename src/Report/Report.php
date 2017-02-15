<?php
namespace SqlCs\Report;

final class Report
{
    const TYPE_VALID = 1;
    const TYPE_ERROR = 2;
    const TYPE_WARNING = 3;

    /**
     * @var int
     */
    private $type;

    /**
     * @var string
     */
    private $message;

    /**
     * @param int    $type
     * @param string $message
     */
    public function __construct($type, $message)
    {
        $this->type = $type;
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
