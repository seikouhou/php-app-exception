<?php
// このﾌｧｲﾙの名前空間の定義
namespace SKJ\AppException\Logic;

// 別名定義
use SKJ\AppException\LogicException;

/**
 * ﾃﾞｰﾀﾄﾞﾒｲﾝ外値ﾛｼﾞｯｸ例外
 *
 * 定義されたﾃﾞｰﾀﾄﾞﾒｲﾝに値が従わないときにｽﾛｰされる例外です
 *
 * ◆詳細◆
 * <ul>
 *     <li>この例外が発生した場合はｺｰﾄﾞの修正が必要です</li>
 *     <li>基本的には事前に用意されているﾃﾞｰﾀﾘｽﾄに､あるはずの値が存在しない場合などに利用されます</li>
 *     <li>例)存在しない定数が参照された</li>
 * </ul>
 *
 * @package SKJ\AppException\Logic
 * @author y3high <y3public@49364.net>
 * @copyright 2019 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release 0.8.0
 */
class DomainException extends LogicException
{
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が渡されなかった場合の既定の例外ﾒｯｾｰｼﾞ
     */
    protected $defMessage = 'データドメイン外の値が発生しました';
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が配列で渡された場合にvsprintfに渡すﾌｫｰﾏｯﾄ文字列
     */
    protected $messageTemplate = '%sでデータドメイン外の値が発生しました';
    /**
     * @api
     * @var int ｺﾝｽﾄﾗｸﾀの引数<var>$code</var>が渡されなかった場合の既定の例外ｺｰﾄﾞ
     */
    protected $defCode = 1302;
    /**
     * @api
     * @var mixed 補助的に使用される状態ｺｰﾄﾞ(ﾃﾞﾌｫﾙﾄはself::<var>$defCode</var>と同じ)
     */
    protected $statusCode = 1302;
}
