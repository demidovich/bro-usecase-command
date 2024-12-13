<?php

namespace Tests\Stub;

use Bro\UsecaseCommand;
use Tests\Stub\LaravelTranslator\MockTranslatorTrait;

class FailedConfigCommand extends UsecaseCommand
{
    use MockTranslatorTrait;

    public function __construct(
        public readonly string $name
    ) {  
    }

    private string $rules = "bad_rules_config_type";

    private string $sanitizers = "bad_rules_config_type";
}
