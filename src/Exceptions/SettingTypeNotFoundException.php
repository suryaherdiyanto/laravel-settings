<?php

namespace Surya\Setting\Exceptions;

class SettingTypeNotFoundException extends \Exception
{
    public function __contstruct($message, $code = 0, Exception $previous)
    {
        parent::__contstruct();
    }

    public function __toString()
    {
        return __CLASS__ . ": [".$this->code."] ".$this->message."\n";
    }
}