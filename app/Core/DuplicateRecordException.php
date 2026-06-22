<?php
class DuplicateRecordException extends Exception
{
    public function __construct(string $message = 'Duplicate record.', private string $field = '')
    {
        parent::__construct($message);
    }

    public function field(): string
    {
        return $this->field;
    }
}
