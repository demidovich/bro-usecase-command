<?php

namespace Softdomain;

use Illuminate\Contracts\Translation\Translator as TranslatorContract;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Translation\Translator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
use ReflectionClass;
use ReflectionNamedType;
use RuntimeException;

abstract class UsecaseCommand
{
    private array $rules  = [];
    private array $fields = [];
    private array $files  = [];

    final public function __construct(array $fields = [], array $files = [])
    {
        $input = $fields + $files + $this->defaults();

        $this->validate($input);
        $this->hydrate($input);

        $this->fields = $fields;
        $this->files  = $files;
    }

    protected function translator(): TranslatorContract
    {
        return app(Translator::class);
    }

    public static function fromRequest(Request $request, array $additionalFields = []): static
    {
        $class = get_called_class();
        $body  = json_decode($request->getContent(), true) ?? [];
        $input = $additionalFields + $body + $request->all();

        return new $class(
            $input, 
            $request->allFiles(),
        );
    }

    /**
     * @param array $fields
     * @param UploadedFile[] $files
     */
    public static function fromArray(array $fields, array $files = []): static
    {
        $class = get_called_class();

        return new $class($fields, $files);
    }

    public static function fromCommand(self $other): static
    {
        $class = get_called_class();

        return new $class(
            $other->fields(), 
            $other->files(),
        );
    }

    public function setRules(array $rules): void
    {
        $this->rules = $rules + $this->rules;
    }

    private function validate(array $input): void
    {
        $rules = $this->rules + $this->rules();
        if (! $rules) {
            return;
        }

        $validator = new Validator(
            $this->translator(),
            $input,
            $rules,
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public function hasFile(string $name): bool
    {
        return array_key_exists($name, $this->files);
    }

    public function hasNotFile(string $name): bool
    {
        return ! $this->hasFile($name);
    }

    /**
     * @return UploadedFile|UploadedFile[]|array|null
     */
    public function file(string $name)
    {
        if ($this->hasNotFile($name)) {
            throw new RuntimeException("File $name was not uploaded.");
        }

        return $this->files[$name];
    }

    private function hydrate(array $input): void
    {
        $class = new ReflectionClass(get_called_class());

        foreach ($class->getProperties() as $property) {
            $name = $property->getName();

            // чтобы можно было создавать команды с частичным набором данных
            // throw new RuntimeException("Missing value of command attribute $name");
            if (! array_key_exists($name, $input)) {
                continue;
            }

            $value = $input[$name];
            if ($property->hasType() && $value !== null) {
                $this->castProperty($value, $property->getType());
            }

            $property->setValue($this, $value);
        }
    }

    private function castProperty(&$property, ReflectionNamedType $type): void
    {
        $typeName = $type->getName();

        if ($type->isBuiltin()) {
            settype($property, $type->getName());
        } else {
            $property = new $typeName($property);
        }
    }

    /**
     * Validation rules
     */
    protected function rules(): array
    {
        return [];
    }

    /**
     * Фильтры<br>
     * trim, to_lower, to_upper, sanitize_string, strip_tags, strip_repeat_spaces, digits_only
     *
     * @return array
     */
    protected function filters(): array
    {
        return [];
    }

    public function fields(): array
    {
        return $this->fields;
    }

    /**
     * @return UploadedFile[]
     */
    public function files(): array
    {
        return $this->files;
    }

    protected function defaults(): array
    {
        return [];
    }
}
