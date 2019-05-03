<?php
/**
 * @noinspection NonAsciiCharacters
 */

// このﾌｧｲﾙの名前空間の定義
namespace SKJ\Test\AppExceptionTest;

// 別名定義
use Exception;
use PHPUnit\Framework\CustomTest\UtTestClass;
use SKJ\AppException;
use SKJ\AppException\HttpException;
use SKJ\AppException\Logic\ContainerException;
use SKJ\AppException\LogicException;
use SKJ\AppException\RuntimeException;
use VisibilityBreakingWrapper;

trait __construct
{
    /**
     * @test
     * @throws \InvalidArgumentException VisibilityBreakingWrapperのｺﾝｽﾄﾗｸﾀで発生
     */
    public function __constructの引数_message_のﾃｽﾄ()
    {
        /**
         * @var AppException|VisibilityBreakingWrapper $testTarget
         */
        $testTarget = new VisibilityBreakingWrapper(new AppException());
        $this->assertSame(
            '例外が%sで発生しました',
            $testTarget->messageTemplate
        );
        $this->assertSame('例外が発生しました', $testTarget->defMessage);
        $this->assertSame('例外が発生しました', $testTarget->message);

        $testTarget =
            new VisibilityBreakingWrapper(new AppException('発生した例外'));
        $this->assertSame(
            '例外が%sで発生しました',
            $testTarget->messageTemplate
        );
        $this->assertSame('例外が発生しました', $testTarget->defMessage);
        $this->assertSame('発生した例外', $testTarget->message);

        $testTarget =
            new VisibilityBreakingWrapper(new AppException(['ｷﾙｷﾞｽﾀﾝ']));
        $this->assertSame('例外が発生しました', $testTarget->defMessage);
        $this->assertSame('例外がｷﾙｷﾞｽﾀﾝで発生しました', $testTarget->message);

        $testTarget = new VisibilityBreakingWrapper(new AppException([1]));
        $this->assertSame('例外が発生しました', $testTarget->defMessage);
        $this->assertSame('例外が1で発生しました', $testTarget->message);

        $testTarget = new VisibilityBreakingWrapper(new AppException([null]));
        $this->assertSame('例外が発生しました', $testTarget->defMessage);
        $this->assertSame('例外がで発生しました', $testTarget->message);

        $testTarget =
            new VisibilityBreakingWrapper(new HttpException(['ｷﾙｷﾞｽﾀﾝ']));
        $this->assertSame('Internal Server Error', $testTarget->defMessage);
        $this->assertSame('Internal Server Error', $testTarget->message);

        $testTarget = new VisibilityBreakingWrapper(new AppException(1));
        $this->assertSame('例外が発生しました', $testTarget->defMessage);
        $this->assertSame('例外が発生しました', $testTarget->message);

        $testTarget = new VisibilityBreakingWrapper(new RuntimeException());
        $this->assertSame(
            '%sで実行例外が発生しました',
            $testTarget->messageTemplate
        );
        $this->assertSame('実行例外が発生しました', $testTarget->defMessage);
        $this->assertSame('実行例外が発生しました', $testTarget->message);
    }

    /**
     * @test
     * @param mixed $testData ﾃｽﾄﾃﾞｰﾀ
     * @throws \InvalidArgumentException VisibilityBreakingWrapperのｺﾝｽﾄﾗｸﾀで発生
     * @dataProvider dp___constructの引数_code_の正常系ﾃｽﾄ
     */
    public function __constructの引数_code_の正常系ﾃｽﾄ($testData)
    {
        /**
         * @var AppException|VisibilityBreakingWrapper $testTarget
         */
        $testTarget =
            new VisibilityBreakingWrapper(new AppException(null, $testData));
        $this->assertSame(1000, $testTarget->defCode);
        $this->assertSame(
            is_null($testData) ? $testTarget->defCode : $testData,
            $testTarget->code
        );
    }

    public function dp___constructの引数_code_の正常系ﾃｽﾄ()
    {
        return $this->dataProviderTemplate(
            self::allowTypes(self::T_NULL, self::T_INT)
        );
    }

    /**
     * @test
     * @param mixed $testData ﾃｽﾄﾃﾞｰﾀ
     * @throws \InvalidArgumentException VisibilityBreakingWrapperのｺﾝｽﾄﾗｸﾀで発生
     * @dataProvider dp___constructの引数_code_の異常系ﾃｽﾄ
     */
    public function __constructの引数_code_の異常系ﾃｽﾄ($testData)
    {
        /**
         * @var AppException|VisibilityBreakingWrapper $testTarget
         */
        $testTarget =
            new VisibilityBreakingWrapper(new AppException(null, $testData));
        $this->assertSame($testTarget->defCode, $testTarget->code);
    }

