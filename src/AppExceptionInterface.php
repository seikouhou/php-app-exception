<?php
// このﾌｧｲﾙの名前空間の定義
namespace SKJ;

// 別名定義
use Exception;
use IteratorAggregate;

/**
 * AppException ｲﾝﾀｰﾌｪｰｽ
 *
 * @package SKJ\AppException
 * @author y3high <y3public@49364.net>
 * @copyright 2019 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release 0.8.0
 */
interface AppExceptionInterface extends IteratorAggregate
{
    /**
     * このｵﾌﾞｼﾞｪｸﾄをｲﾃﾚｰﾀとして扱った時に返す連結された例外のｿｰﾄ(発生順)定数
     *
     * @api
     */
    const SORT_ORDER_ASC = 0, SORT_ORDER_DESC = 1;

    /**
     * 例外ﾒｯｾｰｼﾞを取得する
     *
     * ※\Exceptionから継承
     *
     * @api
     * @return string 例外ﾒｯｾｰｼﾞ文字列
     */
    public function getMessage();

    /**
     * 前の例外を返す
     *
     * ※\Exceptionから継承
     *
     * @api
     * @return self 前に発生したApp例外､もしくはNULL
     */
    public function getPrevious();

    /**
     * 例外ｺｰﾄﾞを取得する
     *
     * ※\Exceptionから継承
     *
     * @api
     * @return int 例外ｺｰﾄﾞ
     */
    public function getCode();

    /**
     * 例外が作られたﾌｧｲﾙを取得する
     *
     * ※\Exceptionから継承
     *
     * @api
     * @return string 例外が作られたﾌｧｲﾙの名前
     */
    public function getFile();

    /**
     * 例外が作られた行を取得する
     *
     * ※\Exceptionから継承
     *
     * @api
     * @return int 例外が作られた行番号
     */
    public function getLine();

    /**
     * ｽﾀｯｸﾄﾚｰｽを取得する
     *
     * ※\Exceptionから継承
     *
     * @api
     * @return array 例外のｽﾀｯｸﾄﾚｰｽ
     */
    public function getTrace();

    /**
     * ｽﾀｯｸﾄﾚｰｽを文字列で取得する
     *
     * ※\Exceptionから継承
     *
     * @api
     * @return string 例外のｽﾀｯｸﾄﾚｰｽの文字列表現
     */
    public function getTraceAsString();

    /**
     * 例外生成時のｸﾞﾛｰﾊﾞﾙｽｺｰﾌﾟの変数情報を取得
     *
     * @api
     * @return array ｸﾞﾛｰﾊﾞﾙ変数情報
     */
    public function getGlobalVars();

    /**
     * 例外生成時のﾛｰｶﾙｽｺｰﾌﾟの変数情報を取得
     *
     * @api
     * @return array ﾛｰｶﾙ変数情報
     */
    public function getCallerVars();

    /**
     * 基底例外ｺｰﾄﾞを取得
     *
     * ﾌｧｲﾙごとにﾕﾆｰｸになる、そのﾌｧｲﾙ中で例外ｺｰﾄﾞの基底とすべき数値を返す
     *
     * @api
     * @param string $fileName ﾌｧｲﾙの絶対ﾊﾟｽ
     * @return int|null 基底例外ｺｰﾄﾞ、もう発行できない場合はnull
     */
    public static function getBaseExceptionCode($fileName);

    /**
     * AppExceptionがｴｸｽﾃﾝｼｮﾝを読み込んでいるかどうか調べる
     *
     * ｴｸｽﾃﾝｼｮﾝを読み込んでいれば、ｲﾝｽﾀﾝｽ生成時のﾛｰｶﾙｽｺｰﾌﾟの変数情報を取得する事ができる
     *
     * @api
     * @return bool ｴｸｽﾃﾝｼｮﾝを読み込んでいれば真、そうでなければ偽
     */
    public static function isExtension();

    /**
     * 現在の例外ｸﾗｽ名を取得
     *
     * @api
     * @return string ｸﾗｽ名
     */
    public function getClass();

    /**
     * 例外生成時の例外ﾒｿｯﾄﾞ名を取得
     *
     * ※これは当然ｺﾝｽﾄﾗｸﾀになる(getFile()、getLine()などに合わせて存在)
     *
     * @api
     * @return string 関数(ﾒｿｯﾄﾞ)名
     */
    public function getFunction();

    /**
     * 現在のｺｰﾙｷｭｰ情報を取得する
     *
     * @api
     * @return array ｺｰﾙｷｭｰ情報
     */
    public function getCallQueue();

