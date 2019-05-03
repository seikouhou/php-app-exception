<?php
// このﾌｧｲﾙの名前空間の定義
namespace SKJ\AppException\Logic;

// 別名定義
use SKJ\AppException\AbstractContainerException;

/**
 * 未知､未分類の例外が連結されたﾛｼﾞｯｸ例外
 *
 * 未知､未分類の例外を受け取った場合､その例外を連結して使用する例外です
 *
 * ◆詳細◆
 * <ul>
 *     <li>呼び出した関数やﾒｿｯﾄﾞから､特に特別な処理をしない(できない)例外を受け取った場合､この例外を連結して再度上流へと投げる為に利用される</li>
 *     <li>呼び出し側に通知が不必要な例外や､発生する事自体を認識していない例外は､全てこの例外に連結することによって､未知､未分類の例外という抽象化をする為に使用する</li>
 *     <li>これを使用する事によってphpdocの記述を単純化させる</li>
 *     <li>また､AppExceptionが持ついくつかの機能では標準で､この例外を無視する仕様となっている(例えばｲﾃﾚｰﾀとして利用時に､この例外だけは飛ばすなど)</li>
 *     <li>この例外のﾒｯｾｰｼﾞ､例外ｺｰﾄﾞ､状態ｺｰﾄﾞ､ﾌｨｰﾙﾄﾞ名などは連結された例外のものが自動的に設定される</li>
 *     <li>この例外が発生した場所と同一ｽｺｰﾌﾟで発生した例外をｺﾝｽﾄﾗｸﾀの引数<var>$previous</var>に渡した場合は､この例外が作成されずに<var>$previous</var>が再ｽﾙｰされる</li>
 *     <li>ｺﾝｽﾄﾗｸﾀの引数<var>$previous</var>にContainerExceptionのｲﾝｽﾀﾝｽが渡された場合は､この例外が作成されずに<var>$previous</var>が再ｽﾙｰされる</li>
 * </ul>
 *
 * @package SKJ\AppException\Logic
 * @author y3high <y3public@49364.net>
 * @copyright 2019 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release 0.8.0
 */
class ContainerException extends AbstractContainerException
{
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が渡されなかった場合の既定の例外ﾒｯｾｰｼﾞ
     */
    protected $defMessage = '未知、未分類の例外です';
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>$message</var>が配列で渡された場合にvsprintfに渡すﾌｫｰﾏｯﾄ文字列
     */
    protected $messageTemplate = '未知、未分類の例外です[%s]';
    /**
     * @api
     * @var int ｺﾝｽﾄﾗｸﾀの引数<var>$code</var>が渡されなかった場合の既定の例外ｺｰﾄﾞ
     */
    protected $defCode = 1201;
    /**
     * @api
     * @var mixed 補助的に使用される状態ｺｰﾄﾞ(ﾃﾞﾌｫﾙﾄはself::<var>$defCode</var>と同じ)
     */
    protected $statusCode = 1201;
}
