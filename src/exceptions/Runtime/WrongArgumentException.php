<?php
// このﾌｧｲﾙの名前空間の定義
namespace SKJ\AppException\Runtime;

// 別名定義
use SKJ\AppException\RuntimeException;

/**
 * 引数値異常実行例外
 *
 * 引数値が間違っている場合に使用する例外です
 *
 * ◆詳細◆
 * <ul>
 *     <li>仕様上ほしい形で引数値が渡されなかった場合に利用する</li>
 *     <li>基本的には関数､ﾒｿｯﾄﾞのｼｸﾞﾈﾁｬ&phpdocのparamだけでは判断できない､引数の仕様外の値に対して利用する</li>
 *     <li>例)日付の文字列が欲しい引数に､時刻の文字列が渡された</li>
 * </ul>
 *
 * @package SKJ\AppException\Runtime
 * @author y3high <y3public@49364.net>
 * @copyright 2019 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release 0.8.0
 */
class WrongArgumentException extends RuntimeException
{
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が渡されなかった場合の既定の例外ﾒｯｾｰｼﾞ
     */
    protected $defMessage = '引数値が間違っています';
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が配列で渡された場合にvsprintfに渡すﾌｫｰﾏｯﾄ文字列
     */
    protected $messageTemplate = '引数%sに入力された値が間違っています';
    /**
     * @api
     * @var int ｺﾝｽﾄﾗｸﾀの引数<var>$code</var>が渡されなかった場合の既定の例外ｺｰﾄﾞ
     */
    protected $defCode = 1315;
    /**
     * @api
     * @var mixed 補助的に使用される状態ｺｰﾄﾞ(ﾃﾞﾌｫﾙﾄはself::<var>$defCode</var>と同じ)
     */
    protected $statusCode = 1315;
}
