<?php

namespace Tests\Stub;

use Bro\UsecaseCommand;
use Tests\Stub\LaravelTranslator\MockTranslatorTrait;

class FileCommand extends UsecaseCommand
{
    use MockTranslatorTrait;

    protected static function rules(): array
    {
        return [
            "required_file" => "required|file|mimes:txt|max:1024",
            "nullable_file" => "nullable|file|mimes:txt|max:1024",
        ];
    }
}
