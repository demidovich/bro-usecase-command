<?php

namespace Tests\Stub;

use Bro\UsecaseCommand;
use Illuminate\Contracts\Translation\Translator as TranslatorContract;
use Tests\Stub\LaravelTranslator\MockTranslator;

class BasicCommand extends UsecaseCommand
{
    public readonly string $name;
    public readonly string $email;
    public readonly ?string $address;

    protected function rules(): array
    {
        return [
            "name"    => "required|string|min:1|max:256",
            "email"   => "required|email",
            "address" => "nullable|string|min:1,max:1024",
        ];
    }

    protected function defaults(): array
    {
        return [
            "address" => "Fake address",
        ];
    }

    protected function sanitizers(): array
    {
        return [
            "email"   => "to_lower",
            "address" => "strip_tags",
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
