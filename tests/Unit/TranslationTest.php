<?php

namespace Tests\Unit;

use Tests\TestCase;

class TranslationTest extends TestCase
{
    const SIMPLE_KEY  = 'some_simple_key';
    const COMPLEX_KEY = 'some.complex.key';

    const SIMPLE_VALUE  = "some simple value";
    const COMPLEX_VALUE = "some complex value";

    const VARIABLE_KEYS   = [
        ':%s'  => 'some.variable1.key',
        '{%s}' => 'some.variable2.key'
    ];

    const VARIABLE_VALUES = [
        ':%s'  => 'some :variable value',
        '{%s}' => 'some {variable} value'
    ];

    public function __construct(string $name)
    {

        parent::__construct($name);
    }

    /**
     * A basic unit test example.
     */
    public function test_translation_simple(): void
    {
        $this->assertEquals(self::SIMPLE_VALUE, ___(self::SIMPLE_KEY));
    }

    /**
     * A basic unit test example.
     */
    public function test_translation_simple_not_found(): void
    {
        $this->assertEquals(self::SIMPLE_KEY . '1', ___(self::SIMPLE_KEY . '1'));
    }

    /**
     * A basic unit test example.
     */
    public function test_translation_complex(): void
    {
        $this->assertEquals(self::COMPLEX_VALUE, ___(self::COMPLEX_KEY));
    }

    /**
     * A basic unit test example.
     */
    public function test_translation_complex_not_found(): void
    {
        $this->assertEquals(self::COMPLEX_KEY . '1', ___(self::COMPLEX_KEY . '1'));
    }

    /**
     * A basic unit test example.
     */
    public function test_translation_variables(): void
    {
        foreach (self::VARIABLE_KEYS as $pattern => $key) {
            $this->assertEquals(
                ___(self::VARIABLE_KEYS[$pattern], ['variable' => 'variable']),
                str_replace(sprintf($pattern, 'variable'), 'variable', self::VARIABLE_VALUES[$pattern])
            );
        }
    }
}
