<?php

namespace Atournayre\Assert\Tests;

use Atournayre\Assert\Assert;
use PHPUnit\Framework\TestCase;

class AssertTest extends TestCase
{
    /**
     * @throws \InvalidArgumentException
     */
    public function testIsListOfString(): void
    {
        try {
            Assert::isListOf(['1'], Assert::TYPE_STRING);
            $this->assertTrue(true);
        } catch (\InvalidArgumentException $e) {
            throw $e;
        }
    }

    public function testIsNotListOfStringThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Assert::isListOf(['1', new \stdClass()], Assert::TYPE_STRING);
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function testIsMapOfString(): void
    {
        try {
            Assert::isMapOf(['a' => 'a'], Assert::TYPE_STRING);
            $this->assertTrue(true);
        } catch (\InvalidArgumentException $e) {
            throw $e;
        }
    }

    public function testIsNotMapOfStringThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Assert::isMapOf(['a' => 'a', 'b' => new \stdClass()], Assert::TYPE_STRING);
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function testAllIsTypeString(): void
    {
        try {
            Assert::allIsType(['1'], Assert::TYPE_STRING);
            $this->assertTrue(true);
        } catch (\InvalidArgumentException $e) {
            throw $e;
        }
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function testAllIsTypeInt(): void
    {
        try {
            Assert::allIsType([1], Assert::TYPE_INT);
            $this->assertTrue(true);
        } catch (\InvalidArgumentException $e) {
            throw $e;
        }
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function testAllIsTypeFloat(): void
    {
        try {
            Assert::allIsType([1.0], Assert::TYPE_FLOAT);
            $this->assertTrue(true);
        } catch (\InvalidArgumentException $e) {
            throw $e;
        }
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function testAllIsTypeBool(): void
    {
        try {
            Assert::allIsType([true], Assert::TYPE_BOOL);
            $this->assertTrue(true);
        } catch (\InvalidArgumentException $e) {
            throw $e;
        }
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function testAllIsTypeArray(): void
    {
        try {
            Assert::allIsType([[]], Assert::TYPE_ARRAY);
            $this->assertTrue(true);
        } catch (\InvalidArgumentException $e) {
            throw $e;
        }
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function testAllIsTypeNull(): void
    {
        try {
            Assert::allIsType([null], Assert::TYPE_NULL);
            $this->assertTrue(true);
        } catch (\InvalidArgumentException $e) {
            throw $e;
        }
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function testAllIsTypeObject(): void
    {
        try {
            Assert::allIsType([new \stdClass()], Assert::TYPE_OBJECT);
            $this->assertTrue(true);
        } catch (\InvalidArgumentException $e) {
            throw $e;
        }
    }
}
