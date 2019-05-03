<?php
// このﾌｧｲﾙの名前空間の定義
namespace SKJ\AppException\HTTP;

// 別名定義
use SKJ\AppException\HttpException;

/**
 * Bad Request HTTP層実行例外
 *
 * ﾘｸｴｽﾄの構文を間違えている事を示す例外です
 *
 * ◆詳細◆
 * <ul>
 *     <li>異常なﾊﾟﾗﾒｰﾀが指定されたなど､ﾘｸｴｽﾄの構文を間違えている場合に利用される</li>
 *     <li>他の4xx系ｴﾗｰｺｰﾄﾞに適さないようなｹｰｽでも利用される</li>
 *     <li>ｸﾗｲｱﾝﾄは未知の4xxｴﾗｰｺｰﾄﾞを受け取った時に､400と同じ扱いをする</li>
 * </ul>
 *
 * @package SKJ\AppException\HTTP
 * @author y3high <y3public@49364.net>
 * @copyright 2019 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release 0.8.0
 */
class BadRequestException extends HttpException
{
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が渡されなかった場合の既定の例外ﾒｯｾｰｼﾞ
     */
    protected $defMessage = 'Bad Request';
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が配列で渡された場合にvsprintfに渡すﾌｫｰﾏｯﾄ文字列
     */
    protected $messageTemplate = 'Bad Request';
    /**
     * @api
     * @var int ｺﾝｽﾄﾗｸﾀの引数<var>$code</var>が渡されなかった場合の既定の例外ｺｰﾄﾞ
     */
    protected $defCode = 400;
    /**
     * @api
     * @var mixed 補助的に使用される状態ｺｰﾄﾞ(ﾃﾞﾌｫﾙﾄはself::<var>$defCode</var>と同じ)
     */
    protected $statusCode = 400;
}
