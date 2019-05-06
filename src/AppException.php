<?php
// このﾌｧｲﾙの名前空間の定義
namespace SKJ;

// Extensionの有無で､読み込みｸﾗｽ切り替え
if (extension_loaded('_AppException')) {

    require_once('AppExceptionEnableExtension.txt');

} else {

    require_once('AppExceptionDisableExtension.txt');
}

return;

/**
 * ################################# 注 意 ####################################
 * 以下はIDEのｲﾝｽﾍﾟｸｼｮﾝ、apigen、phpDocumentor対策のﾀﾞﾐｰｺｰﾄﾞです!!
 * ｸﾗｽの実体は上記でrequireした、AppExceptionDisableExtension.txtもしくは
 * AppExceptionEnableExtension.txtを参照してください
 * ############################################################################
 */

// 別名定義
use Exception;

/**
 * ｱﾌﾟﾘｹｰｼｮﾝﾚﾍﾞﾙで発生する例外の基底となる例外
 *
 * ｱﾌﾟﾘｹｰｼｮﾝﾚﾍﾞﾙで発生した例外は全てこの例外を継承します
 *
 * ◆詳細◆
 * <ul>
 *     <li>この例外を直接投げるようなことはしないで下さい</li>
 *     <li>この例外を継承した\SKJ\AppException\LogicException、\SKJ\AppException\RuntimeException、もしくはこの両例外を継承した更なる詳細例外を投げて下さい</li>
 * </ul>
 *
 * @package SKJ\AppException
 * @author y3high <y3public@49364.net>
 * @copyright 2019 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release 0.8.0
 */
class AppException extends Exception implements AppExceptionInterface
{
    /**
     * AppException 共通ﾒｿｯﾄﾞの取り込み
     */
    use AppExceptionMethods;
    /**
     * 基底例外ｺｰﾄﾞを算出するにあたってのﾌｧｲﾙの最大行数
     *
     * @internal
     */
    const MAX_LINE_IN_FILE = 999999;
    /**
     * 例外発生時のｸﾞﾛｰﾊﾞﾙ変数のｽﾅｯﾌﾟｼｮｯﾄを撮りたい時に、ｺﾝｽﾄﾗｸﾀの第4引数に指定する定数
     *
     * @api
     */
    const OPT_GLOBAL_VARS_SNAPSHOT = 1;
    /**
     * 例外発生時のﾛｰｶﾙ変数のｽﾅｯﾌﾟｼｮｯﾄを撮りたい時に、ｺﾝｽﾄﾗｸﾀの第4引数に指定する定数
     *
     * @api
     */
    const OPT_CALLER_VARS_SNAPSHOT = 2;
    /**
     * ｻﾌﾞｸﾗｽにて初期値を上書きする
     *
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が渡されなかった場合の既定の例外ﾒｯｾｰｼﾞ
     */
    protected $defMessage = '例外が発生しました';
    /**
     * ｻﾌﾞｸﾗｽにて初期値を上書きする
     *
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が配列で渡された場合にvsprintfに渡すﾌｫｰﾏｯﾄ文字列
     */
    protected $messageTemplate = '例外が%sで発生しました';
    /**
     * ｻﾌﾞｸﾗｽにて初期値を上書きする
     *
     * @api
     * @var int ｺﾝｽﾄﾗｸﾀの引数<var>$code</var>が渡されなかった場合の既定の例外ｺｰﾄﾞ
     */
    protected $defCode = 1000;
    /**
     * ｻﾌﾞｸﾗｽにて初期値を上書きする
     *
     * @api
     * @var mixed 補助的に使用される状態ｺｰﾄﾞ(ﾃﾞﾌｫﾙﾄはself::<var>$defCode</var>と同じ)
     */
    protected $statusCode = 1000;
    /**
     * ｻﾌﾞｸﾗｽにて初期値を上書きする
     *
     * @api
     * @var int このｵﾌﾞｼﾞｪｸﾄをｲﾃﾚｰﾀとして扱った時に返す連結された例外のｿｰﾄ順
     * @uses self::SORT_ORDER_DESC 初期値として使用
     */
    protected $iteratorSortOrder = self::SORT_ORDER_DESC;
    /**
     * @api
     * @var bool 例外発生時のｸﾞﾛｰﾊﾞﾙｽｺｰﾌﾟの変数情報を記録するかどうかの真偽値
     */
    public static $enableGlobalVarsSnapShot = false;
    /**
     * @api
     * @var bool 例外発生時のﾛｰｶﾙｽｺｰﾌﾟの変数情報を記録するかどうかの真偽値
     */
    public static $enableCallerVarsSnapShot = false;
    /**
     * @internal
     * @var array 例外発生時のｸﾞﾛｰﾊﾞﾙｽｺｰﾌﾟの変数情報
     */
    protected $globalVarsSnapShot = [];
    /**
     * @internal
     * @var array 例外発生時のﾛｰｶﾙｽｺｰﾌﾟの変数情報
     */
    protected $callerVarsSnapShot = [];
    /** @noinspection PhpMissingParentConstructorInspection */
    /** @noinspection PhpUnusedParameterInspection */
    /**
     * ｺﾝｽﾄﾗｸﾀ
     *
     * 例外の初期化処理
     *
     * ※このｸﾗｽを継承した子ｸﾗｽに「initialize」ﾒｿｯﾄﾞが存在すれば呼ばれるが、その際に例外が投げられる可能性があるので注意する事(詳細は子ｸﾗｽの「initialize」ﾒｿｯﾄﾞのDOCを確認)
     *
     * @api
     * @param string|array|null $message 例外ﾒｯｾｰｼﾞ、これを文字列ではなく配列として渡すと、<var>$messageTemplate</var>に設定されたﾌｫｰﾏｯﾄ文字列と一緒にvsprintfへと渡され、その戻り値が例外ﾒｯｾｰｼﾞとなります
     * @param int|null $code 例外ｺｰﾄﾞ
     * @param \Exception|null $previous 以前に使われた例外で、例外の連結に使用
     * @param int|null $options 変数のｽﾅｯﾌﾟｼｮｯﾄｵﾌﾟｼｮﾝを指定する
     * @uses self::OPT_GLOBAL_VARS_SNAPSHOT ｸﾞﾛｰﾊﾞﾙ変数のｽﾅｯﾌﾟｼｮｯﾄ取得時に<var>$options</var>へ指定
     * @uses self::OPT_CALLER_VARS_SNAPSHOT ﾛｰｶﾙ変数のｽﾅｯﾌﾟｼｮｯﾄ取得時に<var>$options</var>へ指定
     */
    public function __construct(
        $message = null,
        $code = null,
        Exception $previous = null,
        $options = null
    ){
    }

    /**
     * 初期化処理
     *
     * 親ｸﾗｽより呼ばれる初期化処理
     *
     * @internal
     */
    protected function _initialize()
    {
    }

    /**
     * 例外発生時のｸﾞﾛｰﾊﾞﾙｽｺｰﾌﾟの変数情報を取得
     *
     * @api
     * @return array ｸﾞﾛｰﾊﾞﾙ変数情報
     */
    public function getGlobalVars()
    {
        return [];
    }

    /**
     * 例外発生時のﾛｰｶﾙｽｺｰﾌﾟの変数情報を取得
     *
     * @api
     * @return array ﾛｰｶﾙ変数情報
     */
    public function getCallerVars()
    {
        return [];
    }
}
