<?php
// このﾌｧｲﾙの名前空間の定義
namespace SKJ\AppException\Logic;

// 別名定義
use SKJ\AppException\LogicException;

/**
 * 循環参照実行例外
 *
 * 参照が循環した場合に使用する例外です
 *
 * ◆詳細◆
 * <ul>
 *     <li>参照が循環した場合に利用する</li>
 *     <li>無限ﾙｰﾌﾟにならないように､検知し次第この例外を投げる</li>
 * </ul>
 *
 * @package SKJ\AppException\Logic
 * @author y3high <y3public@49364.net>
 * @copyright 2019 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release 0.8.0
 */
class CircularReferenceException extends LogicException
{
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が渡されなかった場合の既定の例外ﾒｯｾｰｼﾞ
     */
    protected $defMessage = '参照が循環しています';
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が配列で渡された場合にvsprintfに渡すﾌｫｰﾏｯﾄ文字列
     */
    protected $messageTemplate = '%sの参照が循環しています';
    /**
     * @api
     * @var int ｺﾝｽﾄﾗｸﾀの引数<var>$code</var>が渡されなかった場合の既定の例外ｺｰﾄﾞ
     */
    protected $defCode = 1313;
    /**
     * @api
     * @var mixed 補助的に使用される状態ｺｰﾄﾞ(ﾃﾞﾌｫﾙﾄはself::<var>$defCode</var>と同じ)
     */
    protected $statusCode = 1313;
}
