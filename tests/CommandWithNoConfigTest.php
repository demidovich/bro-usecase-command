<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Stub\NoConfigCommand;

class CommandWithNoConfigTest extends TestCase
{
    public function test_construct_from_array()
    {
        $fields = [
            "name"  => "My Name",
            "email" => "email@email.com",
        ];

        $command = NoConfigCommand::fromArray($fields);

        $this->assertEquals($fields["name"],  $command->name);
        $this->assertEquals($fields["email"], $command->email);
    }
}
