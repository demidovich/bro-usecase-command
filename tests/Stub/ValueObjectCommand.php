<?php

namespace Tests\Stub;

use Bro\UsecaseCommand;
use Carbon\Carbon;
use Illuminate\Contracts\Translation\Translator as TranslatorContract;
use Tests\Stub\LaravelTranslator\MockTranslator;

class ValueObjectCommand extends UsecaseCommand
{
    public readonly Carbon $time;

    protected function rules(): array
    {
        return [
            "time" => "required|date_format:Y-m-d H:i:s",
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
