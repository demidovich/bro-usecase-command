<?php

namespace Tests\Stub;

use Bro\UsecaseCommand;
use Tests\Stub\LaravelTranslator\MockTranslatorTrait;

class ArrayCommand extends UsecaseCommand
{
    use MockTranslatorTrait;

    public function __construct(
        public readonly array $users = [],
    ) {  
    }

    protected static function rules(): array
    {
        return [
            "users"        => "required|array",
            "users.*"      => "required|array",
            "users.*.name" => "required|string|min:1",
        ];
    }
}
