<?php

namespace Tests\Stub;

use Bro\UsecaseCommand;
use Tests\Stub\LaravelTranslator\MockTranslatorTrait;

class NoConfigCommand extends UsecaseCommand
{
    use MockTranslatorTrait;

    public function __construct(
        public readonly string $name,
        public readonly string $email,
    ) {  
    }
}
