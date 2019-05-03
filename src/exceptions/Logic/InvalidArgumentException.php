<?php
// このﾌｧｲﾙの名前空間の定義
namespace SKJ\AppException\Logic;

// 別名定義
use SKJ\AppException\LogicException;

/**
 * 引数異常ﾛｼﾞｯｸ例外
 *
 * 無効な引数を受け取った場合にｽﾛｰされる例外です
 *
 * ◆詳細◆
 * <ul>
 *     <li>この例外が発生した場合はｺｰﾄﾞの修正が必要です</li>
 *     <li>基本的にはｼｸﾞﾈﾁｬ&phpdocのparamから読み取れる情報が満たされていない場合や､ｺｰﾄﾞ修正が発生するようなｹｰｽに利用されます</li>
 *     <li>例)ｼｸﾞﾈﾁｬに反する型の引数を受け取った</li>
 *     <li>例)必要な数の引数が渡されなかった</li>
 * </ul>
 *
 * @package SKJ\AppException\Logic
 * @author y3high <y3public@49364.net>
 * @copyright 2019 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release 0.8.0
 */
class InvalidArgumentException extends LogicException
{
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が渡されなかった場合の既定の例外ﾒｯｾｰｼﾞ
     */
    protected $defMessage = '';
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が配列で渡された場合にvsprintfに渡すﾌｫｰﾏｯﾄ文字列
     */
    protected $messageTemplate = '%sで無効な引数を受け取りました';
    /**
     * @api
     * @var int ｺﾝｽﾄﾗｸﾀの引数<var>$code</var>が渡されなかった場合の既定の例外ｺｰﾄﾞ
     */
    protected $defCode = 1303;
    /**
     * @api
     * @var mixed 補助的に使用される状態ｺｰﾄﾞ(ﾃﾞﾌｫﾙﾄはself::<var>$defCode</var>と同じ)
     */
    protected $statusCode = 1303;
}
