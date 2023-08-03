<?php

namespace Tests\Unit;

use Tests\TestCase;

class TranslationTest extends TestCase
{
    const SIMPLE_KEY  = 'some_simple_key';
    const COMPLEX_KEY = 'some.complex.key';
    const COMPLEX_KEY_PART = 'some.complex';

    const SIMPLE_VALUE  = "some simple value";
    const COMPLEX_VALUE = "some complex value";

    const VARIABLE_KEYS   = [
        'some.variable1.key',
        'some.variable2.key'
    ];

    const VARIABLE_VALUE_REPLACED = 'some variable value';

    const VARIABLE_VALUES   = [
        'some :variable value',
        'some {variable} value'
    ];

    public function __construct(string $name)
    {

        parent::__construct($name);
    }

    public function test_translation_simple(): void
    {
        $this->assertEquals(self::SIMPLE_VALUE, ___(self::SIMPLE_KEY));
    }

    public function test_translation_simple_not_found(): void
    {
        $this->assertEquals(self::SIMPLE_KEY . '1', ___(self::SIMPLE_KEY . '1'));
    }

    public function test_translation_complex(): void
    {
        $this->assertEquals(self::COMPLEX_VALUE, ___(self::COMPLEX_KEY));
    }

    public function test_translation_complex_not_found(): void
    {
        $this->assertEquals(self::COMPLEX_KEY . '1', ___(self::COMPLEX_KEY . '1'));
    }

    public function test_translation_complex_part_object_found(): void
    {
        $this->assertEquals(self::COMPLEX_KEY_PART, ___(self::COMPLEX_KEY_PART));
    }

    public function test_translation_variables(): void
    {
        foreach (self::VARIABLE_KEYS as $key) {
            $this->assertEquals(
                self::VARIABLE_VALUE_REPLACED,
                ___($key, ['variable' => 'variable']),
            );
        }
    }

    public function test_translation_variables_replace_error(): void
    {
        foreach (self::VARIABLE_KEYS as $idx => $key) {
            $this->assertEquals(
                self::VARIABLE_VALUES[$idx],
                ___($key, ['variable11' => 'variable']),
            );
        }
    }

    public function test_translation_null_key(): void
    {
        $this->assertEquals('', ___(null));
    }

    public function test_translation_null_key_concatenation(): void
    {
        $this->assertEquals('concat', ___(null) . 'concat');
    }
}
