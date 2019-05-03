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

trait setSortOrder
{
    /**
     * @test
     * @throws \InvalidArgumentException VisibilityBreakingWrapperのｺﾝｽﾄﾗｸﾀで発生
     */
    public function setSortOrderのﾃｽﾄ()
    {
        /**
         * @var AppException|VisibilityBreakingWrapper $testTarget
         */
        $testTarget = new VisibilityBreakingWrapper(new AppException());

        $this->assertSame(
            $testTarget->setSortOrder(AppException::SORT_ORDER_ASC),
            $testTarget->getTestTargetObject()
        );
        $this->assertSame(
            $testTarget->iteratorSortOrder,
            AppException::SORT_ORDER_ASC
        );

        $this->assertSame(
            $testTarget->setSortOrder(AppException::SORT_ORDER_DESC),
            $testTarget->getTestTargetObject()
        );
        $this->assertSame(
            $testTarget->iteratorSortOrder,
            AppException::SORT_ORDER_DESC
        );

        $this->assertSame(
            $testTarget->setSortOrder(100),
            $testTarget->getTestTargetObject()
        );
        $this->assertSame(
            $testTarget->iteratorSortOrder,
            AppException::SORT_ORDER_DESC
        );
    }
}
