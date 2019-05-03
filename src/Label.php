<?php
// このﾌｧｲﾙの名前空間の定義
namespace SKJ;

// 別名定義
use InvalidArgumentException;
use LogicException;

/**
 * ﾗﾍﾞﾙ作成
 *
 * ｿｰｽﾌｧｲﾙの行番号ﾍﾞｰｽの定数ﾗﾍﾞﾙを作成します
 *
 * ◆詳細◆
 *
 * 基本的なﾗﾍﾞﾙ作成は下記のような形となる(行頭の数字はｿｰｽﾗﾍﾞﾙ行)
 *
 * <code>
 * 1:$label = new Label(1); // 引数は行補正
 * 2:$label->L01(); // 基本的なﾗﾍﾞﾙ作成方法
 * 3:$label->L02(-1); // 引数は別の行補正値を渡せる
 * 4:Label::L03(); // 静的ｺﾝﾃｷｽﾄでも可能
 * 5:echo $label->L_L01; // 2(実際のｿｰｽ上のﾗﾍﾞﾙ作成行)
 * 6:echo $label->L_L02; // 2(実際のｿｰｽ上のﾗﾍﾞﾙ作成行+ｺﾝｽﾄﾗｸﾀの行補正)
 * 7:echo L_L03; // 3(静的に作成した場合は定数のみで参照可能)
 * </code>
 *
 * 実際の使用方法はphp-app-exceptionと組み合わせて下記のように使用される
 *
 * <code>
 * use SKJ\Label;
 *
 * function selectUser($name)
 * {
 *     if(!($result = readDbByUser($name))){
 *         throw new \SKJ\AppException('user not found!!');
 *     }
 *
 *     return $result;
 * }
 *
 * try {
 *
 *     Label::L001();$result = selectUser('佐藤');
 *     Label::L002(1); // ﾗﾍﾞﾙが指し示したい行が次行なので行補正で1を渡す
 *         $result = selectUser('鈴木');
 *
 *     var_dump($result);
 *
 * } catch (\SKJ\AppException $e) {
 *
 *     // 受け取った例外がこのｽｺｰﾌﾟの何行目で発生したものかで分岐
 *     switch ($e->getLineInCurrentContext()) {
 *         case L_L001:
 *             die('佐藤さんは在籍していません!!');
 *         case L_L002:
 *             die('鈴木さんは在籍していません!!');
 *     }
 * }
 * </code>
 *
 * 例外ｷｬｯﾁ時にｷｬｯﾁと同一ｽｺｰﾌﾟ上のどの行から発生した例外か識別できる
 *
 * これはtry～catch間で同一の関数、ﾒｿｯﾄﾞを複数回呼び出す(例外が同一ｸﾗｽ、同一例外ｺｰﾄﾞで返ってくる)ようなｹｰｽで利用できる
 *
 * ※なお、発生行はｾﾐｺﾛﾝのある行となる
 *
 * <code>
 * 例)
 * 01: Label::L001();$users = selectUsers(
 * 02:     'where deleted=0',
 * 03:     'order by index desc'
 * 04: );
 * </code>
 *
 * このようなｹｰｽでは例外の発生行は4となる
 *
 * @package SKJ\Label
 * @author y3high <y3public@49364.net>
 * @copyright 2019 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release 0.8.0
 */
class Label
{
    /**
     * @api
     * @var int 行補正値
     */
    public static $correctedLine = 0;
    /**
     * @api
     * @var string ﾗﾍﾞﾙ接頭詞
     */
    public static $labelPrefix = 'L';
    /**
     * @internal
     * @var array 内部ﾗﾍﾞﾙ配列
     */
    private $label = [];

    /**
     * ｺﾝｽﾄﾗｸﾀ
     *
     * ｸﾗｽの初期化です
     *
     * @api
     * @param int $correctedLine ﾗﾍﾞﾙが指し示す場所への行補正
     */
    public function __construct($correctedLine = null)
    {
        if (is_numeric($correctedLine)) {

            self::$correctedLine = (int)$correctedLine;
        }
    }

