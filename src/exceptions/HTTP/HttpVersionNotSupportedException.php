<?php
// このﾌｧｲﾙの名前空間の定義
namespace SKJ\AppException\HTTP;

// 別名定義
use SKJ\AppException\HttpException;

/**
 * HTTP Version Not Supported HTTP層実行例外
 *
 * ｻﾎﾟｰﾄ外のHTTPﾊﾞｰｼﾞｮﾝである事を示す例外です
 *
 * ◆詳細◆
 * <ul>
 *     <li>ｸﾗｲｱﾝﾄが送信したﾘｸｴｽﾄが､ｻｰﾊﾞｰ側でｻﾎﾟｰﾄしていないHTTPﾊﾞｰｼﾞｮﾝである場合に利用される</li>
 * </ul>
 *
 * @package SKJ\AppException\HTTP
 * @author y3high <y3public@49364.net>
 * @copyright 2019 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release 0.8.0
 */
class HttpVersionNotSupportedException extends HttpException
{
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が渡されなかった場合の既定の例外ﾒｯｾｰｼﾞ
     */
    protected $defMessage = 'HTTP Version Not Supported';
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が配列で渡された場合にvsprintfに渡すﾌｫｰﾏｯﾄ文字列
     */
    protected $messageTemplate = 'HTTP Version Not Supported';
    /**
     * @api
     * @var int ｺﾝｽﾄﾗｸﾀの引数<var>$code</var>が渡されなかった場合の既定の例外ｺｰﾄﾞ
     */
    protected $defCode = 505;
    /**
     * @api
     * @var mixed 補助的に使用される状態ｺｰﾄﾞ(ﾃﾞﾌｫﾙﾄはself::<var>$defCode</var>と同じ)
     */
    protected $statusCode = 505;
}
