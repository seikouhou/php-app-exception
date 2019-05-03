<?php
// このﾌｧｲﾙの名前空間の定義
namespace PHPUnit\Framework\CustomTest;

// 別名定義
use ErrorException;
use FilesystemIterator;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use UnexpectedValueException;

// @tips PHPUnitはﾃｽﾄｸﾗｽごとにphpのﾌﾟﾛｾｽを立ち上げ直している訳ではなく、
//       あくまでも1つのphpﾌﾟﾛｾｽの中から各ﾃｽﾄｸﾗｽを実行しているので、同一名称
//       のｸﾗｽや関数名には注意する事。(多重定義ｴﾗｰが起こる)
//       また、processIsolationは各ﾃｽﾄﾒｿｯﾄﾞごとにﾌﾟﾛｾｽ(たぶんﾌｫｰｸ?)を立ち上
//       げるがﾙｰﾄﾌﾟﾛｾｽを継承したもので、既に定義されたｸﾗｽや関数は引き継いで
//       いるので解決法にはならない。あくまでも変数のｸﾘｱを目的としたもの。
// @tips PHPUnitはﾃｽﾄﾒｿｯﾄﾞの実行ひとつごとにﾃｽﾄｵﾌﾞｼﾞｪｸﾄを作り直している。

// ﾋﾞｯﾄ反転した値より1大きいのがPHPの最小値
// 通常の符号付き2進数とは違うので注意
switch (PHP_INT_SIZE) { // 32bit 64bit 判断

    case 4:

        if (!defined('UT_INTMAX')) {
            define('UT_INTMAX', 2147483647);
        }
        if (!defined('UT_INTMAXOVER')) {
            define('UT_INTMAXOVER', 2147483648);
        }
        if (!defined('UT_INTMIN')) {
            define('UT_INTMIN', -2147483647);
        }
        if (!defined('UT_INTMINUNDER')) {
            define('UT_INTMINUNDER', -2147483648);
        }

        break;

    case 8:

        if (!defined('UT_INTMAX')) {
            define('UT_INTMAX', 9223372036854775807);
        }
        if (!defined('UT_INTMAXOVER')) {
            define('UT_INTMAXOVER', 9223372036854775808);
        }
        if (!defined('UT_INTMIN')) {
            define('UT_INTMIN', -9223372036854775807);
        }
        if (!defined('UT_INTMINUNDER')) {
            define('UT_INTMINUNDER', -9223372036854775808);
        }

        break;
}

// PHPｴﾗｰの例外変換
set_error_handler(
    function (
        $errNo,
        $errStr,
        $errFile,
        $errLine,
        /** @noinspection PhpUnusedParameterInspection */ $errContext
    ){

        // ｴﾗｰが発生した場合、ErrorExceptionを発生させる
        throw new ErrorException(
            sprintf('[%s] %s', getFriendlyErrorType($errNo), $errStr),
            0,
            $errNo,
            $errFile,
            $errLine
        );
    }
);


/**
 * ｴﾗｰﾚﾍﾞﾙ定数の文字列表現を取得する
 *
 * @param int $type ｴﾗｰﾚﾍﾞﾙ定数を表す数値
 * @return string ｴﾗｰﾚﾍﾞﾙ定数の文字列表現、変換不可能時は引数をそのまま返す
 */
function getFriendlyErrorType($type)
{
    switch ($type) {

        case E_ERROR: // 1 //
            return 'E_ERROR';

        case E_WARNING: // 2 //
            return 'E_WARNING';

        case E_PARSE: // 4 //
            return 'E_PARSE';

        case E_NOTICE: // 8 //
            return 'E_NOTICE';

        case E_CORE_ERROR: // 16 //
            return 'E_CORE_ERROR';

        case E_CORE_WARNING: // 32 //
            return 'E_CORE_WARNING';

        case E_COMPILE_ERROR: // 64 //
            return 'E_COMPILE_ERROR';

        case E_COMPILE_WARNING: // 128 //
            return 'E_COMPILE_WARNING';

        case E_USER_ERROR: // 256 //
            return 'E_USER_ERROR';

        case E_USER_WARNING: // 512 //
            return 'E_USER_WARNING';

        case E_USER_NOTICE: // 1024 //
            return 'E_USER_NOTICE';

        case E_STRICT: // 2048 //
            return 'E_STRICT';

        case E_RECOVERABLE_ERROR: // 4096 //
            return 'E_RECOVERABLE_ERROR';

        case E_DEPRECATED: // 8192 //
            return 'E_DEPRECATED';

        case E_USER_DEPRECATED: // 16384 //
            return 'E_USER_DEPRECATED';
    }

    return $type;
}

/**
 * 統一ﾄﾚｲﾄﾌｧｲﾙの作成と取り込み
 *
 * methodsﾌｫﾙﾀﾞ下のﾃｽﾄﾒｿｯﾄﾞを取り込んだﾄﾚｲﾄを作成しrequireする
 *
 * @param string|null $namespace 統一ﾄﾚｲﾄを配置する名前空間、未指定時はｸﾞﾛｰﾊﾞﾙ
 * @param string|null $traitName 統一ﾄﾚｲﾄ名、未指定時はﾃｽﾄｸﾗｽ名+Methods
 * @return string|false 成功時に統一ﾄﾚｲﾄへのﾊﾟｽ、失敗時に偽
 */
