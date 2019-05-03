<?php
// このﾌｧｲﾙの名前空間の定義
namespace SKJ\AppException;

/**
 * ﾊﾞﾘﾃﾞｰｼｮﾝｴﾗｰ実行例外の抽象ｸﾗｽ
 *
 * ﾊﾞﾘﾃﾞｰｼｮﾝ処理がに失敗した場合に使用する例外です
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
class AbstractValidationException extends RuntimeException
{
    /**
     * @api
     * @var int ｴﾗｰとして発生順の早いものから返す
     * @uses self::SORT_ORDER_ASC 初期値として使用
     */
    protected $iteratorSortOrder = self::SORT_ORDER_ASC;

    /**
     * 連結された例外も対象とし、例外ｺｰﾄﾞを変更
     *
     * @api
     * @param int $code 例外ｺｰﾄﾞ
     * @return self 自分自身を返す
     */
    public function setCodeToAll($code)
    {
        $this->setFilter(); // 現在の例外に限定!!

        /**
         * @var self $validError
         */
        foreach ($this as $validError) {

            $validError->setCode($code);
        }

        return $this;
    }

    /**
     * 指定されたﾌｨｰﾙﾄﾞ名に関する例外のみを抽出
     *
     * 第1引数仕様 - 抽出ﾌｨｰﾙﾄﾞ名
     *
     * <code>
     * [
     *     (string)抽出対象のﾌｨｰﾙﾄﾞ => (string|null)変更したいﾌｨｰﾙﾄﾞ名,...
     *                                 ※ﾌｨｰﾙﾄﾞ名の変更の必要が無ければnull
     * ]
     * </code>
     *
     * @api
     * @param array $fields 抽出ﾌｨｰﾙﾄﾞ名
     * @param bool $multiField 複数ﾌｨｰﾙﾄﾞ間に渡ったｴﾗｰも対象とするか
     * @return static|null 抽出された例外、抽出結果がない場合はnull
     */
    public function extractBy(array $fields = [], $multiField = true)
    {
        $exception = null;
        $this->setFilter(); // 現在の例外に限定!!

        /**
         * @var self $validationError
         */
        foreach ($this as $validationError) {

            $errorFields = $validationError->getFields();
            $renameFields = [];
            // 本来のdebug_backtrace()の戻り値とは違ってobjectｴﾝﾄﾘがないので注意
            $callQueue = $validationError->getCallQueue();

            // 複数ﾌｨｰﾙﾄﾞ間に渡ったｴﾗｰで<var>$multiple</var>が偽なら無視
            if (count($errorFields) > 1 and $multiField == false) {

                continue;
            }

            // ﾌｨｰﾙﾄﾞ名情報も変換しておく
            foreach ($errorFields as $field) {

                if (array_key_exists($field, $fields) and
                    !is_null($fields[$field])) {

                    $renameFields[] = $fields[$field];

                } else {

                    $renameFields[] = $field;
                }
            }

            foreach ($fields as $field => $newFieldName) {

                if (array_search($field, $errorFields) !== false) {

                    // Late Static Bindingsを使用しているので注意
                    $exception = (new static(
                        $validationError->getMessage(),
                        $validationError->getCode(),
                        $exception
                    ))->setFields(
                        $renameFields
                    )->setStatusCode($validationError->getStatusCode())->forge(
                        $callQueue
                    );

                    continue 2;
                }
            }
        }

        /**
         * @var self|null $exception
         */
        return $exception;
    }

    /**
     * 指定されたﾌｨｰﾙﾄﾞにｴﾗｰが発生したかを調べる
     *
     * @api
     * @param string|array $fields 調べたいﾌｨｰﾙﾄﾞ名、配列で複数指定も可
     * @param bool $multiField 複数ﾌｨｰﾙﾄﾞ間に渡ったｴﾗｰも対象とするか
     * @return bool ﾌｨｰﾙﾄﾞにｴﾗｰがあれば真、無ければ偽
     */
    public function hasErrorOn($fields, $multiField = true)
    {
        if (!is_array($fields)) {

            $fields = [$fields];
        }

        $this->setFilter(); // 現在の例外に限定!!

        /**
         * @var self $validError
         */
        foreach ($this as $validError) {

            $errorFields = $validError->getFields();

            // 複数ﾌｨｰﾙﾄﾞ間に渡ったｴﾗｰで<var>$multiple</var>が偽なら無視
            if (count($errorFields) > 1 and $multiField == false) {

                continue;
            }

            foreach ($fields as $field) {

                if (array_search($field, $errorFields) !== false) {

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * 発生したｴﾗｰﾒｯｾｰｼﾞを配列にまとめて返す
     *
     * 同一ﾌｨｰﾙﾄﾞに複数ﾒｯｾｰｼﾞが設定されている場合は最初に発生したものが返される
     *
     * 戻り値仕様 - ｴﾗｰﾒｯｾｰｼﾞ配列
     *
     * <code>
     * [
     *     (string)ﾌｨｰﾙﾄﾞ名 => (string)ｴﾗｰﾒｯｾｰｼﾞ,...
     * ]
     * </code>
     *
     * @api
     * @param array $renameFields 変更したいﾌｨｰﾙﾄﾞ名が入った配列(※ﾌｨｰﾙﾄﾞ名が違う可能性もある)
     * @return array ｴﾗｰﾒｯｾｰｼﾞ配列
     */
    public function getMessageArray(array $renameFields = [])
    {
        $result = [];
        $this->setFilter(); // 現在の例外に限定!!

        foreach ($this as $validError) {

            /**
             * @var self $validError
             */
            // 同一ﾌｨｰﾙﾄﾞで複数ﾒｯｾｰｼﾞを返したいのなら新たなﾒｿｯﾄﾞをつくるべき
            foreach ($validError->getFields() as $field) {

                if (array_key_exists($field, $renameFields)) {

                    $field = $renameFields[$field];
                }

                if (!array_key_exists($field, $result)) {

                    $result[$field] = $validError->getMessage();
                }
            }
        }

        return $result;
    }
}
