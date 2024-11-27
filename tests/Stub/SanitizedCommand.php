<?php

namespace Tests\Stub;

use Bro\UsecaseCommand;
use Tests\Stub\LaravelTranslator\MockTranslatorTrait;

class SanitizedCommand extends UsecaseCommand
{
    use MockTranslatorTrait;

    public function __construct(
        public readonly ?string $text  = null,
        public readonly ?string $email = null,
    ) {  
    }

    protected static function sanitizers(): array
    {
        return [
            "text"  => "strip_tags|trim",
            "email" => "to_lower",
        ];
    }
}
