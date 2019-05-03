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

trait setFilter
{
    /**
     * @test
     * @throws \InvalidArgumentException VisibilityBreakingWrapperのｺﾝｽﾄﾗｸﾀで発生
     */
    public function setFilterのﾃｽﾄ()
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

        $e->setFilter();
        $result = [];
        foreach ($e as $exp) {
            $result[] = $exp;
        }

        $this->assertSame(
            $result,
            [$e, $e1]
        );

        $e->setFilter('SKJ\AppException\RuntimeException');
        $result = [];
        foreach ($e as $exp) {
            $result[] = $exp;
        }

        $this->assertSame(
            $result,
            [$e7, $e4]
        );

        $e->setFilter('SKJ\AppException\LogicException');
        $result = [];
        foreach ($e as $exp) {
            $result[] = $exp;
        }

        $this->assertSame(
            $result,
            [$e6, $e3, $e2]
        );

        $e->setFilter('SKJ\AppException\LogicException')->setSortOrder(
            AppException::SORT_ORDER_DESC
        );
        $result = [];
        foreach ($e as $exp) {
            $result[] = $exp;
        }

        $this->assertSame(
            $result,
            [$e6, $e3, $e2]
        );

        $e->setFilter('SKJ\AppException\LogicException')->setSortOrder(
            AppException::SORT_ORDER_ASC
        );
        $result = [];
        foreach ($e as $exp) {
            $result[] = $exp;
        }

        $this->assertSame(
            $result,
            [$e2, $e3, $e6]
        );

        $e->setFilter('SKJ\AppException\Logic\ContainerException');
        $result = [];
        foreach ($e as $exp) {
            $result[] = $exp;
        }

        $this->assertSame(
            $result,
            []
        );

        $e->setFilter('SKJ\AppException\HttpException');
        $result = [];
        foreach ($e as $exp) {
            $result[] = $exp;
        }

        $this->assertSame(
            $result,
            []
        );
    }
}
