<?php
// このﾌｧｲﾙの名前空間の定義
namespace SKJ\AppException\Runtime;

// 別名定義
use SKJ\AppException\AbstractDateTimeException;

/**
 * 期間内ｴﾗｰ実行例外
 *
 * 期間内である事により処理が失敗した場合に使用する例外です
 *
 * ◆詳細◆
 * <ul>
 *     <li>期間内である事により処理が失敗した場合に利用する</li>
 *     <li>例)再利用禁止期間が過ぎていないのに､ﾘｿｰｽに対して操作ﾘｸｴｽﾄが発生した</li>
 * </ul>
 *
 * @package SKJ\AppException\Runtime
 * @author y3high <y3public@49364.net>
 * @copyright 2019 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release 0.8.0
 */
class DurationException extends AbstractDateTimeException
{
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が渡されなかった場合の既定の例外ﾒｯｾｰｼﾞ
     */
    protected $defMessage = '期間が満了ではありません';
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が配列で渡された場合にvsprintfに渡すﾌｫｰﾏｯﾄ文字列
     */
    protected $messageTemplate = '%sはまだ期間内です';
    /**
     * @api
     * @var int ｺﾝｽﾄﾗｸﾀの引数<var>$code</var>が渡されなかった場合の既定の例外ｺｰﾄﾞ
     */
    protected $defCode = 1328;
    /**
     * @api
     * @var mixed 補助的に使用される状態ｺｰﾄﾞ(ﾃﾞﾌｫﾙﾄはself::<var>$defCode</var>と同じ)
     */
    protected $statusCode = 1328;
}
