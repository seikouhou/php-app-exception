<?php
// このﾌｧｲﾙの名前空間の定義
namespace SKJ\AppException\Logic;

/**
 * 依存性の注入ﾛｼﾞｯｸ例外
 *
 * 依存性が満たされていない場合に使用する例外です
 *
 * ◆詳細◆
 * <ul>
 *     <li>外部から必要な依存性が注入されていない場合に利用される</li>
 *     <li>その他､依存性の注入に関連するｴﾗｰでも利用できる</li>
 * </ul>
 *
 * @package SKJ\AppException\Logic
 * @author y3high <y3public@49364.net>
 * @copyright 2019 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release 0.8.0
 */
class DependencyInjectionException extends EnvironmentException
{
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が渡されなかった場合の既定の例外ﾒｯｾｰｼﾞ
     */
    protected $defMessage = '必要とされる依存性が解決していません';
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が配列で渡された場合にvsprintfに渡すﾌｫｰﾏｯﾄ文字列
     */
    protected $messageTemplate = '%sオブジェクトが注入されていません';
    /**
     * @api
     * @var int ｺﾝｽﾄﾗｸﾀの引数<var>$code</var>が渡されなかった場合の既定の例外ｺｰﾄﾞ
     */
    protected $defCode = 1312;
    /**
     * @api
     * @var mixed 補助的に使用される状態ｺｰﾄﾞ(ﾃﾞﾌｫﾙﾄはself::<var>$defCode</var>と同じ)
     */
    protected $statusCode = 1312;
}