function aggregateTraits($namespace = null, $traitName = null)
{
    $traits = [];
    $testDir = dirname(debug_backtrace()[0]['file']).DIRECTORY_SEPARATOR;
    $dataDir = $testDir.'@data'.DIRECTORY_SEPARATOR;
    $namespace = empty($namespace) ? '' : "namespace {$namespace};\n\n";
    $className = basename($testDir);
    $traitName = is_null($traitName) ? "{$className}TestMethods" : $traitName;
    $testMethodDir = $testDir.'@methods'.DIRECTORY_SEPARATOR;
    try {

        $entries = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(
                $testMethodDir, FilesystemIterator::CURRENT_AS_SELF
            ), RecursiveIteratorIterator::LEAVES_ONLY
        );

    } catch (UnexpectedValueException $e) {

        return false;
    }

    // ﾃﾞｰﾀﾃﾞｨﾚｸﾄﾘの存在確認
    if (!is_dir($dataDir)) {

        if (!mkdir($dataDir)) {

            return false;
        }
    }

    /**
     * methodsﾌｫﾙﾀﾞからﾄﾚｲﾄを探す
     *
     * @var \DirectoryIterator $entry
     */
    foreach ($entries as $entry) {

        if (!$entry->isFile() and !$entry->isLink()) {

            continue;
        }

        if ($entry->getExtension() !== 'php') {

            continue;
        }

        if (($traitList = get_declared_traits()) === null) {

            return false;
        }

        /** @noinspection PhpIncludeInspection */
        require_once($entry->getPathname());

        $newTraits = array_diff(get_declared_traits(), $traitList);

        if (($newTrait = array_pop($newTraits)) === null) {

            return false;
        }

        $traits[] = '\\'.$newTrait;
    }

    // 統一ﾄﾚｲﾄを作成
    $buffer = str_replace(
        ['#trait#'],
        [implode(', ', $traits)],
        <<< EOD
<?php
{$namespace}trait {$traitName}
{
    use #trait#;
}
EOD
    );

    // 統一ﾄﾚｲﾄをﾌｧｲﾙに書き出す
    if (file_put_contents($dataDir.'trait.php', $buffer) === false) {

        return false;
    }

    /**
     * 統一ﾄﾚｲﾄを取り込み
     *
     * @noinspection PhpIncludeInspection
     */
    require_once($dataDir.'trait.php');

    return $dataDir.'trait.php';
}

/**
 * PHPUnit\Framework\TestCaseｸﾗｽを拡張
 *
 * ◆詳細◆
 * <ul>
 *     <li>当ｸﾗｽは抽象ｸﾗｽでないと、ﾃｽﾄｸﾗｽとは別に独立したﾃｽﾄ対象になるので注意</li>
 *     <li>基本ﾃｽﾄしたい1ｸﾗｽに対して、この抽象ｸﾗｽを継承したﾃｽﾄｸﾗｽを作る。</li>
 *     <li>ﾃｽﾄ対象のｸﾗｽの名前空間と対応させたﾌｫﾙﾀﾞにﾃｽﾄｸﾗｽとして"@test.php"を作成する(例:SKJ\App\Db.php → ./SKJ/App/Db/@test.php)</li>
 *     <li>複数のｸﾗｽのﾃｽﾄを1度に行う場合は、各ﾃｽﾄｸﾗｽを必ず固有の名前空間に属させる事</li>
 *     <li>ﾃｽﾄ対象のｸﾗｽの名前空間と対応させたﾌｫﾙﾀﾞの下に"@methods"ﾌｫﾙﾀﾞを作り、その下に個々のﾃｽﾄ対象のﾒｿｯﾄﾞに対応したﾃｽﾄﾒｿｯﾄﾞﾄﾚｲﾄを作成する(例:SKJ\App\Db.php → ./SKJ/App/Db/@methods/{ﾃｽﾄ対象のﾒｿｯﾄﾞ名であればﾍﾞｽﾄ}.php)</li>
 *     <li>ﾃｽﾄﾒｿｯﾄﾞﾄﾚｲﾄにはﾃｽﾄ対象のﾒｿｯﾄﾞに関連したﾃｽﾄﾒｿｯﾄﾞを記述する</li>
 *     <li>ﾃｽﾄﾒｿｯﾄﾞﾄﾚｲﾄの属する名前空間は、ﾃｽﾄｸﾗｽの属する名前空間+ﾃｽﾄｸﾗｽ名がﾍﾞｽﾄ(要はﾃｽﾄﾒｿｯﾄﾞﾄﾚｲﾄ名が他のﾃｽﾄｸﾗｽのものと衝突しなければよい)</li>
 *     <li>ﾃｽﾄｸﾗｽの記述されたﾌｧｲﾙでは、ﾃｽﾄｸﾗｽの宣言の前に\PHPUnit\Framework\CustomTest\aggregateTraits関数によって集約ﾄﾚｲﾄを作成し、それをﾃｽﾄｸﾗｽに取り込む必要がある</li>
 * </ul>
 *
 * @package SKJ\Test
 * @version 1.0.0
 * @author y3high <y3public@49364.net>
 * @copyright 2014 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release 1.0.0
 */
