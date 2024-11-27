<?php

namespace Tests\Stub;

use Bro\UsecaseCommand;
use Tests\Stub\LaravelTranslator\MockTranslatorTrait;

class ArraySanitizedCommand extends UsecaseCommand
{
    use MockTranslatorTrait;

    public function __construct(
        public readonly array $emails,
    ) {  
    }

    protected static function rules(): array
    {
        return [
            "emails"   => "required|array",
            "emails.*" => "required|email",
        ];
    }

    protected static function sanitizers(): array
    {
        return [
            "emails" => "to_lower",
        ];
    }
}