    public function dp___constructの引数_code_の異常系ﾃｽﾄ()
    {
        return $this->dataProviderTemplate(
            self::denyTypes(self::T_NULL, self::T_INT)
        );
    }

    /**
     * @test
     * @throws \InvalidArgumentException VisibilityBreakingWrapperのｺﾝｽﾄﾗｸﾀで発生
     */
    public function __constructの引数_code_の初期値ﾃｽﾄ()
    {
        /**
         * @var AppException|VisibilityBreakingWrapper $testTarget
         */
        $testTarget = new VisibilityBreakingWrapper(new AppException());
        $this->assertSame(1000, $testTarget->code);
        $testTarget = new VisibilityBreakingWrapper(new RuntimeException());
        $this->assertSame(1100, $testTarget->code);
        $testTarget = new VisibilityBreakingWrapper(new LogicException());
        $this->assertSame(1200, $testTarget->code);
        $testTarget = new VisibilityBreakingWrapper(new ContainerException());
        $this->assertSame(1201, $testTarget->code);
    }

    /**
     * @test
     * @throws \InvalidArgumentException VisibilityBreakingWrapperのｺﾝｽﾄﾗｸﾀで発生
     */
    public function __constructの引数_previous_の正常系ﾃｽﾄ()
    {
        /**
         * @var AppException|VisibilityBreakingWrapper $testTarget
         */
        $testTarget = new VisibilityBreakingWrapper(new AppException());
        $this->assertSame(null, $testTarget->getPrevious());
        $testTarget = new VisibilityBreakingWrapper(
            new AppException(null, null, new Exception())
        );
        $this->assertNotSame(new Exception(), $testTarget->getPrevious());
        $e = new AppException();
        $testTarget =
            new VisibilityBreakingWrapper(new AppException(null, null, $e));
        $this->assertSame($e, $testTarget->getPrevious());
        $e = new Exception();
        $testTarget =
            new VisibilityBreakingWrapper(new AppException(null, null, $e));
        $this->assertNotSame($e, $testTarget->getPrevious());
        $this->assertSame(
            'SKJ\AppException',
            get_class($testTarget->getPrevious())
        );
    }

    /**
     * これはｴｸｽﾃﾝｼｮﾝ組み込み状態ではﾃｽﾄできない
     * ｴｸｽﾃﾝｼｮﾝを組み込んでいるとｴﾗｰ発生時のｺｰﾙｽﾀｯｸのﾌｧｲﾙ、行が空欄になる
     * (理由:Cｺｰﾄﾞ上で発生している為、phpｺｰﾄﾞとしての発生場所は存在しないから)
     * その状態でset_error_handler()で例外を作成して投げても、例外が遡上できない。
     * なぜなら、ｺｰﾙｽﾀｯｸを辿る過程でﾌｧｲﾙ、行無しのｴﾝﾄﾘで諦めてしまい、ﾀﾞｲﾚｸﾄに最上位に移動してしまうから
     * そうすると、当然PHPUnitの expectedException ｱﾉﾃｰｼｮﾝは例外を拾ってくれない
     *
     * @throws \InvalidArgumentException VisibilityBreakingWrapperのｺﾝｽﾄﾗｸﾀで発生
     * @expectedException \ErrorException
     */
    public function __constructの引数_previous_の異常系ﾃｽﾄ()
    {
        /**
         * @var AppException|VisibilityBreakingWrapper $testTarget
         */
        $e = new UtTestClass();
        /** @noinspection PhpParamsInspection */
        $testTarget =
            new VisibilityBreakingWrapper(new AppException(null, null, $e));
        $this->assertNotSame($e, $testTarget->getPrevious());
    }

