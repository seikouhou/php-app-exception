<?php
/**
 * @noinspection NonAsciiCharacters
 */

// このﾌｧｲﾙの名前空間の定義
namespace SKJ\Test;

// 別名定義
use PHPUnit\Framework\CustomTest\AbstractCustomTestCase;
use SKJ\AppException\AbstractValidationException;
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
        sprintf(
            '%s\%s\DATA_DIR',
            __NAMESPACE__,
            'AbstractValidationExceptionTest'
        ),
        dirname($unificationTraitPath).DIRECTORY_SEPARATOR
    );
}

class AbstractValidationExceptionTest extends AbstractCustomTestCase
{
    /**
     * ﾃｽﾄﾒｿｯﾄﾞ(統一ﾄﾚｲﾄ)の取り込み
     */
    use AbstractValidationExceptionTestMethods;

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
}

// TEST用ｸﾗｽ
class ValidationExceptionTest extends AbstractValidationException
{
}
