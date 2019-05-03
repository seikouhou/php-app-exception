<?php
// このﾌｧｲﾙの名前空間の定義
namespace SKJ\AppException\Logic;

/**
 * 異常なﾒｿｯﾄﾞ呼び出しﾛｼﾞｯｸ例外
 *
 * 未定義のﾒｿｯﾄﾞをｺｰﾙﾊﾞｯｸが参照したり､引数を指定しなかったりした場合にｽﾛｰされる例外です
 *
 * ◆詳細◆
 * <ul>
 *     <li>この例外が発生した場合はｺｰﾄﾞの修正が必要です</li>
 *     <li>例)未定義のﾒｿｯﾄﾞをｺｰﾙﾊﾞｯｸが参照した</li>
 *     <li>例)引数を指定しなかった</li>
 * </ul>
 *
 * @package SKJ\AppException\Logic
 * @author y3high <y3public@49364.net>
 * @copyright 2019 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release 0.8.0
 */
class BadMethodCallException extends BadFunctionCallException
{
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が渡されなかった場合の既定の例外ﾒｯｾｰｼﾞ
     */
    protected $defMessage = '異常なメソッド呼び出しが発生しました';
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が配列で渡された場合にvsprintfに渡すﾌｫｰﾏｯﾄ文字列
     */
    protected $messageTemplate = '%sで異常なメソッド呼び出しが発生しました';
    /**
     * @api
     * @var int ｺﾝｽﾄﾗｸﾀの引数<var>$code</var>が渡されなかった場合の既定の例外ｺｰﾄﾞ
     */
    protected $defCode = 1301;
    /**
     * @api
     * @var mixed 補助的に使用される状態ｺｰﾄﾞ(ﾃﾞﾌｫﾙﾄはself::<var>$defCode</var>と同じ)
     */
    protected $statusCode = 1301;
}
