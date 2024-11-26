<?php

namespace Tests\Stub;

use Bro\UsecaseCommand;
use Illuminate\Contracts\Translation\Translator as TranslatorContract;
use Tests\Stub\LaravelTranslator\MockTranslator;

class ArraySanitizedCommand extends UsecaseCommand
{
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

    /**
     * Testing mock realization
     */
    protected function translator(): TranslatorContract
    {
        return new MockTranslator;
    }
}
