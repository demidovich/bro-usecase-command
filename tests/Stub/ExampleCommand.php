<?php

namespace Tests\Stub;

use Illuminate\Contracts\Translation\Translator as TranslatorContract;
use Softdomain\UsecaseCommand;

class ExampleCommand extends UsecaseCommand
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

    protected function translator(): TranslatorContract
    {
        return new TestingTranslator;
    }
}
