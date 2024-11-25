<?php

namespace Tests\Stub;

use Bro\UsecaseCommand;
use Illuminate\Contracts\Translation\Translator as TranslatorContract;

class ExampleSanitizerCommand extends UsecaseCommand
{
    public readonly string $trim;
    public readonly string $strip_tags;
    public readonly string $strip_repeat_spaces;
    public readonly string $digits_only;
    public readonly string $to_lower;
    public readonly string $to_upper;
    public readonly string $combined_field;

    protected function sanitizers(): array
    {
        return [
            "trim"                => "trim",
            "strip_tags"          => "strip_tags",
            "strip_repeat_spaces" => "strip_repeat_spaces",
            "digits_only"         => "digits_only",
            "to_lower"            => "to_lower",
            "to_upper"            => "to_upper",
            "combined_field"      => "trim|to_lower|strip_tags",
        ];
    }

    /**
     * Testing mock realization
     */
    protected function translator(): TranslatorContract
    {
        return new TestingTranslator;
    }
}
