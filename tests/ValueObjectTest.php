<?php

namespace Tests;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Tests\Stub\ValueObjectCommand;

class ValueObjectTest extends TestCase
{
    public function test_file()
    {
        $fields = [
            "time" => "2020-01-01 00:00:00",
        ];

        $command = new ValueObjectCommand($fields);

        $this->assertNotEmpty($command->time);
        $this->assertInstanceOf(Carbon::class, $command->time);
        $this->assertEquals($fields["time"], $command->time->format("Y-m-d H:i:s"));
    }
}
