<?php
// このﾌｧｲﾙの名前空間の定義
namespace SKJ\AppException\HTTP;

// 別名定義
use SKJ\AppException\HttpException;

/**
 * Precondition Failed HTTP層実行例外
 *
 * 条件付きﾘｸｴｽﾄで指定された事前条件が､ｻｰﾊﾞｰ側で合わない事を示す例外です
 *
 * ◆詳細◆
 * <ul>
 *     <li>条件付きﾘｸｴｽﾄで指定された事前条件が､ｻｰﾊﾞｰ側で合わない場合に利用される</li>
 *     <li>ﾚｽﾎﾟﾝｽには再度ETagﾍｯﾀﾞやLast-Modifiedﾍｯﾀﾞを含む事ができる</li>
 *     <li>条件付きﾘｸｴｽﾄは楽観的ﾛｯｸで利用される</li>
 * </ul>
 *
 * @package SKJ\AppException\HTTP
 * @author y3high <y3public@49364.net>
 * @copyright 2019 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release 0.8.0
 */
class PreconditionFailedException extends HttpException
{
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が渡されなかった場合の既定の例外ﾒｯｾｰｼﾞ
     */
    protected $defMessage = 'Precondition Failed';
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が配列で渡された場合にvsprintfに渡すﾌｫｰﾏｯﾄ文字列
     */
    protected $messageTemplate = 'Precondition Failed';
    /**
     * @api
     * @var int ｺﾝｽﾄﾗｸﾀの引数<var>$code</var>が渡されなかった場合の既定の例外ｺｰﾄﾞ
     */
    protected $defCode = 412;
    /**
     * @api
     * @var mixed 補助的に使用される状態ｺｰﾄﾞ(ﾃﾞﾌｫﾙﾄはself::<var>$defCode</var>と同じ)
     */
    protected $statusCode = 412;
}
