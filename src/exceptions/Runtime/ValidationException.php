<?php
// このﾌｧｲﾙの名前空間の定義
namespace SKJ\AppException\Runtime;

// 別名定義
use SKJ\AppException\AbstractValidationException;

/**
 * ﾊﾞﾘﾃﾞｰｼｮﾝｴﾗｰ実行例外
 *
 * ﾊﾞﾘﾃﾞｰｼｮﾝ処理が失敗した場合に使用する例外です
 *
 * ◆詳細◆
 * <ul>
 *     <li>ﾊﾞﾘﾃﾞｰｼｮﾝ処理が失敗した場合に利用する</li>
 *     <li>例)ﾕｰｻﾞｰ入力のﾁｪｯｸで､異常なﾃﾞｰﾀを発見した</li>
 * </ul>
 *
 * @package SKJ\AppException\Runtime
 * @author y3high <y3public@49364.net>
 * @copyright 2019 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release 0.8.0
 */
class ValidationException extends AbstractValidationException
{
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が渡されなかった場合の既定の例外ﾒｯｾｰｼﾞ
     */
    protected $defMessage = '入力された値が間違っています';
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が配列で渡された場合にvsprintfに渡すﾌｫｰﾏｯﾄ文字列
     */
    protected $messageTemplate = '%sに入力された値が間違っています[%s]';
    /**
     * @api
     * @var int ｺﾝｽﾄﾗｸﾀの引数<var>$code</var>が渡されなかった場合の既定の例外ｺｰﾄﾞ
     */
    protected $defCode = 1316;
    /**
     * @api
     * @var mixed 補助的に使用される状態ｺｰﾄﾞ(ﾃﾞﾌｫﾙﾄはself::<var>$defCode</var>と同じ)
     */
    protected $statusCode = 1316;
}
