<?php

namespace Tests\Stub;

use Bro\UsecaseCommand;
use Tests\Stub\LaravelTranslator\MockTranslatorTrait;

class FileCommand extends UsecaseCommand
{
    use MockTranslatorTrait;

    public readonly ?string $nullable_file;
    public readonly  string $required_file;

    protected function rules(): array
    {
        return [
            "required_file" => "required|file|mimes:txt|max:1024",
            "nullable_file" => "nullable|file|mimes:txt|max:1024",
        ];
    }
}
