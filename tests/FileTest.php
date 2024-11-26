<?php

namespace Tests;

use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\TestCase;
use Tests\Stub\FileCommand;

class FileTest extends TestCase
{
    public function test_file()
    {
        $files = [
            "required_file" => UploadedFile::fake()->create("fake_file.txt", 1),
            "nullable_file" => UploadedFile::fake()->create("fake_file.txt", 1),
        ];

        $command = new FileCommand([], $files);

        $this->assertTrue($command->hasFile("required_file"));
        $this->assertTrue($command->file("required_file") instanceof UploadedFile);

        $this->assertTrue($command->hasFile("nullable_file"));
        $this->assertTrue($command->file("nullable_file") instanceof UploadedFile);
    }

    public function test_nullable_file_for_delete_it()
    {
        $files = [
            "required_file" => UploadedFile::fake()->create("fake_file.txt", 1),
            "nullable_file" => null,
        ];

        $command = new FileCommand([], $files);

        $this->assertTrue($command->hasFile("nullable_file"));
        $this->assertEquals($command->file("nullable_file"), null);
    }

    public function test_skip_nullable_file()
    {
        $files = [
            "required_file" => UploadedFile::fake()->create("fake_file.txt", 1),
        ];

        $command = new FileCommand([], $files);

        $this->assertTrue($command->hasNotFile("nullable_file"));
    }

    public function test_files()
    {
        $files = [
            "required_file" => UploadedFile::fake()->create("fake_file.txt", 1),
        ];

        $command = new FileCommand([], $files);

        $this->assertCount(1, $command->files());
    }
}
