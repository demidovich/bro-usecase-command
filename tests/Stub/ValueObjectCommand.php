<?php

namespace Tests\Stub;

use Bro\UsecaseCommand;
use Carbon\Carbon;
use Tests\Stub\LaravelTranslator\MockTranslatorTrait;

class ValueObjectCommand extends UsecaseCommand
{
    use MockTranslatorTrait;

    public readonly Carbon $time;

    protected function rules(): array
    {
        return [
            "time" => "required|date_format:Y-m-d H:i:s",
        ];
    }
}
