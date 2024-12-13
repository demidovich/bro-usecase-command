<?php

namespace Bro\UsecaseCommand;

use RuntimeException;

class Sanitizer
{
    /**
     * @param array<string, mixed> $input
     * @param array<string, string> $sanitizers
     */
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
                        $value = self::$method((string) $value);
                    });
                } else {
                    $input[$field] = self::$method((string) $input[$field]);
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

    protected static function trim(string $value): string
    {
        return trim($value);
    }


    protected static function strip_tags(string $value): string
    {
        return strip_tags($value);
    }

    protected static function strip_repeat_spaces(string $value): string
    {
        return (string) preg_replace("/\s+/u", " ", $value);
    }

    protected static function digits_only(string $value): string
    {
        return (string) preg_replace("/[^0-9]/si", "", $value);
    }

    protected static function to_upper(string $value): string
    {
        return mb_strtoupper($value, "utf-8");
    }

    protected static function to_lower(string $value): string
    {
        return mb_strtolower($value, "utf-8");
    }
}
