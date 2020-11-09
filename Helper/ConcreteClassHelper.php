<?php

namespace MundiPagg\MundiPagg\Helper;

class ConcreteClassHelper
{
    public static function sanitize($text)
    {
        $pattern = '/\\\s+\\\s\\\r\\\n|\\\r|\\\n\\\r|\\\n/m';
        return trim(
            preg_replace(
                $pattern,
                ' ',
                $text
            )
        );
    }
}
