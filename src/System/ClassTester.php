<?php

namespace Peg\System;

class ClassTester
{
    public static function isParentOf(string $class, string $parentClass): bool
    {
        if ($class === $parentClass || is_subclass_of($class, $parentClass)) {
            return true;
        }

        $implements = class_implements($class);

        foreach ($implements as $interface) {
            if ($interface === $parentClass || is_subclass_of($interface, $parentClass)) {
                return true;
            }
        }

        return false;
    }
}
