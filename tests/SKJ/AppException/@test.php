<?php
/**
 * @noinspection NonAsciiCharacters
 */

// このﾌｧｲﾙの名前空間の定義
namespace SKJ\Test;

// 別名定義
use PHPUnit\Framework\CustomTest\AbstractCustomTestCase;
use SKJ\AppException;
use function PHPUnit\Framework\CustomTest\aggregateTraits;

/**
 * ﾌｧｲﾙの取り込み
 *
 * @noinspection PhpIncludeInspection
 */
{
    require_once('CustomTestCase.php');
    require_once('autoload.php');
    require_once('VisibilityBreakingWrapper.php');
}

// 統一ﾄﾚｲﾄの作成
if (($unificationTraitPath = aggregateTraits(__NAMESPACE__)) === false) {

    die('統一トレイトの生成に失敗しました');

} else {

    define(
        sprintf('%s\%s\DATA_DIR', __NAMESPACE__, 'AppExceptionTest'),
        dirname($unificationTraitPath).DIRECTORY_SEPARATOR
    );
}

class AppExceptionTest extends AbstractCustomTestCase
{
    /**
     * ﾃｽﾄﾒｿｯﾄﾞ(統一ﾄﾚｲﾄ)の取り込み
     */
    use AppExceptionTestMethods;

    // 個々のﾃｽﾄﾒｿｯﾄﾞの開始前に実行される
    protected function setUp()
    {
        // 出力のﾊﾞｯﾌｧﾘﾝｸﾞ無効化(ﾒﾓﾘﾃｽﾄの為)
        ob_end_flush();
    }

    // 個々のﾃｽﾄﾒｿｯﾄﾞの終了後に実行される
    protected function tearDown()
    {
        // 出力のﾊﾞｯﾌｧﾘﾝｸﾞ有効化(ﾒﾓﾘﾃｽﾄの為)
        ob_start();
    }

    /**
     * ｸﾗｽ変数の初期値ﾃｽﾄ
     *
     * @test
     * @throws \PHPUnit_Framework_AssertionFailedError
     */
    public function ｸﾗｽ変数の初期値ﾃｽﾄ()
    {
        // ｸﾗｽ変数の初期値ﾁｪｯｸ
        $this->assertFalse(AppException::$enableGlobalVarsSnapShot);

        if (AppException::isExtension()) {

            $this->assertTrue(AppException::$enableCallerVarsSnapShot);

        } else {

            $this->assertFalse(AppException::$enableCallerVarsSnapShot);
        }
    }

    /**
     * @param null $a
     * @throws \SKJ\AppException
     */
    public function parts_test_func01(
        /** @noinspection PhpUnusedParameterInspection */ $a = null
    ){
        throw new AppException();
    }

    /**
     * @param null $a
     * @param null $b
     * @throws \SKJ\AppException
     */

    public function parts_test_func02(
        /** @noinspection PhpUnusedParameterInspection */ $a = null,
        $b = null
    ){
        $this->parts_test_func01();
    }

    /**
     * @throws \SKJ\AppException
     */
    public function parts_test_func03()
    {
        $this->parts_test_func02();
    }

    /**
     * @throws \SKJ\AppException
     */
    public function parts_test_func04()
    {
        $this->parts_test_func03();
    }

    /**
     * @throws \PHPUnit_Framework_Exception
     * @throws \PHPUnit_Framework_ExpectationFailedException
     */
    public function parts_test_func05()
    {
        try {
            $this->parts_test_func04();
        } catch (AppException $e) {
            $this->assertSame($e->getLineInCurrentContext(), __LINE__ - 2);
            $this->assertSame(
                $e->getFunctionInCurrentContext(),
                'AppExceptionDisableTest::parts_test_func04'
            );
        }
    }

    /**
     * @param AppException $e
     * @throws \PHPUnit_Framework_AssertionFailedError
     */
    public function parts_test_func06($e)
    {
        //$this->assertSame($e->getLineInCurrentContext(),248);
        $this->assertFalse($e->getFunctionInCurrentContext());
    }

    /**
     * @throws \SKJ\AppException
     */
    public function parts_test_func07()
    {
        AppExceptionTest\testFunc2();
    }

    /**
     * @throws \SKJ\AppException
     */
    public static function parts_test_func08()
    {
        throw new AppException();
    }

    /**
     * @throws \SKJ\AppException
     */
    public function parts_test_func09()
    {
        $x = new AppException();
        throw $x->forge();
    }

    /**
     * @param $e
     * @return mixed
     */
    public function levelTest(AppException $e)
    {
        /*
        $d = [];
        $d[] = ['file' => '/var/web/paddock-api/app/dp/phalcon/common/AppException/tests/AppExceptionDisableTest.php','line' => 306];
        $d = array_merge($d,debug_backtrace());
        */
        /*
            $buffer = count($e->callQueue)."\n";
            foreach($e->callQueue as $i => $x)
            {
                if(!isset($x['file']))$x['file'] = 'unknown';
                if(!isset($x['line']))$x['line'] = 'unknown';
                if(!isset($x['function']))$x['function'] = 'unknown';

                $buffer .= "{$i}:{$x['file']}({$x['line']})->{$x['function']}\n";
            }
            $buffer .= count($d)."\n";
            foreach(array_reverse($d) as $i => $x)
            {
                if(!isset($x['file']))$x['file'] = 'unknown';
                if(!isset($x['line']))$x['line'] = 'unknown';
                if(!isset($x['function']))$x['function'] = 'unknown';

                $buffer .= "{$i}:{$x['file']}({$x['line']})->{$x['function']}\n";
            }

            file_put_contents('./bt.txt',$buffer);
        */
        return $e->wasCreatedInCurrentContext();
    }

    /**
     * @param $e
     * @return mixed
     */
    public function levelTest2($e)
    {
        return $this->levelTest($e);
    }
}

namespace SKJ\Test\AppExceptionTest;

use SKJ\AppException;

/**
 * @throws \SKJ\AppException
 */
function testFunc()
{
    throw new AppException();
}

/**
 * @throws \SKJ\AppException
 */
function testFunc2()
{
    testFunc();
}

// 言語ﾚﾍﾞﾙのinspection対策
class FakeObject
{
    public $globalVarsSnapShot;
    public $callerVarsSnapShot;
}