    /**
     * 例外生成場所を変更
     *
     * 例外生成場所をこのﾒｿｯﾄﾞが呼ばれた場所に擬似的に変更する
     *
     * 引数に他のApp例外のｺｰﾙｷｭｰ情報を渡せば、そのApp例外の発生場所と同じにできる
     *
     * @api
     * @param array|null $callQueue self::getCallQueue()で得られるｺｰﾙｷｭｰ情報
     * @return self 自分自身を返す
     */
    public function forge(array $callQueue = null);

    /**
     * この例外の生成場所が現在のｺﾝﾃｷｽﾄに含まれるか調べる
     *
     * ここで意味するｺﾝﾃｷｽﾄは当ﾒｿｯﾄﾞをｺｰﾙした箇所の変数のｽｺｰﾌﾟとほぼ同じ範囲だが、include、reuqire、include_once、require_onceでの飛び先は含まないので注意
     *
     * @api
     * @param array|null $debugBackTrace 例外生成時のｺｰﾙｷｭｰ情報と比較する為のｺｰﾙｽﾀｯｸ情報、通常は指定してはいけない
     * @return bool 含まれているのなら真、そうでないのなら偽
     */
    public function wasCreatedInCurrentContext(array $debugBackTrace = null);

    /**
     * 同一ﾌｧｲﾙでの例外発生行を取得
     *
     * 現在の(このﾒｿｯﾄﾞを呼び出した)ｺﾝﾃｷｽﾄから見て、どの行で発生した例外か調べる
     *
     * @api
     * @return int|bool 例外発生行、もしくは取得失敗時に偽
     */
    public function getLineInCurrentContext();

    /**
     * 同一ﾌｧｲﾙでの例外発生関数名を取得
     *
     * 現在の(このﾒｿｯﾄﾞを呼び出した)ｺﾝﾃｷｽﾄから見て、どの関数、ﾒｿｯﾄﾞ呼び出しで発生した例外か調べる
     *
     * @api
     * @return string|bool 例外発生関数名、もしくは取得失敗時に偽
     */
    public function getFunctionInCurrentContext();

    /**
     * 同一ﾌｧｲﾙでの例外発生関数の引数を取得
     *
     * 現在の(このﾒｿｯﾄﾞを呼び出した)ｺﾝﾃｷｽﾄから見て、この例外が発生した関数、ﾒｿｯﾄﾞの引数を取得する
     *
     * @api
     * @return array|bool 例外発生関数の引数、もしくは取得失敗時に偽
     */
    public function getFuncArgsInCurrentContext();

    /**
     * 例外の発生源を識別する情報を設定
     *
     * 例外の発生源を識別する情報(ﾊﾞﾘﾃﾞｰｼｮﾝｴﾗｰならばｶﾗﾑ名など)を設定する機能だが、特に必要なければ使用しなくとも良い
     *
     * @api
     * @param string|array $fields,... 例外の発生源(複数なら配列や引数を増やす)を識別する情報
     * @return self 自分自身を返す
     */
    public function setFields(...$fields);

    /**
     * 例外の発生源を識別する情報を取得
     *
     * 例外の発生源を識別する情報(ﾊﾞﾘﾃﾞｰｼｮﾝｴﾗｰならばｶﾗﾑ名など)を取得する機能だが、特に必要なければ使用しなくとも良い
     *
     * @api
     * @return array 例外の発生源を識別する情報が格納された配列
     */
    public function getFields();

    /**
     * 例外ﾒｯｾｰｼﾞを設定
     *
     * @api
     * @param string $message 例外ﾒｯｾｰｼﾞ
     * @return self 自分自身を返す
     */
    public function setMessage($message);

    /**
     * 例外ｺｰﾄﾞを設定
     *
     * int型以外が渡されると既定の例外ｺｰﾄﾞが設定される
     *
     * @api
     * @param int $code 例外ｺｰﾄﾞ
     * @return self 自分自身を返す
     */
    public function setCode($code);

    /**
     * 例外が発生したﾌｧｲﾙを設定
     *
     * @api
     * @param string $file 例外が発生したﾌｧｲﾙ
     * @return self 自分自身を返す
     */
    public function setFile($file);

    /**
     * 例外が発生した行を設定
     *
     * @api
     * @param int $line 例外が発生した行
     * @return self 自分自身を返す
     */
    public function setLine($line);

    /**
     * 状態ｺｰﾄﾞを設定
     *
     * 例外ｺｰﾄﾞとは別に補助的に使用できるｺｰﾄﾞとして自由に利用して下さい
     *
     * @api
     * @param mixed $statusCode 状態ｺｰﾄﾞ
     * @return self 自分自身を返す
     */
    public function setStatusCode($statusCode);

    /**
     * 状態ｺｰﾄﾞを取得
     *
     * 例外ｺｰﾄﾞとは別に補助的に使用できるｺｰﾄﾞとして自由に利用して下さい
     *
     * @api
     * @return mixed 状態ｺｰﾄﾞ
     */
    public function getStatusCode();

