<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Stub\DefaultValueCommand;

class DefaultTest extends TestCase
{
    public function test_nulleble_array()
    {
        $command = new DefaultValueCommand([]);

        $this->assertIsArray($command->nulleble_array);
        $this->assertCount(0, $command->nulleble_array);
    }

    public function test_nulleble_bool()
    {
        $command = new DefaultValueCommand([]);

        $this->assertFalse($command->nullable_bool);
    }

    public function test_nulleble_int()
    {
        $command = new DefaultValueCommand([]);

        $this->assertNull($command->nullable_int);
    }

    public function test_presetted_string()
    {
        $command = new DefaultValueCommand([]);

        $this->assertEquals("Default", $command->presetted_string);
    }
}
