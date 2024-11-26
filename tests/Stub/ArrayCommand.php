<?php

namespace Tests\Stub;

use Bro\UsecaseCommand;
use Illuminate\Contracts\Translation\Translator as TranslatorContract;
use Tests\Stub\LaravelTranslator\MockTranslator;

class ArrayCommand extends UsecaseCommand
{
    public readonly array $users;

    protected function rules(): array
    {
        return [
            "users"        => "required|array",
            "users.*"      => "required|array",
            "users.*.name" => "required|string|min:1",
        ];
    }

    /**
     * Testing mock realization
     */
    protected function translator(): TranslatorContract
    {
        return new MockTranslator;
    }
}
