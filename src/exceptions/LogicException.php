<?php
// このﾌｧｲﾙの名前空間の定義
namespace SKJ\AppException;

// 別名定義
use SKJ\AppException;

/**
 * ｱﾌﾟﾘｹｰｼｮﾝﾚﾍﾞﾙでのﾛｼﾞｯｸ例外
 *
 * ｱﾌﾟﾘｹｰｼｮﾝﾚﾍﾞﾙで発生したﾛｼﾞｯｸ例外です
 *
 * ◆詳細◆
 * <ul>
 *     <li>正常利用では絶対に発生しないｴﾗｰ(処理の途中で絶対に入りえない分岐に入った場合や､予め想定されている使い方をされなかった場合)に適用する例外</li>
 *     <li>明確なﾊﾞｸﾞの発生であり､発生した時点で必ずｺｰﾄﾞの修正が発生する</li>
 *     <li>呼び出し元は予め例外の発生を予測することができる</li>
 *     <li>多くはﾌﾟﾛｸﾞﾗﾑのﾊﾞｸﾞ検出のために仕込む例外</li>
 *     <li>例) 必ずｺｰﾄﾞ中で定義されているはずの配列のｴﾝﾄﾘが存在しない</li>
 *     <li>JavaのRuntimeExceptionに該当する</li>
 * </ul>
 *
 * @package SKJ\AppException
 * @version 0.8.0
 * @author y3high <y3public@49364.net>
 * @copyright 2019 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release 0.8.0
 */
class LogicException extends AppException
{
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が渡されなかった場合の既定の例外ﾒｯｾｰｼﾞ
     */
    protected $defMessage = 'ロジック例外が発生しました';
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が配列で渡された場合にvsprintfに渡すﾌｫｰﾏｯﾄ文字列
     */
    protected $messageTemplate = '%sでロジック例外が発生しました';
    /**
     * @api
     * @var int ｺﾝｽﾄﾗｸﾀの引数<var>$code</var>が渡されなかった場合の既定の例外ｺｰﾄﾞ
     */
    protected $defCode = 1200;
    /**
     * @api
     * @var mixed 補助的に使用される状態ｺｰﾄﾞ(ﾃﾞﾌｫﾙﾄはself::<var>$defCode</var>と同じ)
     */
    protected $statusCode = 1200;
    /**
     * @api
     * @var int このｵﾌﾞｼﾞｪｸﾄをｲﾃﾚｰﾀとして扱った時に返す連結された例外のｿｰﾄ順
     * @uses self::SORT_ORDER_DESC 初期値として使用
     */
    protected $iteratorSortOrder = self::SORT_ORDER_DESC;
}
