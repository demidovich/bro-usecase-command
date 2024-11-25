<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Stub\ExampleSanitizerCommand;

class SanitizerTest extends TestCase
{
    public function test_trim()
    {
        $command = new ExampleSanitizerCommand(["trim" => " Value    "]);

        $this->assertEquals("Value",  $command->trim);
    }

    public function test_strip_tags()
    {
        $command = new ExampleSanitizerCommand(["strip_tags" => "<br>Value"]);

        $this->assertEquals("Value", $command->strip_tags);
    }

    public function test_strip_repeat_spaces()
    {
        $command = new ExampleSanitizerCommand(["strip_repeat_spaces" => "Value   A"]);

        $this->assertEquals("Value A", $command->strip_repeat_spaces);
    }

    public function test_digits_only()
    {
        $command = new ExampleSanitizerCommand(["digits_only" => "+7(999) 999-99-99"]);

        $this->assertEquals("79999999999", $command->digits_only);
    }

    public function test_to_upper()
    {
        $command = new ExampleSanitizerCommand(["to_upper" => "value"]);

        $this->assertEquals("VALUE", $command->to_upper);
    }

    public function test_to_lower()
    {
        $command = new ExampleSanitizerCommand(["to_lower" => "VALUE"]);

        $this->assertEquals("value", $command->to_lower);
    }

    public function test_combined()
    {
        $command = new ExampleSanitizerCommand(["combined_field" => " VALUE<br> "]);

        $this->assertEquals("value", $command->combined_field);
    }
}
