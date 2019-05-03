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

trait resetFilter
{
    /**
     * @test
     * @throws \InvalidArgumentException VisibilityBreakingWrapperのｺﾝｽﾄﾗｸﾀで発生
     */
    public function resetFilterのﾃｽﾄ()
    {
        /**
         * @var AppException|VisibilityBreakingWrapper $testTarget
         */
        $testTarget = new VisibilityBreakingWrapper(new AppException());

        $this->assertSame(
            $testTarget->resetFilter(),
            $testTarget->getTestTargetObject()
        );
        $this->assertSame(
            $testTarget->iteratorTargetArray,
            null
        );
    }
}
