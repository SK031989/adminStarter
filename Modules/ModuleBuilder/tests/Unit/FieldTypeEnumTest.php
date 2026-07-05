<?php

namespace Modules\ModuleBuilder\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Modules\ModuleBuilder\App\Enums\FieldTypeEnum;

class FieldTypeEnumTest extends TestCase
{
    /** @test */
    public function it_returns_correct_migration_column_type(): void
    {
        $this->assertEquals('string',   FieldTypeEnum::Text->migrationColumnType());
        $this->assertEquals('text',     FieldTypeEnum::Textarea->migrationColumnType());
        $this->assertEquals('decimal',  FieldTypeEnum::Number->migrationColumnType());
        $this->assertEquals('boolean',  FieldTypeEnum::Boolean->migrationColumnType());
        $this->assertEquals('date',     FieldTypeEnum::Date->migrationColumnType());
        $this->assertEquals('dateTime', FieldTypeEnum::Datetime->migrationColumnType());
        $this->assertEquals('json',     FieldTypeEnum::Checkbox->migrationColumnType());
    }

    /** @test */
    public function it_returns_correct_html_input_type(): void
    {
        $this->assertEquals('text',     FieldTypeEnum::Text->htmlInputType());
        $this->assertEquals('email',    FieldTypeEnum::Email->htmlInputType());
        $this->assertEquals('number',   FieldTypeEnum::Number->htmlInputType());
        $this->assertEquals('file',     FieldTypeEnum::File->htmlInputType());
        $this->assertEquals('checkbox', FieldTypeEnum::Boolean->htmlInputType());
        $this->assertEquals('select',   FieldTypeEnum::Select->htmlInputType());
    }

    /** @test */
    public function it_identifies_file_types(): void
    {
        $this->assertTrue(FieldTypeEnum::File->isFileType());
        $this->assertTrue(FieldTypeEnum::Image->isFileType());
        $this->assertFalse(FieldTypeEnum::Text->isFileType());
    }

    /** @test */
    public function it_identifies_option_required_types(): void
    {
        $this->assertTrue(FieldTypeEnum::Select->requiresOptions());
        $this->assertTrue(FieldTypeEnum::Radio->requiresOptions());
        $this->assertTrue(FieldTypeEnum::Checkbox->requiresOptions());
        $this->assertFalse(FieldTypeEnum::Text->requiresOptions());
    }

    /** @test */
    public function it_returns_cast_type_for_supported_types(): void
    {
        $this->assertEquals('boolean',    FieldTypeEnum::Boolean->castType());
        $this->assertEquals('array',      FieldTypeEnum::Checkbox->castType());
        $this->assertEquals('decimal:2',  FieldTypeEnum::Number->castType());
        $this->assertNull(FieldTypeEnum::Text->castType());
        $this->assertNull(FieldTypeEnum::Email->castType());
    }

    /** @test */
    public function it_returns_options_array_with_all_types(): void
    {
        $options = FieldTypeEnum::options();

        $this->assertIsArray($options);
        $this->assertArrayHasKey('text', $options);
        $this->assertArrayHasKey('select', $options);
        $this->assertArrayHasKey('boolean', $options);
        $this->assertCount(count(FieldTypeEnum::cases()), $options);
    }
}
