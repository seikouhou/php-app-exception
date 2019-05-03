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

trait setMessage
{
    /**
     * @test
     * @throws \InvalidArgumentException VisibilityBreakingWrapperのｺﾝｽﾄﾗｸﾀで発生
     */
    public function setMessageのﾃｽﾄ()
    {
        /**
         * @var AppException $testTarget
         */
        $testTarget = new VisibilityBreakingWrapper(new AppException());

        $this->assertSame(
            $testTarget->getMessage(),
            '例外が発生しました'
        );

        $testTarget->setMessage('benyy');
        $this->assertSame(
            $testTarget->getMessage(),
            'benyy'
        );
        $testTarget->setMessage(1);
        $this->assertSame(
            $testTarget->getMessage(),
            '1'
        );
    }
}