Abstract class AbstractCustomTestCase extends TestCase
{
    /**
     * PHPの型を表す定数
     */
    const T_NULL = 1, T_BOOLEAN = 2, T_INT = 4, T_FLOAT = 8, T_STRING = 16, T_ARRAY = 32, T_OBJECT = 64, T_CALLABLE = 128, T_RESOURCE = 256, T_ITERABLE = 512, T_SCALAR = 30, T_NUMBER = 12;
    /**
     * @var array 型別のﾁｪｯｸﾃﾞｰﾀﾘｽﾄ
     */
    protected $typeCheckList = [];

    // ﾃｽﾄ開始時に1回だけ実行される
    public static function setUpBeforeClass()
    {
    }

    // ﾃｽﾄ終了時に1回だけ実行される
    public static function tearDownAfterClass()
    {
    }

    // 個々のﾃｽﾄﾒｿｯﾄﾞの開始前に実行される
    protected function setUp()
    {
    }

    // 個々のﾃｽﾄﾒｿｯﾄﾞの終了後に実行される
    protected function tearDown()
    {
    }

    // assert系ﾒｿｯﾄﾞの開始前に実行される
    protected function assertPreConditions()
    {
    }

    // assert系ﾒｿｯﾄﾞの終了後に実行される
    // ﾃｽﾄが落ちた場合は実行されない
    protected function assertPostConditions()
    {
    }

    // assertﾒｿｯﾄﾞのﾃｽﾄに合格しなかった場合､tearDown()の後に実行される
    //protected function onNotSuccessfulTest(Exception $e)
    //{
    //}

    /**
     * @param int ...$types
     * @return int
     */
    public static function allowTypes(...$types)
    {
        $result = 0;

        foreach ($types as $type) {

            $result |= $type;
        }

        return $result;
    }

    /**
     * @param int ...$types
     * @return int
     */
    public static function denyTypes(...$types)
    {
        $result = 0;

        foreach ($types as $type) {

            $result |= $type;
        }

        return ~$result;
    }

    /**
     * @return int
     */
    public static function clearAllTypes()
    {

        return 0;
    }

    /**
     * 型別のﾃｽﾄﾃﾞｰﾀﾘｽﾄを初期化する
     *
     * @param int $opVal ﾃｽﾄﾃﾞｰﾀﾘｽﾄから残す型を表す数値(未指定なら既定のﾃｽﾄﾃﾞｰﾀﾘｽﾄで初期化のみ)
     */
    public function initializeTypeCheckList($opVal = PHP_INT_MAX)
    {
        $obj = new UtTestClass();

        $this->typeCheckList = [
            self::T_NULL => [null],
            self::T_BOOLEAN => [true, false],
            self::T_INT => [0, UT_INTMIN, UT_INTMAX],
            self::T_FLOAT => [0.1, -1.2, (float)0],
            self::T_STRING => ['', '1', '12345', 'a123', 'あいうえお'],
            self::T_ARRAY => [[], [0, 1, 2], ['apple' => 0, 'banana' => 1]],
            self::T_OBJECT => [new UtTestClass(), $obj],
            self::T_CALLABLE => [
                function (){
                    return true;
                },
            ],
        ];

        foreach (array_keys($this->typeCheckList) as $index) {

            if (!($index & $opVal)) {

                unset($this->typeCheckList[$index]);
            }
        }
    }

    /**
     * 型別のﾁｪｯｸﾃﾞｰﾀﾘｽﾄに追加する
     */
    public function addTypeCheckList()
    {
        foreach (func_get_args() as $arg) {

            $this->typeCheckList[0][] = $arg;
        }
    }

    /**
     *
     *
     * @param callable $function
     * @return array
     */
    public function getTypeCheckList(callable $function)
    {
        $result = [];

        foreach ($this->typeCheckList as $array) {

            foreach ($array as $value) {

                $result[] = call_user_func($function, $value);
            }
        }

        return $result;
    }

    /**
     * @param int $opType
     * @return array
     */
    public function dataProviderTemplate($opType)
    {

        $this->initializeTypeCheckList($opType);

        return $this->getTypeCheckList(
            function ($data){
                return [$data];
            }
        );
    }
}

function ut_test_func()
{
    return true;
}

interface UtTestClassInterface1
{
    public static function utStaticTestMethod();

    public function utTestMethod1();
}

interface UtTestClassInterface2
{
    public function utTestMethod2();
}

class UtTestClass implements UtTestClassInterface1, UtTestClassInterface2
{
    public static function utStaticTestMethod()
    {
        return true;
    }

    public function utTestMethod1()
    {
        return true;
    }

    public function utTestMethod2()
    {
        return true;
    }
}

