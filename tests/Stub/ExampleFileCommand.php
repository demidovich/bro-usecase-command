<?php

namespace Tests\Stub;

use Bro\UsecaseCommand;
use Illuminate\Contracts\Translation\Translator as TranslatorContract;

class ExampleFileCommand extends UsecaseCommand
{
    public readonly ?string $nullable_file;
    public readonly  string $required_file;

    protected function rules(): array
    {
        return [
            "required_file" => "required|file|mimes:txt|max:1024",
            "nullable_file" => "nullable|file|mimes:txt|max:1024",
        ];
    }

    /**
     * Testing mock realization
     */
    protected function translator(): TranslatorContract
    {
        return new TestingTranslator;
    }
}
