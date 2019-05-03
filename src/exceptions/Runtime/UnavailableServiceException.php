<?php
// このﾌｧｲﾙの名前空間の定義
namespace SKJ\AppException\Runtime;

// 別名定義
use SKJ\AppException\AbstractDateTimeException;

/**
 * ｻｰﾋﾞｽ停止例外
 *
 * 対象のｻｰﾋﾞｽが停止中に投げられる例外です
 *
 * ◆詳細◆
 * <ul>
 *     <li>ｻｰﾋﾞｽがﾒﾝﾃﾅﾝｽや障害中で使用できない場合に利用する</li>
 *     <li>例)APIがｻｰﾊﾞｰ障害により利用できなかった</li>
 *     <li>例)ASPｻｰﾋﾞｽがﾒﾝﾃﾅﾝｽ中により利用できなかった</li>
 * </ul>
 *
 * @package SKJ\AppException\Runtime
 * @author y3high <y3public@49364.net>
 * @copyright 2019 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release 0.8.0
 */
class UnavailableServiceException extends AbstractDateTimeException
{
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が渡されなかった場合の既定の例外ﾒｯｾｰｼﾞ
     */
    protected $defMessage = 'サービス停止中です';
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が配列で渡された場合にvsprintfに渡すﾌｫｰﾏｯﾄ文字列
     */
    protected $messageTemplate = '%sはサービス停止中です';
    /**
     * @api
     * @var int ｺﾝｽﾄﾗｸﾀの引数<var>$code</var>が渡されなかった場合の既定の例外ｺｰﾄﾞ
     */
    protected $defCode = 1330;
    /**
     * @api
     * @var mixed 補助的に使用される状態ｺｰﾄﾞ(ﾃﾞﾌｫﾙﾄはself::<var>$defCode</var>と同じ)
     */
    protected $statusCode = 1330;
}
