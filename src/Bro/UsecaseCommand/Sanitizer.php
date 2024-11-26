<?php

namespace Bro\UsecaseCommand;

use RuntimeException;

class Sanitizer
{
    public static function apply(array &$input, array $sanitizers): void
    {
        if (! $input || ! $sanitizers) {
            return;
        }

        foreach ($sanitizers as $field => $methodsString) {
            if (! isset($input[$field])) {
                continue;
            }

            $methods = explode("|", $methodsString);
            foreach ($methods as $method) {
                self::ensureMethodExists($method);
            }

            // If a trim exists it will be executed last
            if (in_array("trim", $methods)) {
                $key = array_search("trim", $methods);
                if ($key < array_key_last($methods)) {
                    unset($methods[$key]);
                    array_push($methods, "trim");
                }
            }

            foreach ($methods as $method) {
                // If the value is an array, the filter is applied recursively to all its values
                if (is_array($input[$field])) {
                    array_walk_recursive($input[$field], function(&$value) use ($method) {
                        $value = self::$method($value);
                    });
                } else {
                    $input[$field] = self::$method($input[$field]);
                }
            }
        }
    }

    private static function ensureMethodExists(string $method): void
    {
        if (method_exists(Sanitizer::class, $method)) {
            return;
        }

        throw new RuntimeException("Non-existent sanitizer method \"{$method}\".");
    }

    protected static function trim($value)
    {
        return trim($value);
    }

    protected static function strip_tags($value)
    {
        return strip_tags($value);
    }

    protected static function strip_repeat_spaces($value)
    {
        return preg_replace("/\s+/u", " ", $value);
    }

    protected static function digits_only($value)
    {
        return preg_replace("/[^0-9]/si", "", $value);
    }

    protected static function to_upper($value)
    {
        return mb_strtoupper($value, "utf-8");
    }

    protected static function to_lower($value)
    {
        return mb_strtolower($value, "utf-8");
    }
}
