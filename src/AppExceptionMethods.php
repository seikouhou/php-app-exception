<?php
/** @noinspection PhpDocSignatureInspection */

// このﾌｧｲﾙの名前空間の定義
namespace SKJ;

// 別名定義
use ArrayIterator;
use Exception;
use SKJ\AppException\Logic\ContainerException;

/**
 * AppException共通ﾒｿｯﾄﾞ郡 ﾄﾚｲﾄ
 *
 * AppExceptionで使用されるﾒｿｯﾄﾞを集めたものです
 *
 * @package SKJ\AppException
 * @author y3high <y3public@49364.net>
 * @copyright 2019 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release 0.8.0
 */
trait AppExceptionMethods
{
    /**
     * @internal
     * @var array 例外の発生源を識別する情報が格納された配列
     */
    private $fields = [];
    /**
     * @internal
     * @var array 例外生成時のｺｰﾙｷｭｰ(ｺｰﾙｽﾀｯｸをFIFOで格納したもの)
     */
    private $callQueue = [];
    /**
     * @internal
     * @var array|null 例外生成場所が変更されたｺｰﾙｷｭｰ
     */
    private $forgedCallQueue = null;
    /**
     * @internal
     * @var \Exception|null AppExceptionに強制変換される前の例外を保存
     */
    private $originalException = null;
    /**
     * @internal
     * @var array|null この例外を配列として扱うときに対象となるﾃﾞｰﾀを格納する配列
     */
    private $iteratorTargetArray = null;
    /**
     * @internal
     * @var bool ｲﾃﾚｰﾀとして動作時に\SKJ\AppException\Logic\ContainerExceptionをｽｷｯﾌﾟするかどうかの真偽値
     */
    private $skipContainer = true;
    /**
     * @internal
     * @var array ﾌｧｲﾙ別に例外ｺｰﾄﾞの基底値を保存した配列
     */
    private static $becHashTable = [];
    /**
     * @internal
     * @var int 発行された基底例外ｺｰﾄﾞ総数
     */
    private static $publishedBecTotalCount = 0;

    /**
     * 例外生成時のｸﾞﾛｰﾊﾞﾙｽｺｰﾌﾟの変数情報を取得
     *
     * @api
     * @return array ｸﾞﾛｰﾊﾞﾙ変数情報
     */
    abstract public function getGlobalVars();

    /**
     * 例外生成時のﾛｰｶﾙｽｺｰﾌﾟの変数情報を取得
     *
     * @api
     * @return array ﾛｰｶﾙ変数情報
     */
    abstract public function getCallerVars();

    /**
     * 基底例外ｺｰﾄﾞを取得
     *
     * ﾌｧｲﾙごとにﾕﾆｰｸになる、そのﾌｧｲﾙ中で例外ｺｰﾄﾞの基底とすべき数値を返す
     *
     * @api
     * @param string $fileName ﾌｧｲﾙの絶対ﾊﾟｽ
     * @return int|null 基底例外ｺｰﾄﾞ、もう発行できない場合はnull
     */
    public static function getBaseExceptionCode($fileName)
    {
        $coefficient = self::MAX_LINE_IN_FILE + 1;

        if (!array_key_exists($fileName, AppException::$becHashTable)) {

            AppException::$becHashTable[$fileName] =
                (int)(++AppException::$publishedBecTotalCount * $coefficient);
        }

        if (AppException::$publishedBecTotalCount ===
            (intval(PHP_INT_MAX / $coefficient) - 1)) {

            return null;
        }

        return AppException::$becHashTable[$fileName];
    }

    /**
     * AppExceptionがｴｸｽﾃﾝｼｮﾝを読み込んでいるかどうか調べる
     *
     * ｴｸｽﾃﾝｼｮﾝを読み込んでいれば、ｲﾝｽﾀﾝｽ生成時のﾛｰｶﾙｽｺｰﾌﾟの変数情報を取得する事ができる
     *
     * @api
     * @return bool ｴｸｽﾃﾝｼｮﾝを読み込んでいれば真、そうでなければ偽
     */
    public static function isExtension()
    {
        return is_subclass_of('\SKJ\AppException', '_AppException');
    }

    /**
     * 現在の例外ｸﾗｽ名を取得
     *
     * @api
     * @return string ｸﾗｽ名
     */
    public function getClass()
    {
        return get_class($this);
    }

