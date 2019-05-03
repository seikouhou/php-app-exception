<?php
// このﾌｧｲﾙの名前空間の定義
namespace SKJ\AppException\HTTP;

// 別名定義
use SKJ\AppException\HttpException;

/**
 * Not Implemented HTTP層実行例外
 *
 * ﾘｸｴｽﾄされたﾒｿｯﾄﾞが､このﾘｿｰｽでは提供していない事を示す例外です
 *
 * ◆詳細◆
 * <ul>
 *     <li>あるURIにおいて､本来なら実装されるべきﾒｿｯﾄﾞが現時点ではｻﾎﾟｰﾄされていない場合に利用される</li>
 *     <li>405 Method Not Allowedとの違いとしては､いつかは実装されるという事であり､その為に5xx系となっている</li>
 * </ul>
 *
 * @package SKJ\AppException\HTTP
 * @author y3high <y3public@49364.net>
 * @copyright 2019 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release 0.8.0
 */
class NotImplementedException extends HttpException
{
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が渡されなかった場合の既定の例外ﾒｯｾｰｼﾞ
     */
    protected $defMessage = 'Not Implemented';
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が配列で渡された場合にvsprintfに渡すﾌｫｰﾏｯﾄ文字列
     */
    protected $messageTemplate = 'Not Implemented';
    /**
     * @api
     * @var int ｺﾝｽﾄﾗｸﾀの引数<var>$code</var>が渡されなかった場合の既定の例外ｺｰﾄﾞ
     */
    protected $defCode = 501;
    /**
     * @api
     * @var mixed 補助的に使用される状態ｺｰﾄﾞ(ﾃﾞﾌｫﾙﾄはself::<var>$defCode</var>と同じ)
     */
    protected $statusCode = 501;
}
