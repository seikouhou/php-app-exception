<?php
// このﾌｧｲﾙの名前空間の定義
namespace SKJ\AppException\HTTP;

// 別名定義
use SKJ\AppException\HttpException;

/**
 * Internal Server Error HTTP層実行例外
 *
 * ｻｰﾊﾞｰ側でｴﾗｰが発生した事を示す例外です
 *
 * ◆詳細◆
 * <ul>
 *     <li>ｻｰﾊﾞｰ側で回復不能なｴﾗｰが発生した場合に利用される</li>
 *     <li>他の5xx系ｴﾗｰｺｰﾄﾞに適さないようなｹｰｽでも利用される</li>
 *     <li>ｸﾗｲｱﾝﾄは未知の5xxｴﾗｰｺｰﾄﾞを受け取った時に､500と同じ扱いをする</li>
 * </ul>
 *
 * @package SKJ\AppException\HTTP
 * @author y3high <y3public@49364.net>
 * @copyright 2019 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release 0.8.0
 */
class InternalServerErrorException extends HttpException
{
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が渡されなかった場合の既定の例外ﾒｯｾｰｼﾞ
     */
    protected $defMessage = 'Internal Server Error';
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が配列で渡された場合にvsprintfに渡すﾌｫｰﾏｯﾄ文字列
     */
    protected $messageTemplate = 'Internal Server Error';
    /**
     * @api
     * @var int ｺﾝｽﾄﾗｸﾀの引数<var>$code</var>が渡されなかった場合の既定の例外ｺｰﾄﾞ
     */
    protected $defCode = 500;
    /**
     * @api
     * @var mixed 補助的に使用される状態ｺｰﾄﾞ(ﾃﾞﾌｫﾙﾄはself::<var>$defCode</var>と同じ)
     */
    protected $statusCode = 500;
}
