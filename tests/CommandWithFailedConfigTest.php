<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Tests\Stub\FailedConfigCommand;

class CommandWithFailedConfigTest extends TestCase
{
    public function test_validate_exception()
    {
        $this->expectException(RuntimeException::class);

        FailedConfigCommand::fromArray(["name" => "My Name"]);
    }
}
