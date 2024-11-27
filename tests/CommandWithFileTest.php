<?php

namespace Tests;

use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Tests\Stub\FileCommand;

class CommandWithFileTest extends TestCase
{
    public function test_file()
    {
        $files = [
            "required_file" => UploadedFile::fake()->create("fake_file.txt", 1),
            "nullable_file" => UploadedFile::fake()->create("fake_file.txt", 1),
        ];

        $command = FileCommand::fromArray([], $files);

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

        $command = FileCommand::fromArray([], $files);

        $this->assertTrue($command->hasFile("nullable_file"));
        $this->assertNull($command->file("nullable_file"));
    }

    public function test_skip_nullable_file()
    {
        $files = [
            "required_file" => UploadedFile::fake()->create("fake_file.txt", 1),
        ];

        $command = FileCommand::fromArray([], $files);

        $this->assertTrue($command->hasNotFile("nullable_file"));
    }

    public function test_missing_file_access_exception()
    {
        $this->expectException(RuntimeException::class);

        $files = [
            "required_file" => UploadedFile::fake()->create("fake_file.txt", 1),
        ];

        $command = FileCommand::fromArray([], $files);
        $command->file("nullable_file");
    }

    public function test_files()
    {
        $files = [
            "required_file" => UploadedFile::fake()->create("fake_file.txt", 1),
        ];

        $command = FileCommand::fromArray([], $files);

        $this->assertCount(1, $command->files());
    }
}
