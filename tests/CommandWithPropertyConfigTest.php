<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Stub\PropertyConfigCommand;

class CommandWithPropertyConfigTest extends TestCase
{
    public function test_construct_from_array()
    {
        $fields = [
            "name"  => "My Name",
            "email" => "email@email.com",
        ];

        $command = PropertyConfigCommand::fromArray($fields);

        $this->assertEquals($fields["name"],  $command->name);
        $this->assertEquals($fields["email"], $command->email);
    }
}