    /**
     * @test
     * @throws \InvalidArgumentException VisibilityBreakingWrapperのｺﾝｽﾄﾗｸﾀで発生
     */
    public function __constructの引数_option_の正常系ﾃｽﾄ()
    {
        /**
         * @var FakeObject|VisibilityBreakingWrapper $testTarget
         */
        $testTarget = new VisibilityBreakingWrapper(
            new AppException(null, null, null, 0)
        );
        $this->assertSame([], $testTarget->globalVarsSnapShot);
        $this->assertSame([], $testTarget->callerVarsSnapShot);

        if (AppException::isExtension()) {

            $testTarget = new VisibilityBreakingWrapper(new AppException());
            $this->assertSame([], $testTarget->globalVarsSnapShot);
            $this->assertNotEquals([], $testTarget->callerVarsSnapShot);

            $testTarget = new VisibilityBreakingWrapper(new LogicException());
            $this->assertSame([], $testTarget->globalVarsSnapShot);
            $this->assertNotEquals([], $testTarget->callerVarsSnapShot);

            $testTarget = new VisibilityBreakingWrapper(
                new AppException(
                    null, null, null, AppException::OPT_CALLER_VARS_SNAPSHOT
                )
            );
            $this->assertSame([], $testTarget->globalVarsSnapShot);
            $this->assertNotEquals([], $testTarget->callerVarsSnapShot);

            $testTarget = new VisibilityBreakingWrapper(
                new AppException(
                    null, null, null, AppException::OPT_GLOBAL_VARS_SNAPSHOT
                )
            );
            $this->assertNotEquals([], $testTarget->globalVarsSnapShot);
            $this->assertSame([], $testTarget->callerVarsSnapShot);

            $testTarget = new VisibilityBreakingWrapper(
                new AppException(
                    null,
                    null,
                    null,
                    AppException::OPT_GLOBAL_VARS_SNAPSHOT |
                    AppException::OPT_CALLER_VARS_SNAPSHOT
                )
            );
            $this->assertNotEquals([], $testTarget->globalVarsSnapShot);
            $this->assertNotEquals([], $testTarget->callerVarsSnapShot);

            AppException::$enableGlobalVarsSnapShot = 1;
            AppException::$enableCallerVarsSnapShot = 1;

            $testTarget = new VisibilityBreakingWrapper(new AppException());
            $this->assertNotEquals([], $testTarget->globalVarsSnapShot);
            $this->assertNotEquals([], $testTarget->callerVarsSnapShot);

            $testTarget = new VisibilityBreakingWrapper(new LogicException());
            $this->assertNotEquals([], $testTarget->globalVarsSnapShot);
            $this->assertNotEquals([], $testTarget->callerVarsSnapShot);

            $testTarget = new VisibilityBreakingWrapper(
                new AppException(null, null, null, 0)
            );
            $this->assertSame([], $testTarget->globalVarsSnapShot);
            $this->assertSame([], $testTarget->callerVarsSnapShot);

            $testTarget = new VisibilityBreakingWrapper(
                new LogicException(null, null, null, 0)
            );
            $this->assertSame([], $testTarget->globalVarsSnapShot);
            $this->assertSame([], $testTarget->callerVarsSnapShot);

            LogicException::$enableGlobalVarsSnapShot = 0;
            LogicException::$enableCallerVarsSnapShot = 0;

            $testTarget = new VisibilityBreakingWrapper(new AppException());
            $this->assertSame([], $testTarget->globalVarsSnapShot);
            $this->assertSame([], $testTarget->callerVarsSnapShot);

            $testTarget = new VisibilityBreakingWrapper(new LogicException());
            $this->assertSame([], $testTarget->globalVarsSnapShot);
            $this->assertSame([], $testTarget->callerVarsSnapShot);

            $testTarget = new VisibilityBreakingWrapper(
                new AppException(
                    null,
                    null,
                    null,
                    AppException::OPT_GLOBAL_VARS_SNAPSHOT |
                    AppException::OPT_CALLER_VARS_SNAPSHOT
                )
            );
            $this->assertNotEquals([], $testTarget->globalVarsSnapShot);
            $this->assertNotEquals([], $testTarget->callerVarsSnapShot);

            $testTarget = new VisibilityBreakingWrapper(
                new LogicException(
                    null,
                    null,
                    null,
                    AppException::OPT_GLOBAL_VARS_SNAPSHOT |
                    AppException::OPT_CALLER_VARS_SNAPSHOT
                )
            );
            $this->assertNotEquals([], $testTarget->globalVarsSnapShot);
            $this->assertNotEquals([], $testTarget->callerVarsSnapShot);

        } else {

            $testTarget = new VisibilityBreakingWrapper(new AppException());
            $this->assertSame([], $testTarget->globalVarsSnapShot);
            $this->assertSame([], $testTarget->callerVarsSnapShot);

            $testTarget = new VisibilityBreakingWrapper(new LogicException());
            $this->assertSame([], $testTarget->globalVarsSnapShot);
            $this->assertSame([], $testTarget->callerVarsSnapShot);

            $testTarget = new VisibilityBreakingWrapper(
                new AppException(
                    null, null, null, AppException::OPT_GLOBAL_VARS_SNAPSHOT
                )
            );
            $this->assertNotEquals([], $testTarget->globalVarsSnapShot);
            $this->assertSame([], $testTarget->callerVarsSnapShot);

            $testTarget = new VisibilityBreakingWrapper(
                new AppException(
                    null, null, null, AppException::OPT_CALLER_VARS_SNAPSHOT
                )
            );
            $this->assertSame([], $testTarget->globalVarsSnapShot);
            $this->assertSame([], $testTarget->callerVarsSnapShot);

            $testTarget = new VisibilityBreakingWrapper(
                new AppException(
                    null,
                    null,
                    null,
                    AppException::OPT_GLOBAL_VARS_SNAPSHOT |
                    AppException::OPT_CALLER_VARS_SNAPSHOT
                )
            );
            $this->assertNotEquals([], $testTarget->globalVarsSnapShot);
            $this->assertSame([], $testTarget->callerVarsSnapShot);

            AppException::$enableGlobalVarsSnapShot = 1;
            AppException::$enableCallerVarsSnapShot = 1;

            $testTarget = new VisibilityBreakingWrapper(new AppException());
            $this->assertNotEquals([], $testTarget->globalVarsSnapShot);
            $this->assertSame([], $testTarget->callerVarsSnapShot);

            $testTarget = new VisibilityBreakingWrapper(new LogicException());
            $this->assertNotEquals([], $testTarget->globalVarsSnapShot);
            $this->assertSame([], $testTarget->callerVarsSnapShot);

            $testTarget = new VisibilityBreakingWrapper(
                new AppException(null, null, null, 0)
            );
            $this->assertSame([], $testTarget->globalVarsSnapShot);
            $this->assertSame([], $testTarget->callerVarsSnapShot);

            $testTarget = new VisibilityBreakingWrapper(
                new LogicException(null, null, null, 0)
            );
            $this->assertSame([], $testTarget->globalVarsSnapShot);
            $this->assertSame([], $testTarget->callerVarsSnapShot);

            LogicException::$enableGlobalVarsSnapShot = 0;
            LogicException::$enableCallerVarsSnapShot = 0;

            $testTarget = new VisibilityBreakingWrapper(new AppException());
            $this->assertSame([], $testTarget->globalVarsSnapShot);
            $this->assertSame([], $testTarget->callerVarsSnapShot);

            $testTarget = new VisibilityBreakingWrapper(new LogicException());
            $this->assertSame([], $testTarget->globalVarsSnapShot);
            $this->assertSame([], $testTarget->callerVarsSnapShot);

            $testTarget = new VisibilityBreakingWrapper(
                new AppException(
                    null,
                    null,
                    null,
                    AppException::OPT_GLOBAL_VARS_SNAPSHOT |
                    AppException::OPT_CALLER_VARS_SNAPSHOT
                )
            );
            $this->assertNotEquals([], $testTarget->globalVarsSnapShot);
            $this->assertSame([], $testTarget->callerVarsSnapShot);

            $testTarget = new VisibilityBreakingWrapper(
                new LogicException(
                    null,
                    null,
                    null,
                    AppException::OPT_GLOBAL_VARS_SNAPSHOT |
                    AppException::OPT_CALLER_VARS_SNAPSHOT
                )
            );
            $this->assertNotEquals([], $testTarget->globalVarsSnapShot);
            $this->assertSame([], $testTarget->callerVarsSnapShot);
        }
    }

    /**
     * @test
     * @param mixed $testData ﾃｽﾄﾃﾞｰﾀ
     * @throws \InvalidArgumentException VisibilityBreakingWrapperのｺﾝｽﾄﾗｸﾀで発生
     * @dataProvider dp___constructの引数_option_の異常系ﾃｽﾄ
     */
    public function __constructの引数_option_の異常系ﾃｽﾄ($testData)
    {
        /**
         * @var AppException|VisibilityBreakingWrapper $testTarget
         */
        $testTarget = new VisibilityBreakingWrapper(
            new AppException(null, null, null, $testData)
        );
        $this->assertSame([], $testTarget->getGlobalVars());
        $this->assertSame([], $testTarget->getCallerVars());
    }

    public function dp___constructの引数_option_の異常系ﾃｽﾄ()
    {
        return $this->dataProviderTemplate(
            self::denyTypes(self::T_NULL, self::T_INT)
        );
    }
}
