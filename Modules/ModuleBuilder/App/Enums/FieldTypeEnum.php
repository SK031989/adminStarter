<?php

namespace Modules\ModuleBuilder\App\Enums;

enum FieldTypeEnum: string
{
    case Text     = 'text';
    case Textarea = 'textarea';
    case Number   = 'number';
    case Email    = 'email';
    case Password = 'password';
    case Date     = 'date';
    case Datetime = 'datetime';
    case Select   = 'select';
    case Radio    = 'radio';
    case Checkbox = 'checkbox';
    case File     = 'file';
    case Image    = 'image';
    case Boolean  = 'boolean';

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /** Human-readable label. */
    public function label(): string
    {
        return match ($this) {
            self::Text     => 'Text',
            self::Textarea => 'Textarea',
            self::Number   => 'Number',
            self::Email    => 'Email',
            self::Password => 'Password',
            self::Date     => 'Date',
            self::Datetime => 'Date & Time',
            self::Select   => 'Select / Dropdown',
            self::Radio    => 'Radio Button',
            self::Checkbox => 'Checkbox',
            self::File     => 'File Upload',
            self::Image    => 'Image Upload',
            self::Boolean  => 'Boolean (Toggle)',
        };
    }

    /** Corresponding MySQL column type for migration generation. */
    public function migrationColumnType(): string
    {
        return match ($this) {
            self::Text     => 'string',
            self::Textarea => 'text',
            self::Number   => 'decimal',
            self::Email    => 'string',
            self::Password => 'string',
            self::Date     => 'date',
            self::Datetime => 'dateTime',
            self::Select   => 'string',
            self::Radio    => 'string',
            self::Checkbox => 'json',
            self::File     => 'string',
            self::Image    => 'string',
            self::Boolean  => 'boolean',
        };
    }

    /** HTML input type. */
    public function htmlInputType(): string
    {
        return match ($this) {
            self::Text     => 'text',
            self::Textarea => 'textarea',
            self::Number   => 'number',
            self::Email    => 'email',
            self::Password => 'password',
            self::Date     => 'date',
            self::Datetime => 'datetime-local',
            self::Select   => 'select',
            self::Radio    => 'radio',
            self::Checkbox => 'checkbox',
            self::File     => 'file',
            self::Image    => 'file',
            self::Boolean  => 'checkbox',
        };
    }

    /** Whether this field type stores uploaded files. */
    public function isFileType(): bool
    {
        return in_array($this, [self::File, self::Image], true);
    }

    /** Whether this field type accepts multiple values. */
    public function isMultiValue(): bool
    {
        return in_array($this, [self::Checkbox], true);
    }

    /** Whether options (choices) must be provided. */
    public function requiresOptions(): bool
    {
        return in_array($this, [self::Select, self::Radio, self::Checkbox], true);
    }

    /** Cast type for Eloquent model $casts array. */
    public function castType(): ?string
    {
        return match ($this) {
            self::Boolean  => 'boolean',
            self::Checkbox => 'array',
            self::Number   => 'decimal:2',
            self::Date     => 'date',
            self::Datetime => 'datetime',
            default        => null,
        };
    }

    /**
     * All values as options array for select inputs.
     *
     * @return array<string, string>
     */
    public static function options(): array
    {
        $result = [];
        foreach (self::cases() as $case) {
            $result[$case->value] = $case->label();
        }
        return $result;
    }
}