    /**
     * AppExceptionに強制変換する前の例外を保存する
     *
     * @internal
     * @param \Exception $exception 強制変換される前の例外
     * @return self 自分自身を返す
     */
    public function setOriginalException(Exception $exception);

    /**
     * AppExceptionに強制変換される前の例外を取得する
     *
     * @api
     * @return \Exception|null 強制変換される前の例外、未設定ならnull
     */
    public function getOriginalException();

    /**
     * AppExceptionに強制変換される前の例外ｸﾗｽ名を取得する
     *
     * @api
     * @return string|null 強制変換される前の例外ｸﾗｽ名、未設定ならnull
     */
    public function getOriginalClassName();

    /**
     * ｲﾃﾚｰﾀとして動作時に\SKJ\AppException\Logic\ContainerExceptionをｽｷｯﾌﾟする
     *
     * @api
     * @return self 自分自身を返す
     */
    public function enableSkipContainer();

    /**
     * ｲﾃﾚｰﾀとして動作時に\SKJ\AppException\Logic\ContainerExceptionをｽｷｯﾌﾟしない
     *
     * @api
     * @return self 自分自身を返す
     */
    public function disableSkipContainer();

    /**
     * ｲﾃﾚｰﾀとして扱った時の並び順(発生順)を制御
     *
     * @api
     * @param int $order 並び順
     * @return self 自分自身を返す
     * @uses self::SORT_ORDER_ASC 昇順でｿｰﾄ時に<var>$order</var>に指定
     * @uses self::SORT_ORDER_DESC 降順でｿｰﾄ時に<var>$order</var>に指定
     */
    public function setSortOrder($order = self::SORT_ORDER_DESC);

    /**
     * ｲﾃﾚｰﾀとして扱った時に抽出するｸﾗｽ設定を初期化
     *
     * @api
     * @return self 自分自身を返す
     */
    public function resetFilter();

    /**
     * ｲﾃﾚｰﾀとして扱った時に抽出するｸﾗｽを設定
     *
     * @api
     * @param string|null $className 抽出対象となるｸﾗｽ名、null時は現ｲﾝｽﾀﾝｽと同一のｸﾗｽのみ対象とする
     * @return self 自分自身を返す
     */
    public function setFilter($className = null);

    /**
     * 外部ｲﾃﾚｰﾀを返す
     *
     * @internal
     * @return \Traversable 外部ｲﾃﾚｰﾀ
     */
    public function getIterator();

    /**
     * 連結された例外のﾘｽﾄをﾛｸﾞとして返す
     *
     * ﾛｸﾞﾌｫｰﾏｯﾄは"[ｸﾗｽ名] -> ﾌｧｲﾙ名(発生行) [例外ｺｰﾄﾞ]例外ﾒｯｾｰｼﾞ\n 文字列化されたｽﾀｯｸﾄﾚｰｽ"となる
     *
     * @api
     * @return array ﾛｸﾞﾒｯｾｰｼﾞが格納された配列
     */
    public function getExceptionLog();

    /**
     * 例外再構築処理
     *
     * 現在の例外が第1引数に指定された条件(例外ｺｰﾄﾞ)に当てはまるのならば、現在の例外を基に新規例外を作成する
     *
     * なお、新規例外には現在の例外を連結して返す
     *
     * 第1引数仕様 - 例外再構成情報配列
     *
     * <code>
     * [
     *     (int)対象の例外ｺｰﾄﾞ => [
     *         (int|null)設定する例外ｺｰﾄﾞ(null指定時は元の値から変更しない),
     *         (string|null)新規作成するAppException系例外ｸﾗｽ名(null指定時は元のｸﾗｽから変更しない),
     *         (string|null)設定する例外ﾒｯｾｰｼﾞ(null指定時は元の値から変更しない)
     *     ] | (int)設定する例外ｺｰﾄﾞ | (\SKJ\AppExceptionInterface)置き換えるAppException系例外,...
     * ]
     * </code>
     *
     * @api
     * @param array $replacement 例外再構成情報配列
     * @return self|\SKJ\AppExceptionInterface|\SKJ\AppException\Logic\ContainerException <var>$replacement</var>に該当する例外ｺｰﾄﾞのｷｰがあれば、そのｴﾝﾄﾘで指定されたAppException系例外、もし該当する例外ｺｰﾄﾞが無い場合は、renew()の呼び出し元と同一ｺﾝﾃｷｽﾄで生成された例外であれば自分自身をそのまま返し、そうでなければ\SKJ\AppException\Logic\ContainerExceptionｸﾗｽのｲﾝｽﾀﾝｽを返す
     */
    public function renew(array $replacement);
}
