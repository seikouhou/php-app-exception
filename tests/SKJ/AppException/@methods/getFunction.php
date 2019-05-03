<?php
/**
 * @noinspection NonAsciiCharacters
 */

// このﾌｧｲﾙの名前空間の定義
namespace SKJ\Test\AppExceptionTest;

// 別名定義
use SKJ\AppException;
use SKJ\AppException\HTTP\ForbiddenException;
use SKJ\AppException\HttpException;
use VisibilityBreakingWrapper;

/** @noinspection PhpUndefinedClassInspection */

trait getFunction
{
    /**
     * @test
     * @throws \InvalidArgumentException VisibilityBreakingWrapperのｺﾝｽﾄﾗｸﾀで発生
     */
    public function getFunctionのﾃｽﾄ()
    {
        /**
         * @var AppException $testTarget
         */
        $testTarget = new VisibilityBreakingWrapper(new AppException());
        $this->assertSame(
            'SKJ\AppException::__construct',
            $testTarget->getFunction()
        );
        $testTarget = new VisibilityBreakingWrapper(new HttpException());
        $this->assertSame(
            'SKJ\AppException\HttpException::__construct',
            $testTarget->getFunction()
        );
        $testTarget = new VisibilityBreakingWrapper(new ForbiddenException());
        $this->assertSame(
            'SKJ\AppException\HTTP\ForbiddenException::__construct',
            $testTarget->getFunction()
        );
    }
}
