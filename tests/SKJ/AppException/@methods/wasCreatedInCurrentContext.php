<?php
/**
 * @noinspection NonAsciiCharacters PhpRedundantCatchClauseInspection
 */

// このﾌｧｲﾙの名前空間の定義
namespace SKJ\Test\AppExceptionTest;

// 別名定義
use SKJ\AppException;
use SKJ\Test\AppExceptionTest;

trait wasCreatedInCurrentContext
{
    /**
     * @test
     * @throws \InvalidArgumentException VisibilityBreakingWrapperのｺﾝｽﾄﾗｸﾀで発生
     */
    public function wasCreatedInCurrentContextのﾃｽﾄ()
    {
        try {
            throw new AppException();
        } catch (AppException $e) {
            $this->assertTrue($e->wasCreatedInCurrentContext());
        }

        $e = new AppException();
        $this->assertTrue($e->wasCreatedInCurrentContext());

        try {
            $this->parts_test_func04();
        } catch (AppException $e) {
            $this->assertFalse($e->wasCreatedInCurrentContext());
        }

        try {
            testFunc();
        } catch (AppException $e) {
            $this->assertFalse($e->wasCreatedInCurrentContext());
        }

        try {
            testFunc2();
        } catch (AppException $e) {
            $this->assertFalse($e->wasCreatedInCurrentContext());
        }

        try {
            $this->parts_test_func07();
        } catch (AppException $e) {
            $this->assertFalse($e->wasCreatedInCurrentContext());
        }

        $func = function (){
            throw new AppException();
        };

        try {
            $func();
        } catch (AppException $e) {
            $this->assertFalse($e->wasCreatedInCurrentContext());
        }

        try {
            AppExceptionTest::parts_test_func08();
        } catch (AppException $e) {
            $this->assertFalse($e->wasCreatedInCurrentContext());
        }

        // requireﾃｽﾄ(require先は同じｽｺｰﾌﾟ)
        try {
            /** @noinspection PhpUndefinedConstantInspection PhpIncludeInspection */
            require(DATA_DIR.'require.php');
        } catch (AppException $e) {
            $this->assertFalse($e->wasCreatedInCurrentContext());
        }

        // 上位で作成した例外を下位でﾁｪｯｸ
        $e = new AppException();
        $e = call_user_func(
            function () use ($e){

                $this->assertFalse($e->wasCreatedInCurrentContext());

                return new AppException();
            }
        );

        // 下位で作成した例外を上位でﾁｪｯｸ
        $this->assertFalse($e->wasCreatedInCurrentContext());

        // こことは別の同一階層で作られた例外をﾁｪｯｸ
        call_user_func(
            function () use ($e){

                $this->assertFalse($e->wasCreatedInCurrentContext());
            }
        );

        // call_user_func挟まないｹｰｽ
        $func = function (){

            return new AppException();
        };
        $e = $func();
        $func = function (AppException $e){

            $this->assertFalse($e->wasCreatedInCurrentContext());
        };
        $func($e);

        // ﾃﾞﾊﾞｯｸﾞﾄﾚｰｽの変更が可能か?
        $e = new AppException();
        $this->assertFalse($e->wasCreatedInCurrentContext(debug_backtrace()));

        try {
            /** @noinspection PhpDynamicAsStaticMethodCallInspection */
            AppExceptionTest::parts_test_func09();
        } catch (AppException $e) {
            // ﾘﾌﾛｰしたのが違うｽｺｰﾌﾟなので!!
            $this->assertFalse($e->wasCreatedInCurrentContext());
        }

        $e = new AppException();

        // 上位階層で発生
        $this->assertTrue($e->wasCreatedInCurrentContext());
        $this->assertFalse($this->levelTest($e));
        $this->assertFalse($this->levelTest2($e));

        // 違う(兄弟)ﾙｰﾄで発生
        $e = $this->dummyFuncX();
        $this->assertFalse($e->wasCreatedInCurrentContext());
        $this->assertFalse($this->dummyFuncX2($e));
    }

    /**
     * @return \SKJ\AppException
     */
    private function dummyFuncX()
    {
        return new AppException();
    }

    /**
     * @param \SKJ\AppException $e
     * @return bool
     */
    private function dummyFuncX2(AppException $e)
    {
        return $e->wasCreatedInCurrentContext();
    }
}