    /**
     * 例外生成時の例外ﾒｿｯﾄﾞ名を取得
     *
     * ※これは当然ｺﾝｽﾄﾗｸﾀになる(getFile()、getLine()などに合わせて存在)
     *
     * @api
     * @return string 関数(ﾒｿｯﾄﾞ)名
     */
    public function getFunction()
    {
        return get_class($this).'::__construct';
    }

    /**
     * 通常の例外をAppException例外に変換する
     *
     * @internal
     * @param \Exception $exception 変換する通常例外
     * @return \SKJ\AppException 変換後のAppException例外
     */
    protected function convertToAppException(Exception $exception)
    {
        if (get_class($exception) != 'SKJ\AppException' and
            !is_subclass_of($exception, 'SKJ\AppException')) {

            // 本来のdebug_backtrace()の戻り値とは違ってobjectｴﾝﾄﾘがないので注意
            $debugBackTrace = $exception->getTrace();

            // __construct突入時のﾊﾞｯｸﾄﾚｰｽ情報が無いはずので追加
            array_unshift(
                $debugBackTrace,
                [
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'function' => '__construct',
                    'class' => 'Exception',
                    // 本来はｺﾝｽﾄﾗｸﾀが実際に実装されているｸﾗｽで、ｺﾝｽﾄﾗｸﾀがｵｰﾊﾞｰﾗｲﾄﾞされてると違ってくるはず
                    'object' => $exception, // 現時点ではいらないが念の為
                    'type' => '->',
                    'args' => [
                        $exception->getMessage(),
                        $exception->getCode(),
                        $exception->getPrevious(),
                    ],
                ]
            );

            // AppExceptionに変換
            $exception = (new AppException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception->getPrevious()
            ))->setFile(
                $exception->getFile()
            )->setLine(
                $exception->getLine()
            )->setOriginalException(
                $exception
            )->forge(
                $debugBackTrace
            );
        }

