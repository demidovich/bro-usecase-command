<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Stub\ExampleCommand;

class Test extends TestCase
{
    public function test()
    {
        $params = [
            "name"  => "My Name",
            "email" => "email@email.com",
        ];

        $command = ExampleCommand::fromArray($params);
dd($command->address);
        $this->assertEquals($command->name, $params["name"]);
    }
}
