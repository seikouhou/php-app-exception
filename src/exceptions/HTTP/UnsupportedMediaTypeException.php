<?php
// このﾌｧｲﾙの名前空間の定義
namespace SKJ\AppException\HTTP;

// 別名定義
use SKJ\AppException\HttpException;

/**
 * Unsupported Media Type HTTP層実行例外
 *
 * 処理できないﾒﾃﾞｨｱﾀｲﾌﾟである事を示す例外です
 *
 * ◆詳細◆
 * <ul>
 *     <li>ﾘｸｴｽﾄに指定されたﾒﾃﾞｨｱﾀｲﾌﾟをｻｰﾊﾞｰ側がｻﾎﾟｰﾄできない場合に利用される</li>
 *     <li>例)JPG形式しか保存できないｻｰﾊﾞｰに､GIF形式で保存しようとした</li>
 * </ul>
 *
 * @package SKJ\AppException\HTTP
 * @author y3high <y3public@49364.net>
 * @copyright 2019 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release 0.8.0
 */
class UnsupportedMediaTypeException extends HttpException
{
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が渡されなかった場合の既定の例外ﾒｯｾｰｼﾞ
     */
    protected $defMessage = 'Unsupported Media Type';
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が配列で渡された場合にvsprintfに渡すﾌｫｰﾏｯﾄ文字列
     */
    protected $messageTemplate = 'Unsupported Media Type';
    /**
     * @api
     * @var int ｺﾝｽﾄﾗｸﾀの引数<var>$code</var>が渡されなかった場合の既定の例外ｺｰﾄﾞ
     */
    protected $defCode = 415;
    /**
     * @api
     * @var mixed 補助的に使用される状態ｺｰﾄﾞ(ﾃﾞﾌｫﾙﾄはself::<var>$defCode</var>と同じ)
     */
    protected $statusCode = 415;
}
