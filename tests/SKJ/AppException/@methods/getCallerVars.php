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

trait getCallerVars
{
    /**
     * @test
     * @throws \InvalidArgumentException VisibilityBreakingWrapperのｺﾝｽﾄﾗｸﾀで発生
     */
    public function getCallerVarsのﾃｽﾄ()
    {
        $a = [1, 2, 3];
        $b = 'benyy';

        /**
         * @var AppException $testTarget
         */
        if (AppException::isExtension()) {

            for ($i = 0; $i < 1; ++$i) {

                $testTarget = null;
                $testTarget = new VisibilityBreakingWrapper(
                    new AppException(
                        null,
                        null,
                        null,
                        AppException::OPT_CALLER_VARS_SNAPSHOT
                    )
                );

                $this->assertEquals(
                    $testTarget->getCallerVars(),
                    [
                        'a' => $a,
                        'b' => $b,
                        'this' => $this,
                        'i' => $i,
                        'testTarget' => null,
                    ]
                );
            }

        } else {

            $testTarget = new VisibilityBreakingWrapper(
                new AppException(
                    null, null, null, AppException::OPT_CALLER_VARS_SNAPSHOT
                )
            );

            $this->assertSame(
                $testTarget->getCallerVars(),
                []
            );
        }
    }
}
