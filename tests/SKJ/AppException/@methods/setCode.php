<?php
/**
 * @noinspection NonAsciiCharacters
 */

// このﾌｧｲﾙの名前空間の定義
namespace SKJ\Test\AppExceptionTest;

// 別名定義
use SKJ\AppException;
use VisibilityBreakingWrapper;

/** @noinspection PhpUndefinedClassInspection */

trait setCode
{
    /**
     * @test
     * @throws \InvalidArgumentException VisibilityBreakingWrapperのｺﾝｽﾄﾗｸﾀで発生
     */
    public function setCodeのﾃｽﾄ()
    {
        /**
         * @var AppException $testTarget
         */
        $testTarget = new VisibilityBreakingWrapper(new AppException());

        $this->assertSame(
            $testTarget->getCode(),
            1000
        );

        $testTarget->setCode('benyy');
        $this->assertSame(
            $testTarget->getCode(),
            1000
        );
        $testTarget->setCode(1475);
        $this->assertSame(
            $testTarget->getCode(),
            1475
        );
    }
}

