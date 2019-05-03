<?php
// このﾌｧｲﾙの名前空間の定義
namespace SKJ\AppException\Runtime;

// 別名定義
use SKJ\AppException\RuntimeException;

/**
 * 想定外値実行例外
 *
 * 外部から想定する値が戻ってこなかった事で発生する例外です
 *
 * ◆詳細◆
 * <ul>
 *     <li>実行時にしか確認できないものが対象です</li>
 *     <li>※基本的にはLogic系の意味合いが強いので､Logicにある同名の例外を使用して下さい</li>
 *     <li>例)関数やﾒｿｯﾄﾞの戻り値で想定した型や値でなかった</li>
 *     <li>例)APIなどをｺｰﾙして想定した値が戻ってこなかった</li>
 * </ul>
 *
 * @package SKJ\AppException\Runtime
 * @author y3high <y3public@49364.net>
 * @copyright 2019 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release 0.8.0
 */
class UnexpectedValueException extends RuntimeException
{
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が渡されなかった場合の既定の例外ﾒｯｾｰｼﾞ
     */
    protected $defMessage = '想定外の値を受け取りました';
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が配列で渡された場合にvsprintfに渡すﾌｫｰﾏｯﾄ文字列
     */
    protected $messageTemplate = '%sで想定外の値を受け取りました';
    /**
     * @api
     * @var int ｺﾝｽﾄﾗｸﾀの引数<var>$code</var>が渡されなかった場合の既定の例外ｺｰﾄﾞ
     */
    protected $defCode = 1310;
    /**
     * @api
     * @var mixed 補助的に使用される状態ｺｰﾄﾞ(ﾃﾞﾌｫﾙﾄはself::<var>$defCode</var>と同じ)
     */
    protected $statusCode = 1310;
}
