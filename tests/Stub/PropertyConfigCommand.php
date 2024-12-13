<?php

namespace Tests\Stub;

use Bro\UsecaseCommand;
use Tests\Stub\LaravelTranslator\MockTranslatorTrait;

class PropertyConfigCommand extends UsecaseCommand
{
    use MockTranslatorTrait;

    public function __construct(
        public readonly string $name,
        public readonly string $email,
    ) {  
    }

    private array $rules = [
        "name"  => "required|string|min:1|max:256",
        "email" => "required|email",
    ];

    private array $sanitizers = [
        "email" => "to_lower",
    ];
}
