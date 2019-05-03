<?php
// このﾌｧｲﾙの名前空間の定義
namespace SKJ\AppException;

/**
 * HTTP層実行例外
 *
 * HTTP層で必要となる､HTTPﾚｽﾎﾟﾝｽを生成する基となる情報を保持する例外です
 *
 * ◆詳細◆
 * <ul>
 *     <li>この例外を単体では使用せずに､この例外を継承した例外を使用する</li>
 *     <li>ｺｰﾄﾞはHTTPﾚｽﾎﾟﾝｽのｽﾃｰﾀｽﾗｲﾝのｽﾃｰﾀｽｺｰﾄﾞとなる</li>
 *     <li>ﾒｯｾｰｼﾞはHTTPﾚｽﾎﾟﾝｽのｽﾃｰﾀｽﾗｲﾝの結果ﾌﾚｰｽﾞとなる</li>
 *     <li>HTTPﾚｽﾎﾟﾝｽﾍｯﾀﾞを設定できる</li>
 *     <li>HTTPﾚｽﾎﾟﾝｽｸｯｷｰを設定できる</li>
 *     <li>HTTPﾚｽﾎﾟﾝｽﾎﾞﾃﾞｨを設定できる</li>
 * </ul>
 *
 * @package SKJ\AppException
 * @version 0.8.0
 * @author y3high <y3public@49364.net>
 * @copyright 2019 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release 0.8.0
 */
class HttpException extends AbstractHttpException
{
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が渡されなかった場合の既定の例外ﾒｯｾｰｼﾞ
     */
    protected $defMessage = 'Internal Server Error';
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が配列で渡された場合にvsprintfに渡すﾌｫｰﾏｯﾄ文字列
     */
    protected $messageTemplate = 'Internal Server Error';
    /**
     * @api
     * @var int ｺﾝｽﾄﾗｸﾀの引数<var>$code</var>が渡されなかった場合の既定の例外ｺｰﾄﾞ
     */
    protected $defCode = 500;
    /**
     * @api
     * @var mixed 補助的に使用される状態ｺｰﾄﾞ(ﾃﾞﾌｫﾙﾄはself::<var>$defCode</var>と同じ)
     */
    protected $statusCode = 500;
    /**
     * @api
     * @var int このｵﾌﾞｼﾞｪｸﾄをｲﾃﾚｰﾀとして扱った時に返す連結された例外のｿｰﾄ順
     * @uses self::SORT_ORDER_DESC 初期値として使用
     */
    protected $iteratorSortOrder = self::SORT_ORDER_DESC;
}
