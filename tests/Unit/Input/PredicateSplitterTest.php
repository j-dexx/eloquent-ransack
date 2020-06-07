<?php

namespace Jdexx\EloquentRansack\Tests\Unit\Input;

use Jdexx\EloquentRansack\Input\PredicateSplitter;
use Jdexx\EloquentRansack\Tests\TestCase;

class PredicateSplitterTest extends TestCase
{
    public function test_splits_on_underscore(): void
    {
        $input = [
            'column_eq' => 'abc',
        ];
        $splitter = new PredicateSplitter($input);

        $result = $splitter->call();

        $this->assertIsArray($result);
        $attributeData = $result[0];
        $this->assertIsArray($attributeData);
        $this->assertEquals('column', $attributeData['attribute']);
        $this->assertEquals('eq', $attributeData['predicate']);
        $this->assertEquals('abc', $attributeData['value']);
    }

    public function test_splits_on_last_underscore(): void
    {
        $input = [
            'longer_column_eq' => 'abc',
        ];
        $splitter = new PredicateSplitter($input);

        $result = $splitter->call();

        $this->assertIsArray($result);
        $attributeData = $result[0];
        $this->assertIsArray($attributeData);
        $this->assertEquals('longer_column', $attributeData['attribute']);
        $this->assertEquals('eq', $attributeData['predicate']);
        $this->assertEquals('abc', $attributeData['value']);
    }

    public function test_splits_on_longest_predicate(): void
    {
        $input = [
            'column_not_in' => 'abc',
        ];
        $splitter = new PredicateSplitter($input);

        $result = $splitter->call();

        $this->assertIsArray($result);
        $attributeData = $result[0];
        $this->assertIsArray($attributeData);
        $this->assertEquals('not_in', $attributeData['predicate']);
    }
}
