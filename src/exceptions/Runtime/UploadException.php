<?php
// このﾌｧｲﾙの名前空間の定義
namespace SKJ\AppException\Runtime;

// 別名定義
use SKJ\AppException\RuntimeException;

/**
 * ｱｯﾌﾟﾛｰﾄﾞ実行例外
 *
 * ｱｯﾌﾟﾛｰﾄﾞに失敗した場合に使用する例外です
 *
 * ◆詳細◆
 * <ul>
 *     <li>ｱｯﾌﾟﾛｰﾄﾞに失敗した場合に利用する</li>
 * </ul>
 *
 * @package SKJ\AppException\Runtime
 * @author y3high <y3public@49364.net>
 * @copyright 2019 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release 0.8.0
 */
class UploadException extends RuntimeException
{
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が渡されなかった場合の既定の例外ﾒｯｾｰｼﾞ
     */
    protected $defMessage = 'アップロードに失敗しました';
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が配列で渡された場合にvsprintfに渡すﾌｫｰﾏｯﾄ文字列
     */
    protected $messageTemplate = '%sのアップロードに失敗しました';
    /**
     * @api
     * @var int ｺﾝｽﾄﾗｸﾀの引数<var>$code</var>が渡されなかった場合の既定の例外ｺｰﾄﾞ
     */
    protected $defCode = 1323;
    /**
     * @api
     * @var mixed 補助的に使用される状態ｺｰﾄﾞ(ﾃﾞﾌｫﾙﾄはself::<var>$defCode</var>と同じ)
     */
    protected $statusCode = 1323;
}
