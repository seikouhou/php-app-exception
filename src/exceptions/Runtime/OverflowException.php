<?php
// このﾌｧｲﾙの名前空間の定義
namespace SKJ\AppException\Runtime;

// 別名定義
use SKJ\AppException\RuntimeException;

/**
 * ｵｰﾊﾞｰﾌﾛｰ実行例外
 *
 * 上限となるｺﾝﾃﾅへのﾃﾞｰﾀ追加で発生する例外です
 *
 * ◆詳細◆
 * <ul>
 *     <li>実行時にしか確認できないものが対象です</li>
 *     <li>いっぱいになっているｺﾝﾃﾅに要素を追加した場合にｽﾛｰされる例外です</li>
 *     <li>数値の桁あふれが発生する状況でも使用します</li>
 * </ul>
 *
 * @package SKJ\AppException\Runtime
 * @author y3high <y3public@49364.net>
 * @copyright 2019 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release 0.8.0
 */
class OverflowException extends RuntimeException
{
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が渡されなかった場合の既定の例外ﾒｯｾｰｼﾞ
     */
    protected $defMessage = 'オーバーフローが発生しました';
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が配列で渡された場合にvsprintfに渡すﾌｫｰﾏｯﾄ文字列
     */
    protected $messageTemplate = '%sでオーバーフロー例外が発生しました';
    /**
     * @api
     * @var int ｺﾝｽﾄﾗｸﾀの引数<var>$code</var>が渡されなかった場合の既定の例外ｺｰﾄﾞ
     */
    protected $defCode = 1307;
    /**
     * @api
     * @var mixed 補助的に使用される状態ｺｰﾄﾞ(ﾃﾞﾌｫﾙﾄはself::<var>$defCode</var>と同じ)
     */
    protected $statusCode = 1307;
}
