<?php
// このﾌｧｲﾙの名前空間の定義
namespace SKJ\AppException;

/**
 * HTTP層実行例外の抽象ｸﾗｽ
 *
 * HTTP層で必要となる､HTTPﾚｽﾎﾟﾝｽを生成する基となる情報を保持する例外です
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
abstract class AbstractHttpException extends RuntimeException
{
    /**
     * ﾚｽﾎﾟﾝｽﾎﾞﾃﾞｨの形式を表す定数
     *
     * @api
     */
    const RES_BODY_FORMAT_TEXT = 1, RES_BODY_FORMAT_HTML = 2, RES_BODY_FORMAT_JSON = 3;
    /**
     * @internal
     * @var int|null ﾚｽﾎﾟﾝｽﾎﾞﾃﾞｨの形式を表す
     */
    protected $responseBodyFormat = null;
    /**
     * @internal
     * @var array HTTPﾚｽﾎﾟﾝｽﾍｯﾀﾞ配列
     */
    protected $headers = ['Content-Type' => 'text/plain charset=UTF-8'];
    /**
     * @internal
     * @var array HTTPｸｯｷｰ配列
     */
    protected $cookies = [];
    /**
     * @internal
     * @var string|null HTTPﾚｽﾎﾟﾝｽﾎﾞﾃﾞｨ
     */
    protected $body = null;

    /**
     * HTTPﾚｽﾎﾟﾝｽﾍｯﾀﾞを取得する
     *
     * @api
     * @param string $name HTTPﾚｽﾎﾟﾝｽﾍｯﾀﾞ名称
     * @return string HTTPﾚｽﾎﾟﾝｽﾍｯﾀﾞ値
     */
    public function getHeader($name)
    {
        return $this->headers[$name];
    }

    /**
     * 全てのHTTPﾚｽﾎﾟﾝｽﾍｯﾀﾞを取得する
     *
     * 戻り値仕様 - HTTPﾚｽﾎﾟﾝｽﾍｯﾀﾞ配列
     *
     * <code>
     * [
     *     (string)HTTPﾚｽﾎﾟﾝｽﾍｯﾀﾞ名 => (string)HTTPﾚｽﾎﾟﾝｽﾍｯﾀﾞ値,...
     * ]
     * </code>
     *
     * @api
     * @return array HTTPﾚｽﾎﾟﾝｽﾍｯﾀﾞ配列
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * 名前と値を受け取り、HTTPﾚｽﾎﾟﾝｽﾍｯﾀﾞを設定する
     *
     * @api
     * @param string $name HTTPﾚｽﾎﾟﾝｽﾍｯﾀﾞ名称
     * @param string $value HTTPﾚｽﾎﾟﾝｽﾍｯﾀﾞ値
     * @return self 自分自身を返す
     */
    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;

        return $this;
    }

    /**
     * 連想配列を受け取り、HTTPﾚｽﾎﾟﾝｽﾍｯﾀﾞを設定する
     *
     * @api
     * @param array $headers HTTPﾚｽﾎﾟﾝｽﾍｯﾀﾞを表す連想配列
     * @param bool $append 追記ﾓｰﾄﾞ
     * @return self 自分自身を返す
     */
    public function setHeaders(array $headers, $append = false)
    {
        if ($append) {

            $this->headers = $headers + $this->headers;

        } else {

            $this->headers = $headers;
        }

        return $this;
    }

    /**
     * HTTPｸｯｷｰを取得する
     *
     * @api
     * @param string $name HTTPｸｯｷｰ名称
     * @return string HTTPｸｯｷｰ値
     */
    public function getCookie($name)
    {
        return $this->cookies[$name];
    }

    /**
     * 全てのHTTPｸｯｷｰを取得する
     *
     * 戻り値仕様 - HTTPｸｯｷｰ配列
     *
     * <code>
     * [
     *     (string)HTTPｸｯｷｰ名 => (string)HTTPｸｯｷｰ値,...
     * ]
     * </code>
     *
     * @api
     * @return array HTTPｸｯｷｰ配列
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * 名前と値を受け取り、HTTPｸｯｷｰを設定する
     *
     * @api
     * @param string $name HTTPｸｯｷｰ名称
     * @param string $value HTTPｸｯｷｰ値
     * @return self 自分自身を返す
     */
    public function setCookie($name, $value)
    {
        $this->cookies[$name] = $value;

        return $this;
    }

    /**
     * 連想配列を受け取り、HTTPｸｯｷｰを設定する
     *
     * @api
     * @param array $cookies HTTPｸｯｷｰを表す連想配列
     * @param bool $append 追記ﾓｰﾄﾞ
     * @return self 自分自身を返す
     */
    public function setCookies(array $cookies, $append = false)
    {
        if ($append) {

            $this->cookies = $cookies + $this->cookies;

        } else {

            $this->cookies = $cookies;
        }

        return $this;
    }

    /**
     * HTTPﾚｽﾎﾟﾝｽﾎﾞﾃﾞｨの形式を設定する
     *
     * RES_BODY_FORMAT_*以外の定数が渡されたら、何も処理しない
     *
     * @api
     * @param int $format HTTPﾚｽﾎﾟﾝｽﾎﾞﾃﾞｨの形式
     * @return self 自分自身を返す
     * @uses self::RES_BODY_FORMAT_TEXT ﾌﾟﾚｰﾝﾃｷｽﾄ形式
     * @uses self::RES_BODY_FORMAT_HTML HTML形式
     * @uses self::RES_BODY_FORMAT_JSON JSONﾌｫｰﾏｯﾄ形式
     */
    public function setBodyFormat($format)
    {
        switch ($format) {

            case self::RES_BODY_FORMAT_TEXT:

                $this->setHeader('Content-Type', 'text/plain charset=UTF-8');
                $this->responseBodyFormat = $format;
                break;

            case self::RES_BODY_FORMAT_HTML:

                $this->setHeader('Content-Type', 'text/html charset=UTF-8');
                $this->responseBodyFormat = $format;
                break;

            case self::RES_BODY_FORMAT_JSON:

                $this->setHeader(
                    'Content-Type',
                    'application/json charset=UTF-8'
                );
                $this->responseBodyFormat = $format;
                break;
        }

        return $this;
    }

    /**
     * HTTPﾚｽﾎﾟﾝｽﾎﾞﾃﾞｨを設定する
     *
     * 引数の型がｽｶﾗｰ型、配列型、ｵﾌﾞｼﾞｪｸﾄ型以外であれば、何も処理しない
     *
     * @api
     * @param string|array|object $body HTTPﾚｽﾎﾟﾝｽﾎﾞﾃﾞｨ
     * @return self 自分自身を返す
     * @todo 配列のｷｰのｴﾝｺｰﾄﾞを変換
     */
    public function setBody($body)
    {
        if (is_scalar($body)) {

            $this->setBodyFormat(self::RES_BODY_FORMAT_TEXT);
            $this->body = mb_convert_encoding((string)$body, 'utf8', 'auto');

        } elseif (is_array($body) or is_object($body)) {

            $this->setBodyFormat(self::RES_BODY_FORMAT_JSON);
            $this->body = $body;

            // この関数は配列のｷｰは変換しない。格納順に影響するからと思われる
            // ToDO:暇があればｷｰも変換するようにする!!
            mb_convert_variables('utf8', null, $this->body);
        }

        return $this;
    }

    /**
     * HTTPﾚｽﾎﾟﾝｽﾎﾞﾃﾞｨを取得する
     *
     * @api
     * @param bool $decode 真の時はﾃﾞｺｰﾄﾞをする、偽の時はしない
     * @return string HTTPﾚｽﾎﾟﾝｽﾎﾞﾃﾞｨ
     */
    public function getBody($decode = true)
    {
        if (is_null($this->body)) {

            return '';

        } elseif (is_string($this->body)) {

            return $this->body;

        } elseif (!$decode) {

            return $this->body;

        } else {

            switch ($this->responseBodyFormat) {

                case self::RES_BODY_FORMAT_JSON:

                    return $this->getJsonBody();
            }
        }

        return '';
    }

    /**
     * HTTPﾚｽﾎﾟﾝｽﾎﾞﾃﾞｨをJSONｴﾝｺｰﾄﾞして取得する
     *
     * @api
     * @param int $options json_encodeｵﾌﾟｼｮﾝ
     * @param int $depth 最大の深さ
     * @return string JSONﾃﾞｺｰﾄﾞされたHTTPﾚｽﾎﾟﾝｽﾎﾞﾃﾞｨ、失敗時には'json encode failed!!'という文字列
     */
    public function getJsonBody(
        $options = JSON_UNESCAPED_UNICODE,
        $depth = 512
    ){
        $result = json_encode($this->body, $options, $depth);

        if ($result === false) {

            return 'json encode failed!!';
        }

        return $result;
    }
}
