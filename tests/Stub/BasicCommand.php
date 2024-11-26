<?php

namespace Tests\Stub;

use Bro\UsecaseCommand;
use Tests\Stub\LaravelTranslator\MockTranslatorTrait;

class BasicCommand extends UsecaseCommand
{
    use MockTranslatorTrait;

    public readonly string $name;
    public readonly string $email;

    protected function rules(): array
    {
        return [
            "name"  => "required|string|min:1|max:256",
            "email" => "required|email",
        ];
    }

    protected function sanitizers(): array
    {
        return [
            "email" => "to_lower",
        ];
    }
}
