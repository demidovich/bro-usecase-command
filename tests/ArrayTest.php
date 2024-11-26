<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Stub\ArrayCommand;
use Tests\Stub\ArraySanitizedCommand;

class ArrayTest extends TestCase
{
    public function test()
    {
        $fields = [
            "users" => [
                [
                    "name" => "User Name",
                ],
            ],
        ];

        $command = new ArrayCommand($fields);

        $this->assertCount(1, $command->users);
        $this->assertNotEmpty(1, $command->users[0]["name"]);
        $this->assertEquals($fields["users"][0]["name"], $command->users[0]["name"]);
    }

    public function test_sanitize()
    {
        $fields = [
            "emails" => [
                "Email@Email.com",
            ],
        ];

        $command = new ArraySanitizedCommand($fields);

        $this->assertCount(1, $command->emails);
        $this->assertNotEmpty(1, $command->emails[0]);
        $this->assertEquals("email@email.com", $command->emails[0]);
    }
}
