<?php

namespace Tests;

use Bro\UsecaseCommand\Sanitizer;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class SanitizerTest extends TestCase
{
    public static function methodsProvider(): array
    {
        return [
            "trim"                => ["trim",                " Value   ", "Value"  ],
            "strip_tags"          => ["strip_tags",          "<br>Value", "Value"  ],
            "strip_repeat_spaces" => ["strip_repeat_spaces", "Value   A", "Value A"],
            "digits_only"         => ["digits_only",         "+7(9) 99-", "7999"   ],
            "to_upper"            => ["to_upper",            "value",     "VALUE"  ],
            "to_lower"            => ["to_lower",            "VALUE",     "value"  ],
            "combined1"           => ["trim|strip_tags",     "<br> <br>", ""       ],
            "combined2"           => ["to_lower|trim",       " Value   ", "value"  ],
        ];
    }

    #[DataProvider('methodsProvider')]
    public function test_methods(string $method, string $value, string $expected)
    {
        $input   = ["v" => $value];
        $methods = ["v" => $method];

        Sanitizer::apply($input, $methods);

        $this->assertEquals($expected, $input["v"]);
    }

    public function test_missing_method_error()
    {
        $this->expectException(RuntimeException::class);

        $input   = ["v" => "1"];
        $methods = ["v" => "missing_method"];

        Sanitizer::apply($input, $methods);
    }
}
