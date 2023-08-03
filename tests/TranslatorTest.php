<?php

namespace Tests;

use Orchestra\Testbench\TestCase;

class TranslatorTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        app()['path.lang'] = __DIR__ . '/lang';
    }

    public function test_simple(): void
    {
        $this->assertEquals('some simple value', ___('some_simple_key'));
    }

    public function test_simple_with_dot(): void
    {
        $this->assertEquals('some simple value for key with dot', ___('some_simple.key_with_dot'));
    }

    public function test_simple_with_dot_and_variable1(): void
    {
        $this->assertEquals('some simple Argh for key with dot', ___('some_simple.key_with_dot_variable1', ['variable' => 'Argh']));
    }

    public function test_simple_with_dot_and_variable2(): void
    {
        $this->assertEquals('some simple Argh for key with dot', ___('some_simple.key_with_dot_variable2', ['variable' => 'Argh']));
    }

    public function test_simple_with_locale_ru(): void
    {
        $this->assertEquals('какое-то простое значение', ___('some_simple_key', locale: 'ru'));
    }

    public function test_simple_not_found(): void
    {
        $this->assertEquals('some_simple_key_wrong', ___('some_simple_key_wrong'));
    }

    public function test_complex(): void
    {
        $this->assertEquals('some complex value', ___('some.complex.key'));
    }

    public function test_complex_with_locale_ru(): void
    {
        $this->assertEquals('какое-то комплексное значение', ___('some.complex.key', locale: 'ru'));
    }

    public function test_complex_not_found(): void
    {
        $this->assertEquals('some.complex.wrong.key', ___('some.complex.wrong.key'));
    }

    public function test_complex_part_object_found(): void
    {
        $this->assertEquals('some.complex', ___('some.complex'));
    }

    public function test_variables_capital_first_letter(): void
    {
        $this->assertEquals('some Test value', ___('some.variable1.key_capital_first_letter', [
            'variable' => 'test'
        ]));

        $this->assertEquals('some Test value', ___('some.variable2.key_capital_first_letter', [
            'variable' => 'test'
        ]));
    }

    public function test_variables_capital_all_letters(): void
    {
        $this->assertEquals('some TEST value', ___('some.variable1.key_capital_all_letters', [
            'variable' => 'test'
        ]));

        $this->assertEquals('some TEST value', ___('some.variable2.key_capital_all_letters', [
            'variable' => 'test'
        ]));
    }

    public function test_variables(): void
    {
        $this->assertEquals('some test value', ___('some.variable1.key', [
            'variable' => 'test'
        ]));

        $this->assertEquals('some test value', ___('some.variable2.key', [
            'variable' => 'test'
        ]));
    }

    public function test_variables_twice(): void
    {
        $this->assertEquals('some test value and test value', ___('some.variable1.key_twice', [
            'variable' => 'test'
        ]));

        $this->assertEquals('some test value and test value', ___('some.variable2.key_twice', [
            'variable' => 'test'
        ]));
    }

    public function test_variables_many(): void
    {
        $this->assertEquals('some test value and other test value', ___('some.variable1.many_keys', [
            'variable' => 'test',
            'other_variable' => 'other test',
        ]));

        $this->assertEquals('some test value and other test value', ___('some.variable2.many_keys', [
            'variable' => 'test',
            'other_variable' => 'other test',
        ]));
    }

    public function test_variables_replace_error(): void
    {
        $this->assertEquals('some :variable value', ___('some.variable1.key', [
            'variable_wrong' => 'test'
        ]));

        $this->assertEquals('some {variable} value', ___('some.variable2.key', [
            'variable_wrong' => 'test'
        ]));
    }

    public function test_null_key(): void
    {
        /** @noinspection PhpRedundantOptionalArgumentInspection */
        $this->assertEquals('', ___(null));
    }

    public function test_empty_key(): void
    {
        $this->assertEquals('', ___(''));
    }
}