        /** @var \SKJ\AppException $exception */
        return $exception;
    }

    /**
     * 現在のｺｰﾙｷｭｰ情報を取得する
     *
     * @api
     * @return array ｺｰﾙｷｭｰ情報
     */
    public function getCallQueue()
    {
        return is_null($this->getForgedCallQueue()) ?
            $this->getOriginalCallQueue() : $this->getForgedCallQueue();
    }

    /**
     * 例外生成時のｺｰﾙｷｭｰ情報を取得する
     *
     * forge()により処理されていないｵﾘｼﾞﾅﾙのﾊﾞｯｸﾄﾚｰｽ情報を取得する
     *
     * @internal
     * @return array ｺｰﾙｷｭｰ情報
     */
    private function getOriginalCallQueue()
    {
        return $this->callQueue;
    }

    /**
     * forge()により変更されたｺｰﾙｷｭｰ情報を取得する
     *
     * @internal
     * @return array|null ｺｰﾙｷｭｰ情報、変更されていないのならnull
     */
    private function getForgedCallQueue()
    {
        return $this->forgedCallQueue;
    }

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
    public function forge(array $callQueue = null)
    {
        if (is_null($callQueue)) {

            $this->forgedCallQueue = array_reverse(debug_backtrace());

        } else {

            $this->forgedCallQueue = $callQueue;
        }

        return $this;
    }

    /**
     * この例外の生成場所が現在のｺﾝﾃｷｽﾄに含まれるか調べる
     *
     * ここで意味するｺﾝﾃｷｽﾄは当ﾒｿｯﾄﾞをｺｰﾙした箇所の変数のｽｺｰﾌﾟとほぼ同じ範囲だが、include、reuqire、include_once、require_onceでの飛び先は含まないので注意
     *
     * @api
     * @param array|null $debugBackTrace 例外生成時のｺｰﾙｷｭｰ情報と比較する為のｺｰﾙｽﾀｯｸ情報、通常は指定してはいけない
     * @return bool 含まれているのなら真、そうでないのなら偽
     */
    public function wasCreatedInCurrentContext(array $debugBackTrace = null)
    {
        // ﾒｿｯﾄﾞ呼び出し時のｺｰﾙｷｭｰ情報
        $tmpCallQueue = array_reverse(
            is_null($debugBackTrace) ? debug_backtrace() : $debugBackTrace
        );

        // 例外生成(本ｲﾝｽﾀﾝｽのnew)時のｺｰﾙｷｭｰ情報
        $occCallQueue = $this->getCallQueue();

        // 実行開始時からのｺｰﾙｷｭｰを辿る…
        for ($i = 0; $i < count($tmpCallQueue); ++$i) {

            if (!array_key_exists($i, $occCallQueue)) {

                return false;
            }

            // ﾒｿｯﾄﾞ呼び出し時のｺｰﾙｷｭｰ情報
            $callerFile = array_key_exists('file', $tmpCallQueue[$i]) ?
                $tmpCallQueue[$i]['file'] : null;
            $callerLine = array_key_exists('line', $tmpCallQueue[$i]) ?
                $tmpCallQueue[$i]['line'] : null;
            $callerFunction = array_key_exists('function', $tmpCallQueue[$i]) ?
                $tmpCallQueue[$i]['function'] : null;
            $callerClass = array_key_exists('class', $tmpCallQueue[$i]) ?
                $tmpCallQueue[$i]['class'] : null;

            // 例外生成(本ｲﾝｽﾀﾝｽのnew)時のｺｰﾙｷｭｰ情報
            $occFile = array_key_exists('file', $occCallQueue[$i]) ?
                $occCallQueue[$i]['file'] : null;
            $occLine = array_key_exists('line', $occCallQueue[$i]) ?
                $occCallQueue[$i]['line'] : null;
            $occFunction = array_key_exists('function', $occCallQueue[$i]) ?
                $occCallQueue[$i]['function'] : null;
            $occClass = array_key_exists('class', $occCallQueue[$i]) ?
                $occCallQueue[$i]['class'] : null;

            // 比較しているｺｰﾙｷｭｰ情報が枝分かれしたか?
            if (!($callerFile === $occFile and $callerLine === $occLine and
                $callerFunction === $occFunction and
                $callerClass === $occClass)) {

                // 最後のｺｰﾙｷｭｰで枝分かれするのはOK(newが同一ｺﾝﾃｷｽﾄに存在)
                if (($i + 1) === count($tmpCallQueue) and
                    ($i + 1) === count($occCallQueue) and
                    $callerFile === $occFile) {

                    return true;
                }

                return false;
            }
        }

        return false;
    }

    /**
     * 現在のｺﾝﾃｷｽﾄに対応したｺｰﾙｷｭｰ情報の要素を取得
     *
     * このﾒｿｯﾄﾞを呼び出したｺﾝﾃｷｽﾄに対応するｺｰﾙｷｭｰ情報の要素を取得する
     *
     * <var>$entry</var>が指定された場合は、要素から該当部分の情報のみを返す
     *
     * @internal
     * @param string $entry 取得したいｴﾝﾄﾘ名(file|line|function|class|type|args)
     * @return mixed|false ｺｰﾙｷｭｰ情報の要素、もしくはその要素中のｴﾝﾄﾘ名の情報、取得失敗時に偽
     */
    protected function getCallQueueElementForCurrentContext($entry = null)
    {
        // ﾒｿｯﾄﾞ呼び出し時のｺｰﾙｷｭｰ情報
        $tmpCallQueue = array_reverse(debug_backtrace());
        array_pop($tmpCallQueue); // 念の為

        // 例外生成(本ｲﾝｽﾀﾝｽのnew)時のｺｰﾙｷｭｰ情報
        $occCallQueue = $this->getCallQueue();

        // 実行開始時からのｺｰﾙｷｭｰを辿る…
        for ($i = 0; $i < count($tmpCallQueue); ++$i) {

            if (!array_key_exists($i, $occCallQueue)) {

                return false;
            }

            // ﾒｿｯﾄﾞ呼び出し時のｺｰﾙｷｭｰ情報
            $callerFile = array_key_exists('file', $tmpCallQueue[$i]) ?
                $tmpCallQueue[$i]['file'] : null;
            $callerLine = array_key_exists('line', $tmpCallQueue[$i]) ?
                $tmpCallQueue[$i]['line'] : null;
            $callerFunction = array_key_exists('function', $tmpCallQueue[$i]) ?
                $tmpCallQueue[$i]['function'] : null;
            $callerClass = array_key_exists('class', $tmpCallQueue[$i]) ?
                $tmpCallQueue[$i]['class'] : null;

            // 例外生成(本ｲﾝｽﾀﾝｽのnew)時のｺｰﾙｷｭｰ情報
            $occFile = array_key_exists('file', $occCallQueue[$i]) ?
                $occCallQueue[$i]['file'] : null;
            $occLine = array_key_exists('line', $occCallQueue[$i]) ?
                $occCallQueue[$i]['line'] : null;
            $occFunction = array_key_exists('function', $occCallQueue[$i]) ?
                $occCallQueue[$i]['function'] : null;
            $occClass = array_key_exists('class', $occCallQueue[$i]) ?
                $occCallQueue[$i]['class'] : null;

            // 比較しているｺｰﾙｷｭｰ情報が枝分かれしたか?
            if (!($callerFile === $occFile and $callerLine === $occLine and
                $callerFunction === $occFunction and
                $callerClass === $occClass)) {

                if (($i + 1) === count($tmpCallQueue)) { // 呼び出し側は末尾

                    if (is_null($entry)) {

                        return $occCallQueue[$i];

                    } elseif (array_key_exists($entry, $occCallQueue[$i])) {

                        return $occCallQueue[$i][$entry];

                    }
                }

                return false;
            }
        }

        return false;
    }

    /**
     * 同一ﾌｧｲﾙでの例外発生行を取得
     *
     * 現在の(このﾒｿｯﾄﾞを呼び出した)ｺﾝﾃｷｽﾄから見て、どの行で発生した例外か調べる
     *
     * @api
     * @return int|bool 例外発生行、もしくは取得失敗時に偽
     */
    public function getLineInCurrentContext()
    {
        return $this->getCallQueueElementForCurrentContext('line');
    }

    /**
     * 同一ﾌｧｲﾙでの例外発生関数名を取得
     *
     * 現在の(このﾒｿｯﾄﾞを呼び出した)ｺﾝﾃｷｽﾄから見て、どの関数、ﾒｿｯﾄﾞ呼び出しで発生した例外か調べる
     *
     * @api
     * @return string|bool 例外発生関数名、もしくは取得失敗時に偽
     */
    public function getFunctionInCurrentContext()
    {
        if ($this->getCallQueueElementForCurrentContext('function') !==
            false) {

            if ($this->getCallQueueElementForCurrentContext('class') !==
                false) {

                return $this->getCallQueueElementForCurrentContext('class').
                    '::'.
                    $this->getCallQueueElementForCurrentContext('function');

            } else {

                return $this->getCallQueueElementForCurrentContext(
                    'function'
                );
            }
        }

        return false;
    }

    /**
     * 同一ﾌｧｲﾙでの例外発生関数の引数を取得
     *
     * 現在の(このﾒｿｯﾄﾞを呼び出した)ｺﾝﾃｷｽﾄから見て、この例外が発生した関数、ﾒｿｯﾄﾞの引数を取得する
     *
     * @api
     * @return array|bool 例外発生関数の引数、もしくは取得失敗時に偽
     */
    public function getFuncArgsInCurrentContext()
    {
        return $this->getCallQueueElementForCurrentContext('args');
    }

    /**
     * 例外の発生源を識別する情報を設定
     *
     * 例外の発生源を識別する情報(ﾊﾞﾘﾃﾞｰｼｮﾝｴﾗｰならばｶﾗﾑ名など)を設定する機能だが、特に必要なければ使用しなくとも良い
     *
     * @api
     * @param string|array $fields,... 例外の発生源(複数なら配列や引数を増やす)を識別する情報
     * @return self 自分自身を返す
     */
    public function setFields(...$fields)
    {
        $this->fields = [];

        foreach ($fields as $field) {

            if (is_array($field)) {

                foreach ($field as $entry) {

                    $this->fields[] = (string)$entry;
                }

            } else {

                $this->fields[] = (string)$field;
            }
        }

        return $this;
    }

    /**
     * 例外の発生源を識別する情報を取得
     *
     * 例外の発生源を識別する情報(ﾊﾞﾘﾃﾞｰｼｮﾝｴﾗｰならばｶﾗﾑ名など)を取得する機能だが、特に必要なければ使用しなくとも良い
     *
     * @api
     * @return array 例外の発生源を識別する情報が格納された配列
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * 例外ﾒｯｾｰｼﾞを設定
     *
     * @api
     * @param string $message 例外ﾒｯｾｰｼﾞ
     * @return self 自分自身を返す
     */
    public function setMessage($message)
    {
        $this->message = (string)$message;

        return $this;
    }

    /**
     * 例外ｺｰﾄﾞを設定
     *
     * int型以外が渡されると既定の例外ｺｰﾄﾞが設定される
     *
     * @api
     * @param int $code 例外ｺｰﾄﾞ
     * @return self 自分自身を返す
     */
    public function setCode($code)
    {
        if (!is_int($code)) {

            $this->code = $this->defCode;

        } else {

            $this->code = $code;
        }

        return $this;
    }

    /**
     * 例外が発生したﾌｧｲﾙを設定
     *
     * @api
     * @param string $file 例外が発生したﾌｧｲﾙ
     * @return self 自分自身を返す
     */
    public function setFile($file)
    {
        $this->file = (string)$file;

        return $this;
    }

    /**
     * 例外が発生した行を設定
     *
     * @api
     * @param int $line 例外が発生した行
     * @return self 自分自身を返す
     */
    public function setLine($line)
    {
        $this->line = (int)$line;

        return $this;
    }

    /**
     * 状態ｺｰﾄﾞを設定
     *
     * 例外ｺｰﾄﾞとは別に補助的に使用できるｺｰﾄﾞとして自由に利用して下さい
     *
     * @api
     * @param mixed $statusCode 状態ｺｰﾄﾞ
     * @return self 自分自身を返す
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * 状態ｺｰﾄﾞを取得
     *
     * 例外ｺｰﾄﾞとは別に補助的に使用できるｺｰﾄﾞとして自由に利用して下さい
     *
     * @api
     * @return mixed 状態ｺｰﾄﾞ
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * AppExceptionに強制変換する前の例外を保存する
     *
     * @internal
     * @param \Exception $exception 強制変換される前の例外
     * @return self 自分自身を返す
     */
    public function setOriginalException(Exception $exception)
    {
        $this->originalException = $exception;

        return $this;
    }

    /**
     * AppExceptionに強制変換される前の例外を取得する
     *
     * @api
     * @return \Exception|null 強制変換される前の例外、未設定ならnull
     */
    public function getOriginalException()
    {
        return $this->originalException;
    }

    /**
     * AppExceptionに強制変換される前の例外ｸﾗｽ名を取得する
     *
     * @api
     * @return string|null 強制変換される前の例外ｸﾗｽ名、未設定ならnull
     */
    public function getOriginalClassName()
    {
        if (is_null($this->getOriginalException())) {

            return null;
        }

        return get_class($this->getOriginalException());
    }

    /**
     * ｲﾃﾚｰﾀとして動作時に\SKJ\AppException\Logic\ContainerExceptionをｽｷｯﾌﾟする
     *
     * @api
     * @return self 自分自身を返す
     */
    public function enableSkipContainer()
    {
        $this->skipContainer = true;

        return $this;
    }

    /**
     * ｲﾃﾚｰﾀとして動作時に\SKJ\AppException\Logic\ContainerExceptionをｽｷｯﾌﾟしない
     *
     * @api
     * @return self 自分自身を返す
     */
    public function disableSkipContainer()
    {
        $this->skipContainer = false;

        return $this;
    }

    /**
     * ｲﾃﾚｰﾀとして扱った時の並び順(発生順)を制御
     *
     * @api
     * @param int $order 並び順
     * @return self 自分自身を返す
     * @uses self::SORT_ORDER_ASC 昇順でｿｰﾄ時に<var>$order</var>に指定
     * @uses self::SORT_ORDER_DESC 降順でｿｰﾄ時に<var>$order</var>に指定
     */
    public function setSortOrder($order = self::SORT_ORDER_DESC)
    {
        switch ($order) {

            case self::SORT_ORDER_ASC:
            case self::SORT_ORDER_DESC:

                $this->iteratorSortOrder = $order;
                break;

            default:

                $this->iteratorSortOrder = self::SORT_ORDER_DESC;
        }

        return $this;
    }

    /**
     * ｲﾃﾚｰﾀとして扱った時に抽出するｸﾗｽ設定を初期化
     *
     * @api
     * @return self 自分自身を返す
     */
    public function resetFilter()
    {
        $this->iteratorTargetArray = null;

        return $this;
    }

    /**
     * ｲﾃﾚｰﾀとして扱った時に抽出するｸﾗｽを設定
     *
     * @api
     * @param string|null $className 抽出対象となるｸﾗｽ名、null時は現ｲﾝｽﾀﾝｽと同一のｸﾗｽのみ対象とする
     * @return self 自分自身を返す
     */
    public function setFilter($className = null)
    {
        $this->iteratorTargetArray = [];

        for ($e = $this; $e !== null; $e = $e->getPrevious()) {

            // \SKJ\AppException\Logic\ContainerExceptionは抽出しない!!
            if ($this->skipContainer and $e instanceof ContainerException) {

                continue;
            }

            if (get_class($e) === $className) {

                $this->iteratorTargetArray[] = $e;

            } elseif (is_null($className) and
                get_class($e) === get_class($this)) {

                $this->iteratorTargetArray[] = $e;
            }
        }

        return $this;
    }

    /**
     * 外部ｲﾃﾚｰﾀを返す
     *
     * @internal
     * @return \Traversable 外部ｲﾃﾚｰﾀ
     */
    public function getIterator()
    {
        if (is_null($this->iteratorTargetArray)) {

            for ($e = $this; $e !== null; $e = $e->getPrevious()) {

                // \SKJ\AppException\Logic\ContainerExceptionは抽出しない!!
                if ($this->skipContainer and
                    $e instanceof ContainerException) {

                    continue;
                }

                $this->iteratorTargetArray[] = $e;
            }
        }

        if ($this->iteratorSortOrder === self::SORT_ORDER_ASC) {

            return new ArrayIterator(
                array_reverse($this->iteratorTargetArray)
            );

        } else {

            return new ArrayIterator($this->iteratorTargetArray);
        }
    }

    /**
     * 連結された例外のﾘｽﾄをﾛｸﾞとして返す
     *
     * ﾛｸﾞﾌｫｰﾏｯﾄは"[ｸﾗｽ名] -> ﾌｧｲﾙ名(発生行) [例外ｺｰﾄﾞ]例外ﾒｯｾｰｼﾞ\n 文字列化されたｽﾀｯｸﾄﾚｰｽ"となる
     *
     * @api
     * @return array ﾛｸﾞﾒｯｾｰｼﾞが格納された配列
     */
    public function getExceptionLog()
    {
        $result = [];

        $this->resetFilter();

        foreach ($this as $e) {

            /** @var \Exception $e */
            $class = get_class($e);
            $file = $e->getFile().'('.$e->getLine().')';
            $message = '['.$e->getCode().']'.$e->getMessage();
            $traces = $e->getTraceAsString();

            $result[] = "[{$class}] -> {$file} {$message}\n{$traces}";
        }

        return $result;
    }

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
    public function renew(array $replacement)
    {
        $callQueue = array_reverse(debug_backtrace());

        foreach ($replacement as $code => $info) {

            if ($this->getCode() === $code) {

                $class = get_class($this);
                $message = $this->getMessage();
                $code = $this->getCode();
                $statusCode = $this->getStatusCode();
                $fields = $this->getFields();

                if (is_array($info)) {

                    // ｺｰﾄﾞ
                    if (array_key_exists(0, $info) and
                        !is_null($info[0]) and is_numeric($info[0])) {

                        $code = (int)$info[0];
                    }

                    // ｸﾗｽ名
                    if (array_key_exists(1, $info) and !is_null($info[1]) and
                        class_exists($info[1]) and (is_subclass_of(
                            $info[1],
                            '\SKJ\AppExceptionInterface'
                        ))) {

                        $class = $info[1];
                    }

                    // ﾒｯｾｰｼﾞ
                    if (array_key_exists(2, $info) and
                        !is_null($info[2]) and is_scalar($info[2])) {

                        $message = (string)$info[2];
                    }

                } elseif (is_int($info)) {

                    $code = $info;

                } elseif ($info instanceof AppExceptionInterface) {

                    return $info->forge($callQueue);

                } else {

                    return $this;
                }

                /**
                 * @var \SKJ\AppExceptionInterface $exception
                 */
                $exception = new $class($message, $code, $this);

                // しつこいが念の為
                if ($exception instanceof AppExceptionInterface) {

                    /** @var \SKJ\AppExceptionInterface $exception */
                    $exception->forge($callQueue);
                    $exception->setFields($fields);
                    if ($statusCode !== $this->defCode) {

                        $exception->setStatusCode($statusCode);
                    }
                    // 例外によっては独自拡張がなされ、これ以外の情報を持っている事もありえるので注意!!
                }

                return $exception;
            }
        }

        // 同一ｺﾝﾃｷｽﾄで発生した例外はそのまま放流
        if ($this->wasCreatedInCurrentContext(debug_backtrace())) {

            return $this;
        }

        /**
         * ﾄﾚｲﾄゆえ、$thisの型が不明なので検査に引っかかる!!
         *
         * @noinspection PhpParamsInspection
         */
        return (new ContainerException(null, null, $this))->forge($callQueue);
    }
}
