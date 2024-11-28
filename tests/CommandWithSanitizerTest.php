<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Stub\SanitizedCommand;

class CommandWithSanitizerTest extends TestCase
{
    public function test()
    {
        $input = [
            "text"  => " Text<br>   ",
            "email" => "EmAil@Email.com",
        ];

        $command = SanitizedCommand::fromArray($input);

        $this->assertEquals("Text", $command->text);
        $this->assertEquals("email@email.com", $command->email);
    }

    public function test_partial_input()
    {
        $input = [
            "text" => " Text<br>   ",
        ];

        $command = SanitizedCommand::fromArray($input);

        $this->assertEquals("Text", $command->text);
        $this->assertNull($command->email);
    }
}
