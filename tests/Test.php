<?php

namespace Tests;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\TestCase;
use Tests\Stub\BasicCommand;

class Test extends TestCase
{
    public function test_construct()
    {
        $fields = [
            "name"  => "My Name",
            "email" => "email@email.com",
        ];

        $command = new BasicCommand($fields);

        $this->assertEquals($fields["name"],  $command->name);
        $this->assertEquals($fields["email"], $command->email);
    }

    public function test_construct_from_array()
    {
        $fields = [
            "name"  => "My Name",
            "email" => "email@email.com",
        ];

        $command = BasicCommand::fromArray($fields);

        $this->assertEquals($fields["name"],  $command->name);
        $this->assertEquals($fields["email"], $command->email);
    }

    public function test_construct_from_request()
    {
        $fields = [
            "name"  => "My Name",
            "email" => "email@email.com",
        ];

        $request = new Request();
        $request->replace($fields);
        $command = BasicCommand::fromRequest($request);

        $this->assertEquals($fields["name"],  $command->name);
        $this->assertEquals($fields["email"], $command->email);
    }

    public function test_default()
    {
        $fields = [
            "name"  => "My Name",
            "email" => "email@email.com",
        ];

        $command = BasicCommand::fromArray($fields);

        $this->assertEquals("Fake address", $command->address);
    }

    public function test_filelds()
    {
        $fields = [
            "name"  => "My Name",
            "email" => "email@email.com",
        ];

        $command = BasicCommand::fromArray($fields);

        $this->assertCount(2, $command->fields());
    }

    public function test_validate_exception()
    {
        $this->expectException(ValidationException::class);

        $fields = [
            "name"  => "My Name",
            "email" => "invalid_email",
        ];

        BasicCommand::fromArray($fields);
    }
}
