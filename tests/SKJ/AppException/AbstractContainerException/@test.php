<?php
/**
 * @noinspection NonAsciiCharacters
 */

// このﾌｧｲﾙの名前空間の定義
namespace SKJ\Test;

// 別名定義
use PHPUnit\Framework\CustomTest\AbstractCustomTestCase;
use SKJ\AppException\AbstractContainerException;
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
            'AbstractContainerExceptionTest'
        ),
        dirname($unificationTraitPath).DIRECTORY_SEPARATOR
    );
}

class AbstractContainerExceptionTest extends AbstractCustomTestCase
{
    /**
     * ﾃｽﾄﾒｿｯﾄﾞ(統一ﾄﾚｲﾄ)の取り込み
     */
    use AbstractContainerExceptionTestMethods;

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
class ContainerExceptionTest extends AbstractContainerException
{
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が渡されなかった場合の既定の例外ﾒｯｾｰｼﾞ
     */
    protected $defMessage = '例外が発生しました';
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が配列で渡された場合にvsprintfに渡すﾌｫｰﾏｯﾄ文字列
     */
    protected $messageTemplate = '%sで例外が発生しました';
    /**
     * @api
     * @var int ｺﾝｽﾄﾗｸﾀの引数<var>$code</var>が渡されなかった場合の既定の例外ｺｰﾄﾞ
     */
    protected $defCode = 999;
    /**
     * @api
     * @var mixed 補助的に使用される状態ｺｰﾄﾞ(ﾃﾞﾌｫﾙﾄはself::<var>$defCode</var>と同じ)
     */
    protected $statusCode = 9999;
    /**
     * @api
     * @var int このｵﾌﾞｼﾞｪｸﾄをｲﾃﾚｰﾀとして扱った時に返す連結された例外のｿｰﾄ順
     * @uses self::SORT_ORDER_DESC 初期値として使用
     */
    protected $iteratorSortOrder = self::SORT_ORDER_ASC;
}
