<?php
/**
 * @noinspection NonAsciiCharacters
 */

// このﾌｧｲﾙの名前空間の定義
namespace SKJ\Test\AppExceptionTest;

// 別名定義
use SKJ\AppException;
use SKJ\AppException\LogicException;
use SKJ\AppException\RuntimeException;
use VisibilityBreakingWrapper;

/** @noinspection PhpUndefinedClassInspection */

trait getIterator
{
    /**
     * @test
     * @throws \InvalidArgumentException VisibilityBreakingWrapperのｺﾝｽﾄﾗｸﾀで発生
     */
    public function getIteratorのﾃｽﾄ()
    {
        $e1 = new AppException();
        $e2 = new LogicException(null, null, $e1);
        $e3 = new LogicException(null, null, $e2);
        $e4 = new RuntimeException(null, null, $e3);
        $e6 = new LogicException(null, null, $e4);
        $e7 = new RuntimeException(null, null, $e6);
        $e = new AppException(null, null, $e7);

        $this->assertSame(
            (new VisibilityBreakingWrapper($e))->iteratorTargetArray,
            null
        );

        $result = [];
        foreach ($e as $exp) {
            $result[] = $exp;
        }

        $this->assertSame(
            $result,
            [$e, $e7, $e6, $e4, $e3, $e2, $e1]
        );

        $result = [];
        foreach ($e as $exp) {
            $result[] = $exp;
        }

        $this->assertSame(
            $result,
            [$e, $e7, $e6, $e4, $e3, $e2, $e1]
        );

        $e->setSortOrder(AppException::SORT_ORDER_ASC);
        $result = [];
        foreach ($e as $exp) {
            $result[] = $exp;
        }

        $this->assertSame(
            $result,
            [$e1, $e2, $e3, $e4, $e6, $e7, $e]
        );

        $e->setSortOrder(AppException::SORT_ORDER_DESC);
        $result = [];
        foreach ($e as $exp) {
            $result[] = $exp;
        }

        $this->assertSame(
            $result,
            [$e, $e7, $e6, $e4, $e3, $e2, $e1]
        );
    }
}
