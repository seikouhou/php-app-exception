<?php
// このﾌｧｲﾙの名前空間の定義
namespace SKJ\AppException\HTTP;

// 別名定義
use SKJ\AppException\HttpException;

/**
 * Conflict HTTP層実行例外
 *
 * ｸﾗｲｱﾝﾄが要求した操作が､現在のﾘｿｰｽの状態と矛盾する事を示す例外です
 *
 * ◆詳細◆
 * <ul>
 *     <li>ｸﾗｲｱﾝﾄが要求した操作が､現在のﾘｿｰｽの状態と矛盾している為に操作が完了できない場合に利用される</li>
 *     <li>ﾚｽﾎﾟﾝｽにはLocationﾍｯﾀﾞを含む事ができ､そこには競合したﾘｿｰｽなどのURIを指定する</li>
 *     <li>例)存在しないﾃﾞｨﾚｸﾄﾘを削除する</li>
 *     <li>例)名前を変更しようとしたが､既に存在する名前だった</li>
 * </ul>
 *
 * @package SKJ\AppException\HTTP
 * @author y3high <y3public@49364.net>
 * @copyright 2019 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release 0.8.0
 */
class ConflictException extends HttpException
{
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が渡されなかった場合の既定の例外ﾒｯｾｰｼﾞ
     */
    protected $defMessage = 'Conflict';
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が配列で渡された場合にvsprintfに渡すﾌｫｰﾏｯﾄ文字列
     */
    protected $messageTemplate = 'Conflict';
    /**
     * @api
     * @var int ｺﾝｽﾄﾗｸﾀの引数<var>$code</var>が渡されなかった場合の既定の例外ｺｰﾄﾞ
     */
    protected $defCode = 409;
    /**
     * @api
     * @var mixed 補助的に使用される状態ｺｰﾄﾞ(ﾃﾞﾌｫﾙﾄはself::<var>$defCode</var>と同じ)
     */
    protected $statusCode = 409;
}
