<?php

namespace Tests\Stub;

use Bro\UsecaseCommand;
use Tests\Stub\LaravelTranslator\MockTranslatorTrait;

class ArraySanitizedCommand extends UsecaseCommand
{
    use MockTranslatorTrait;

    public readonly array $emails;

    protected function rules(): array
    {
        return [
            "emails"   => "required|array",
            "emails.*" => "required|email",
        ];
    }

    protected function sanitizers(): array
    {
        return [
            "emails" => "to_lower",
        ];
    }
}
