<?php
// このﾌｧｲﾙの名前空間の定義
namespace SKJ\AppException;

// 別名定義
use SKJ\AppException;

/**
 * ｱﾌﾟﾘｹｰｼｮﾝﾚﾍﾞﾙでの実行例外
 *
 * ｱﾌﾟﾘｹｰｼｮﾝﾚﾍﾞﾙで発生した実行例外です
 *
 * ◆詳細◆
 * <ul>
 *     <li>実行時に発生しうるｴﾗｰに適用</li>
 *     <li>多くの場合､呼び出し元は例外の発生を予測できない(呼んでみないとわからない)ｹｰｽに適用される例外</li>
 *     <li>例) 外部から来たｷｰでDBにｱｸｾｽしたら望む情報が得られなかった</li>
 *     <li>例) 何らかの理由でDBの接続に失敗した</li>
 *     <li>JavaのRuntimeExceptionとは全く逆の意味(JavaのRuntimeExceptionはPHPのLogicExceptionになる)なので注意</li>
 * </ul>
 *
 * @package SKJ\AppException
 * @version 0.8.0
 * @author y3high <y3public@49364.net>
 * @copyright 2019 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release 0.8.0
 */
class RuntimeException extends AppException
{
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が渡されなかった場合の既定の例外ﾒｯｾｰｼﾞ
     */
    protected $defMessage = '実行例外が発生しました';
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が配列で渡された場合にvsprintfに渡すﾌｫｰﾏｯﾄ文字列
     */
    protected $messageTemplate = '%sで実行例外が発生しました';
    /**
     * @api
     * @var int ｺﾝｽﾄﾗｸﾀの引数<var>$code</var>が渡されなかった場合の既定の例外ｺｰﾄﾞ
     */
    protected $defCode = 1100;
    /**
     * @api
     * @var mixed 補助的に使用される状態ｺｰﾄﾞ(ﾃﾞﾌｫﾙﾄはself::<var>$defCode</var>と同じ)
     */
    protected $statusCode = 1100;
    /**
     * @api
     * @var int このｵﾌﾞｼﾞｪｸﾄをｲﾃﾚｰﾀとして扱った時に返す連結された例外のｿｰﾄ順
     * @uses self::SORT_ORDER_DESC 初期値として使用
     */
    protected $iteratorSortOrder = self::SORT_ORDER_DESC;
}
