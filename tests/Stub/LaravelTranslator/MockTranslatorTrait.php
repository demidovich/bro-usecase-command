<?php

namespace Tests\Stub\LaravelTranslator;

use Illuminate\Contracts\Translation\Translator as TranslatorContract;

trait MockTranslatorTrait
{
    /**
     * Testing mock realization
     */
    protected function translator(): TranslatorContract
    {
        return new MockTranslator;
    }
}
