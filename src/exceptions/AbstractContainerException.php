<?php
// このﾌｧｲﾙの名前空間の定義
namespace SKJ\AppException;

// 別名定義
use SKJ\AppExceptionInterface;

/**
 * 未知、未分類の例外が連結されたﾛｼﾞｯｸ例外の抽象ｸﾗｽ
 *
 * 未知、未分類の例外を受け取った場合、その例外を連結して使用する例外です
 *
 * ◆詳細◆
 * <ul>
 *     <li>このｸﾗｽは抽象ｸﾗｽです</li>
 * </ul>
 *
 * @package SKJ\AppException
 * @version 0.8.0
 * @author y3high <y3public@49364.net>
 * @copyright 2019 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release 0.8.0
 */
abstract class AbstractContainerException extends LogicException
{
    /**
     * 独自初期化処理
     *
     * AppExceptionのｺﾝｽﾄﾗｸﾀから呼ばれる、この例外の初期化処理です
     *
     * @internal
     * @return bool 成功時に真、ｺﾝｽﾄﾗｸﾀに連結される例外が渡されていない場合は偽
     * @throws \SKJ\AppExceptionInterface 梱包の必要がない場合は連結された例外をそのまま投げる
     */
    protected function initialize()
    {
        /** @var \SKJ\AppExceptionInterface $previous */
        $previous = $this->getPrevious();

        // 梱包すべき例外がｾｯﾄされていない
        if (!$previous instanceof AppExceptionInterface) {

            return false;
        }

        // ニ度は梱包しない
        if (get_class($previous) === get_class($this)) {

            throw $previous;
        }

        // 同一ｺﾝﾃｷｽﾄで発生した例外はそのまま放流
        $debugBackTrace = debug_backtrace();
        // __construct() → initialize()の流れなので1つ除去する必要有り!!
        array_shift($debugBackTrace);
        if ($previous->wasCreatedInCurrentContext($debugBackTrace)) {

            // 以前の例外はｺﾝｽﾄﾗｸﾀで必ずApp系に変換されているはずなので!!
            throw $previous;
        }

        // 各種情報はそのまま継承する
        $this->setMessage($previous->getMessage());
        $this->setCode($previous->getCode());
        $this->setFields($previous->getFields());
        $this->setStatusCode($previous->getStatusCode());

        return true;
    }
}
