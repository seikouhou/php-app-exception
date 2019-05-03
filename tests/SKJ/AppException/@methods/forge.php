<?php
/**
 * @noinspection NonAsciiCharacters PhpRedundantCatchClauseInspection
 */

// このﾌｧｲﾙの名前空間の定義
namespace SKJ\Test\AppExceptionTest;

// 別名定義

use SKJ\AppException;
use SKJ\Test\AppExceptionTest;

trait forge
{
    /**
     * @test
     * @throws \InvalidArgumentException VisibilityBreakingWrapperのｺﾝｽﾄﾗｸﾀで発生
     */
    public function forgeのﾃｽﾄ()
    {
        try {
            $this->parts_test_func04();
        } catch (AppException $e) {
            $this->assertFalse($e->wasCreatedInCurrentContext());
        }

        try {
            try {
                $this->parts_test_func04();
            } catch (AppException $x) {
                throw $x->forge();
            }
        } catch (AppException $e) {
            $this->assertTrue($e->wasCreatedInCurrentContext());
        }

        // 引数ﾃｽﾄ
        try {
            try {
                $this->parts_test_func04();
            } catch (AppException $x) {
                throw $x->forge(debug_backtrace());
            }
        } catch (AppException $e) {
            $this->assertFalse($e->wasCreatedInCurrentContext());
        }

        try {
            try {
                $this->parts_test_func04();
            } catch (AppException $x) {
                throw $x->forge((new AppException())->getCallQueue());
            }
        } catch (AppException $e) {
            $this->assertTrue($e->wasCreatedInCurrentContext());
        }

        try {
            try {
                testFunc();
            } catch (AppException $x) {
                throw $x->forge();
            }
        } catch (AppException $e) {
            $this->assertTrue($e->wasCreatedInCurrentContext());
        }

        try {
            try {
                testFunc2();
            } catch (AppException $x) {
                throw $x->forge();
            }
        } catch (AppException $e) {
            $this->assertTrue($e->wasCreatedInCurrentContext());
        }

        try {
            try {
                $this->parts_test_func07();
            } catch (AppException $x) {
                throw $x->forge();
            }
        } catch (AppException $e) {
            $this->assertTrue($e->wasCreatedInCurrentContext());
        }

        $func = function (){
            throw new AppException();
        };

        try {
            try {
                $func();
            } catch (AppException $x) {
                throw $x->forge();
            }
        } catch (AppException $e) {
            $this->assertTrue($e->wasCreatedInCurrentContext());
        }

        try {
            try {
                AppExceptionTest::parts_test_func08();
            } catch (AppException $x) {
                throw $x->forge();
            }
        } catch (AppException $e) {
            $this->assertTrue($e->wasCreatedInCurrentContext());
        }
    }
}