    /**
     * ﾗﾍﾞﾙ作成処理
     *
     * 指定された名前で定数ﾗﾍﾞﾙを作成する
     *
     * @api
     * @param string $name ﾗﾍﾞﾙ名称
     * @param int $correctedLine ﾗﾍﾞﾙが指し示す場所への行補正
     * @param array $trace debug_backtrace関数の戻り値
     * @param Label|null $_this ｲﾝｽﾀﾝｽ
     * @throws \InvalidArgumentException 引数異常
     */
    private static function makeLabel(
        $name,
        $correctedLine,
        array $trace,
        Label $_this = null
    ){
        if (is_string(self::$labelPrefix) and self::$labelPrefix !== '') {

            $labelName = self::$labelPrefix.'_'.$name;

        } else {

            throw new InvalidArgumentException('ラベルが間違っています', 1);
        }

        if (is_numeric($correctedLine)) {

            $correctedLine = (int)$correctedLine;

        } else {

            throw new InvalidArgumentException(
                '行補正値が間違っています', 2
            );
        }

        if (is_array($trace) and isset($trace[0]) and is_array($trace[0]) and
            isset($trace[0]['line']) and is_int($trace[0]['line'])) {

            $line = $trace[0]['line'];

        } else {

            throw new InvalidArgumentException(
                'バックトレース配列が間違っています', 3
            );
        }

        if (!defined($labelName)) {

            define($labelName, $line + $correctedLine);
        }

        if ($_this instanceof Label) {

            $_this->setLabel($labelName, $line + $correctedLine);
        }
    }

    /**
     * ｲﾝｽﾀﾝｽ内部にﾗﾍﾞﾙ作成
     *
     * @api
     * @param string $name ﾗﾍﾞﾙ名称
     * @param int $correctLine ﾗﾍﾞﾙが指し示す場所
     */
    public function setLabel($name, $correctLine)
    {
        $this->label[$name] = (int)$correctLine;
    }

    /**
     * ﾗﾍﾞﾙ参照
     *
     * ﾏｼﾞｯｸﾒｿｯﾄﾞを用い、ﾌﾟﾛﾊﾟﾃｨ読み込み形式でﾗﾍﾞﾙを参照する
     *
     * @internal
     * @param string $name ﾗﾍﾞﾙ名称
     * @return int ﾗﾍﾞﾙ行
     * @throws \LogicException 存在しないﾗﾍﾞﾙを参照した
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->label)) {

            return $this->label[$name];
        }

        throw new  LogicException('存在しないラベルです');
    }

    /**
     * ﾒｿｯﾄﾞ呼び出し形式でﾗﾍﾞﾙ作成
     *
     * ﾏｼﾞｯｸﾒｿｯﾄﾞを用い、ﾒｿｯﾄﾞ呼び出し形式でﾗﾍﾞﾙ作成する
     *
     * @internal
     * @param string $name ﾗﾍﾞﾙ名称
     * @param array $arguments ﾒｿｯﾄﾞ呼び出し事の引数で第一引数に行補正
     * @throws \InvalidArgumentException
     */
    public function __call($name, $arguments)
    {
        $trace = debug_backtrace();

        if (array_key_exists(0, $arguments)) {

            self::makeLabel($name, $arguments[0], $trace, $this);

        } else {

            self::makeLabel($name, self::$correctedLine, $trace, $this);
        }
    }

    /**
     * 静的ﾒｿｯﾄﾞ呼び出し形式でﾗﾍﾞﾙ作成
     *
     * ﾏｼﾞｯｸﾒｿｯﾄﾞを用い、静的ﾒｿｯﾄﾞ呼び出し形式でﾗﾍﾞﾙ作成する
     *
     * @internal
     * @param string $name ﾗﾍﾞﾙ名称
     * @param array $arguments ﾒｿｯﾄﾞ呼び出し事の引数で第一引数に行補正
     * @throws \InvalidArgumentException
     */
    public static function __callStatic($name, $arguments)
    {
        $trace = debug_backtrace();

        if (array_key_exists(0, $arguments)) {

            self::makeLabel($name, $arguments[0], $trace);

        } else {

            self::makeLabel($name, self::$correctedLine, $trace);
        }
    }
}
