<?php
// このﾌｧｲﾙの名前空間の定義
namespace SKJ\AppException;

/**
 * 日時ｴﾗｰ実行例外の抽象ｸﾗｽ
 *
 * 日時に関する事により処理が失敗した場合に使用する例外です
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
class AbstractDateTimeException extends RuntimeException
{
    /**
     * @internal
     * @var int|null ﾀｲﾑｽﾀﾝﾌﾟ(unixﾀｲﾑ)
     */
    protected $dateTime = null;

    /**
     * 日時を設定する
     *
     * 日時解釈できない文字列が渡された場合は設定されない
     *
     * @api
     * @param string $dateTime strtotime()関数が解釈できる日時形式で期限を指定
     * @return self 自分自身を返す
     */
    public function setDateTime($dateTime)
    {
        if (($unixTime = strtotime($dateTime)) !== false) {

            $this->dateTime = $unixTime;
        }

        return $this;
    }

    /**
     * 日時を取得する
     *
     * 日時が未設定の場合は2038-01-09 03:14:07のunixﾀｲﾑを返す
     *
     * @api
     * @param string|null $format date()関数に準ずる日付ﾌｫｰﾏｯﾄ、未指定時はunixﾀｲﾑで返す
     * @return int|string|false 引数の日付ﾌｫｰﾏｯﾄに従った形式の期限、もしくはunixﾀｲﾑ、日付ﾌｫｰﾏｯﾄが間違っている場合は偽を返す
     */
    public function getDateTime($format = null)
    {
        if (is_null($this->dateTime)) {

            return mktime(3, 14, 7, 1, 9, 2038); // time_t型の最大値
        }

        if (is_null($format)) {

            return $this->dateTime;

        } else {

            return @date($format, $this->dateTime);
        }
    }
}
