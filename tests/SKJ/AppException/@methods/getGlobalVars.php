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

trait getGlobalVars
{
    /**
     * @test
     * @throws \InvalidArgumentException VisibilityBreakingWrapperのｺﾝｽﾄﾗｸﾀで発生
     */
    public function getGlobalVarsのﾃｽﾄ()
    {
        /**
         * @var AppException $testTarget
         */
        $testTarget = new VisibilityBreakingWrapper(
            new AppException(
                null,
                null,
                null,
                AppException::OPT_GLOBAL_VARS_SNAPSHOT
            )
        );
        $this->assertSame(
            $testTarget->getGlobalVars(),
            $GLOBALS
        );
    }
}
