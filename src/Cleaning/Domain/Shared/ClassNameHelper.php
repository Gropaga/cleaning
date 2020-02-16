<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Domain\Shared;

class ClassNameHelper
{
    public static function getShortClassName($fullClassName): string
    {
        if (empty(self::getNamespace($fullClassName))) {
            return $fullClassName;
        }

        return substr($fullClassName, strrpos($fullClassName, '\\') + 1);
    }

    public static function getNamespace(string $fullClassName): string
    {
        return substr($fullClassName, 0, strrpos($fullClassName, '\\'));
    }
}
