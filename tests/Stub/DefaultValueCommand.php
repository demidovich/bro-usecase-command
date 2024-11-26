<?php

namespace Tests\Stub;

use Bro\UsecaseCommand;
use Tests\Stub\LaravelTranslator\MockTranslatorTrait;

class DefaultValueCommand extends UsecaseCommand
{
    use MockTranslatorTrait;

    public readonly array   $nulleble_array;
    public readonly bool    $nullable_bool;
    public readonly ?int    $nullable_int;
    public readonly ?string $presetted_string;

    protected function rules(): array
    {
        return [
            "nullable_int"     => "nullable|integer",
            "nulleble_array"   => "nullable|array",
            "nullable_bool"    => "nullable|boolean",
            "presetted_string" => "nullable|string",
        ];
    }

    protected function defaults(): array
    {
        return [
            "presetted_string" => "Default",
        ];
    }
}
