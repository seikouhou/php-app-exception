<?php
/**
 * @noinspection NonAsciiCharacters
 */

// このﾌｧｲﾙの名前空間の定義
namespace SKJ\Test\AbstractValidationExceptionTest;

// 別名定義
use SKJ\Test\ValidationExceptionTest;

trait extractBy
{
    /**
     * @test
     * @throws \InvalidArgumentException VisibilityBreakのｺﾝｽﾄﾗｸﾀで発生
     */
    public function extractByのﾃｽﾄ()
    {
        $e1 = (new ValidationExceptionTest('e1', 1))->setFields('name')
            ->setStatusCode('e1s');
        $e2 = (new ValidationExceptionTest('e2', 2, $e1))->setFields('age')
            ->setStatusCode('e2s');
        $e3 = (new ValidationExceptionTest('e3', 3, $e2))->setFields('sex')
            ->setStatusCode('e3s');
        $e4 = (new ValidationExceptionTest('e4', 4, $e3))->setFields(
            'address',
            'age'
        )->setStatusCode('e4s');
        $e5 = (new ValidationExceptionTest('e5', 5, $e4))->setFields(
            'name',
            'sex',
            'address'
        )->setStatusCode('e5s');

        $this->assertNull($e5->extractBy(['job' => null]));
        $this->assertNull($e5->extractBy([]));

        /**
         * @var ValidationExceptionTest $e
         */

        $e = $e5->extractBy(['age' => null]);
        $this->assertSame(['address', 'age'], $e->getFields());
        $this->assertSame('e4', $e->getMessage());
        $this->assertSame(4, $e->getCode());
        $this->assertSame('e4s', $e->getStatusCode());
        $this->assertTrue($e->wasCreatedInCurrentContext());
        $e = $e->getPrevious();
        $this->assertSame(['age'], $e->getFields());
        $this->assertSame('e2', $e->getMessage());
        $this->assertSame(2, $e->getCode());
        $this->assertSame('e2s', $e->getStatusCode());
        $this->assertTrue($e->wasCreatedInCurrentContext());
        $this->assertNull($e->getPrevious());

        $e = $e5->extractBy(['age' => null], false);
        $this->assertSame(['age'], $e->getFields());
        $this->assertSame('e2', $e->getMessage());
        $this->assertSame(2, $e->getCode());
        $this->assertSame('e2s', $e->getStatusCode());
        $this->assertTrue($e->wasCreatedInCurrentContext());
        $this->assertNull($e->getPrevious());

        $e = $e5->extractBy(['age' => 'year']);
        $this->assertSame(['address', 'year'], $e->getFields());
        $this->assertSame('e4', $e->getMessage());
        $this->assertSame(4, $e->getCode());
        $this->assertSame('e4s', $e->getStatusCode());
        $this->assertTrue($e->wasCreatedInCurrentContext());
        $e = $e->getPrevious();
        $this->assertSame(['year'], $e->getFields());
        $this->assertSame('e2', $e->getMessage());
        $this->assertSame(2, $e->getCode());
        $this->assertSame('e2s', $e->getStatusCode());
        $this->assertTrue($e->wasCreatedInCurrentContext());
        $this->assertNull($e->getPrevious());

        $e = $e5->extractBy(['age' => 'year'], false);
        $this->assertSame(['year'], $e->getFields());
        $this->assertSame('e2', $e->getMessage());
        $this->assertSame(2, $e->getCode());
        $this->assertSame('e2s', $e->getStatusCode());
        $this->assertTrue($e->wasCreatedInCurrentContext());
        $this->assertNull($e->getPrevious());

        $e = $e5->extractBy(['address' => null, 'name' => 'nic']);
        $this->assertSame(['nic', 'sex', 'address'], $e->getFields());
        $this->assertSame('e5', $e->getMessage());
        $this->assertSame(5, $e->getCode());
        $this->assertSame('e5s', $e->getStatusCode());
        $this->assertTrue($e->wasCreatedInCurrentContext());
        $e = $e->getPrevious();
        $this->assertSame(['address', 'age'], $e->getFields());
        $this->assertSame('e4', $e->getMessage());
        $this->assertSame(4, $e->getCode());
        $this->assertSame('e4s', $e->getStatusCode());
        $this->assertTrue($e->wasCreatedInCurrentContext());
        $e = $e->getPrevious();
        $this->assertSame(['nic'], $e->getFields());
        $this->assertSame('e1', $e->getMessage());
        $this->assertSame(1, $e->getCode());
        $this->assertSame('e1s', $e->getStatusCode());
        $this->assertTrue($e->wasCreatedInCurrentContext());
        $this->assertNull($e->getPrevious());
    }
}
