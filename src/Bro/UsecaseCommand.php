<?php

namespace Bro;

use Bro\UsecaseCommand\Sanitizer;
use Illuminate\Contracts\Translation\Translator as TranslatorContract;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Translation\Translator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionParameter;
use RuntimeException;

abstract class UsecaseCommand
{
    /** @var array<string, UploadedFile> */
    private array $files = [];

    /**
     * @param array<string, mixed> $fields
     * @param array<string, UploadedFile> $files
     * 
     * @throws ValidationException
     */
    public static function fromArray(array $fields, array $files = []): static
    {
        $class = get_called_class();

        self::sanitize($class, $fields);
        self::validate($class, $fields + $files);

        $casted = self::castedProperties(
            get_called_class(), 
            $fields,
        );

        $self = new $class(...$casted);
        $self->files = $files;

        return $self;
    }

    /**
     * @param array<string, mixed> $additionalFields
     * @throws ValidationException
     */
    public static function fromRequest(Request $request, array $additionalFields = []): static
    {
        $body  = json_decode($request->getContent(), true) ?? [];
        $input = $additionalFields + $body + $request->all();

        return self::fromArray(
            $input, 
            $request->allFiles(),
        );
    }

    protected static function translator(): TranslatorContract
    {
        return app(Translator::class);
    }

    /**
     * @param array<string, mixed> $input
     */
    private static function sanitize(string $calledClass, array &$input): void
    {
        $sanitizers = static::sanitizers();

        if (! $sanitizers) {
            $sanitizers = self::parentArrayableProperty($calledClass, "sanitizers");
        }

        Sanitizer::apply(
            input: $input, 
            sanitizers: $sanitizers,
        );
    }

    /**
     * @param array<string, mixed> $input
     * @throws ValidationException
     */
    protected static function validate(string $calledClass, array $input): void
    {
        $rules = static::rules();

        if (! $rules) {
            $rules = self::parentArrayableProperty($calledClass, "rules");
        }

        if (! $rules) {
            return;
        }

        $validator = new Validator(
            static::translator(),
            $input,
            $rules,
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * @return array<string, mixed>
     */
    private static function parentArrayableProperty(string $class, string $property): array
    {
        $class = new ReflectionClass($class);
        if (! $class->hasProperty($property)) {
            return [];
        }

        $value = $class->getProperty($property)->getDefaultValue();
        if (! is_array($value)) {
            throw new RuntimeException(
                "Property \"{$property}\" of class \"{$class}\" is not an array."
            );
        }

        return $value;
    }

    /**
     * Validation rules
     * 
     * @return array<string,mixed>
     */
    protected static function rules(): array
    {
        return [];
    }

    /**
     * @param array<string, mixed> $input
     * @return array<string, mixed>
     */
    private static function castedProperties(string $calledClass, array $input): array
    {
        $class = new ReflectionClass($calledClass);
        if (! $class->hasMethod("__construct")) {
            return $input;
        }

        $results = [];
        foreach ($class->getConstructor()->getParameters() as $property) {
            $name = $property->getName();
            if (! array_key_exists($name, $input)) {
                continue;
            }

            $value = $input[$name];
            if ($property->hasType() && $value !== null) {
                self::castValue($value, $property);
            }

            $results[$name] = $value;
        }

        return $results;
    }

    /**
     * @param mixed $value
     */
    private static function castValue(&$value, ReflectionParameter $property): void
    {
        $type = $property->getType();
        if (! ($type instanceof ReflectionNamedType)) {
            return;
        }

        $typeName = $type->getName();

        if ($type->isBuiltin()) {
            settype($value, $typeName);
        } else {
            $value = new $typeName($value);
        }
    }

    /**
     * Sanitizers for input data. Applied before validation.
     * trim, to_lower, to_upper, sanitize_string, strip_tags, strip_repeat_spaces, digits_only
     * 
     * @return array<string, mixed>
     */
    protected static function sanitizers(): array
    {
        return [];
    }

    public function hasFile(string $name): bool
    {
        return array_key_exists($name, $this->files);
    }

    public function hasNotFile(string $name): bool
    {
        return ! array_key_exists($name, $this->files);
    }

    /**
     * @return UploadedFile|null
     */
    public function file(string $name)
    {
        if ($this->hasNotFile($name)) {
            throw new RuntimeException("File \"{$name}\" was not uploaded.");
        }

        return $this->files[$name];
    }

    /**
     * @return array<string, UploadedFile>
     */
    public function files(): array
    {
        return $this->files;
    }
}
