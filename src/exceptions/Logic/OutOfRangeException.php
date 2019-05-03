<?php
// このﾌｧｲﾙの名前空間の定義
namespace SKJ\AppException\Logic;

// 別名定義
use SKJ\AppException\LogicException;

/**
 * 静的範囲ｴﾗｰﾛｼﾞｯｸ例外
 *
 * 静的範囲ｴﾗｰが発生した事で発生する例外です
 *
 * ◆詳細◆
 * <ul>
 *     <li>この例外が発生した場合はｺｰﾄﾞの修正が必要です</li>
 *     <li>値が有効なｷｰでなかった場合にｽﾛｰされる例外です</li>
 *     <li>例)固定的なｲﾝﾃﾞｯｸｽに対して範囲外のｷｰが発生した</li>
 * </ul>
 *
 * @package SKJ\AppException\Logic
 * @author y3high <y3public@49364.net>
 * @copyright 2019 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release 0.8.0
 */
class OutOfRangeException extends LogicException
{
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が渡されなかった場合の既定の例外ﾒｯｾｰｼﾞ
     */
    protected $defMessage = '静的範囲エラー例外が発生しました';
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が配列で渡された場合にvsprintfに渡すﾌｫｰﾏｯﾄ文字列
     */
    protected $messageTemplate = '%sで静的範囲エラー例外が発生しました';
    /**
     * @api
     * @var int ｺﾝｽﾄﾗｸﾀの引数<var>$code</var>が渡されなかった場合の既定の例外ｺｰﾄﾞ
     */
    protected $defCode = 1305;
    /**
     * @api
     * @var mixed 補助的に使用される状態ｺｰﾄﾞ(ﾃﾞﾌｫﾙﾄはself::<var>$defCode</var>と同じ)
     */
    protected $statusCode = 1305;
}
