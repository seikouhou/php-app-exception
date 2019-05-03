<?php
// このﾌｧｲﾙの名前空間の定義
namespace SKJ\AppException\HTTP;

// 別名定義
use SKJ\AppException\HttpException;

/**
 * Unprocessable Entity HTTP層実行例外
 *
 * 構文的に正しいが､意味的に間違っている事を示す例外です
 *
 * ◆詳細◆
 * <ul>
 *     <li>WebDAVにおいて､ｸﾗｲｱﾝﾄが送信したXMLが構文的にはあってはいるが､意味的には間違っている場合に利用される</li>
 *     <li>WebDAVではなくとも､400よりも狭い意味でｴﾗｰを限定したい場合も､このｺｰﾄﾞが利用できる</li>
 *     <li>ﾚｽﾎﾟﾝｽﾎﾞﾃﾞｨにはｴﾗｰ詳細(JSONなどで)を渡す事も可能</li>
 * </ul>
 *
 * @package SKJ\AppException\HTTP
 * @author y3high <y3public@49364.net>
 * @copyright 2019 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release 0.8.0
 */
class UnprocessableEntityException extends HttpException
{
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が渡されなかった場合の既定の例外ﾒｯｾｰｼﾞ
     */
    protected $defMessage = 'Unprocessable Entity';
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が配列で渡された場合にvsprintfに渡すﾌｫｰﾏｯﾄ文字列
     */
    protected $messageTemplate = 'Unprocessable Entity';
    /**
     * @api
     * @var int ｺﾝｽﾄﾗｸﾀの引数<var>$code</var>が渡されなかった場合の既定の例外ｺｰﾄﾞ
     */
    protected $defCode = 422;
    /**
     * @api
     * @var mixed 補助的に使用される状態ｺｰﾄﾞ(ﾃﾞﾌｫﾙﾄはself::<var>$defCode</var>と同じ)
     */
    protected $statusCode = 422;
}
