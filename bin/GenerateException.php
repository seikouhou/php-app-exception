<?php
$baseDir =
    dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR;
$expBaseDir = $baseDir.'exceptions';
$configDir = dirname(__FILE__).DIRECTORY_SEPARATOR;

if (($exceptionData = require_once($configDir.'config.php')) === false) {

    die('例外設定が読み込めません'.PHP_EOL);
}

$tempExp = <<< EOD
<?php
// このﾌｧｲﾙの名前空間の定義
namespace #namespace#;
#alias#
/**
 * #summary#
 *
#description# *
 * ◆詳細◆
 * <ul>
#details# * </ul>
 *
 * @package #namespace#
 * @author y3high <y3public@49364.net>
 * @copyright 2019 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release #since#
 */
class #classname# extends #extends#
{
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>\$message</var>が渡されなかった場合の既定の例外ﾒｯｾｰｼﾞ
     */
    protected \$defMessage = '#message#';
    /**
     * @api
     * @var string ｺﾝｽﾄﾗｸﾀの引数<var>\$message</var>が配列で渡された場合にvsprintfに渡すﾌｫｰﾏｯﾄ文字列
     */
    protected \$messageTemplate = '#template#';
    /**
     * @api
     * @var int ｺﾝｽﾄﾗｸﾀの引数<var>\$code</var>が渡されなかった場合の既定の例外ｺｰﾄﾞ
     */
    protected \$defCode = #code#;
    /**
     * @api
     * @var mixed 補助的に使用される状態ｺｰﾄﾞ(ﾃﾞﾌｫﾙﾄはself::<var>\$defCode</var>と同じ)
     */
    protected \$statusCode = #code#;
}

EOD;

$default = [
    'version' => '0.8.0',
    'since' => '0.8.0',
    'package' => '',
    'namespace' => 'SKJ\AppException',
    'extends' => '\SKJ\AppException',
    'template' => '',
    'message' => '',
    'code' => null,
    'sort_order' => 'self::SORT_ORDER_DESC',
    'summary' => 'ｱﾌﾟﾘｹｰｼｮﾝﾚﾍﾞﾙでの実行例外',
    'description' => ['ｱﾌﾟﾘｹｰｼｮﾝﾚﾍﾞﾙで発生した実行例外です'],
    'details' => [
        '正常利用でも場合によっては発生するｴﾗｰに適用',
        'ｺｰﾄﾞを実行して始めて結果が分かるような場合(外部入力を起因とした処理で発生するｴﾗｰなど)に適用される例外',
        '例) 外部から来たｷｰでDBにｱｸｾｽしたら望む情報が得られなかった',
        '例) 何らかの理由でDBの接続に失敗した',
    ],
];

$exceptionCode = 1300;
$uniqueNum = 200;

foreach ($exceptionData as $exceptionList) {

    foreach ($exceptionList as $classname => $value) {

        foreach ($default as $index => $defValue) {

            if (!array_key_exists($index, $value) || empty($value[$index])) {

                $value[$index] = $defValue;
            }
        }

        $version = $value['version'];
        $since = $value['since'];
        $package = $value['package'];
        $namespace = $value['namespace'];
        $extends = $value['extends'];
        $template = $value['template'];
        $message = $value['message'];
        $code = $value['code'];
        $sortOrder = $value['sort_order'];
        $summary = $value['summary'];
        $description = $value['description'];
        $details = $value['details'];

        if (is_null($code)) {
            $code = $exceptionCode++;
        }

        if (!is_array($description)) {
            $description = explode("\n", $description);
        }

        foreach ($description as &$explain) {
            $explain = " * ".$explain."\n";
        }

        if (!is_array($details)) {
            $details = explode("\n", $details);
        }

        foreach ($details as &$detail) {
            $detail = " *     <li>".$detail."</li>\n";
        }

        $buffer = $tempExp;

        $namespace = ltrim($namespace, " \t\n\r\0\x0B\\");
        $extends = ltrim($extends, " \t\n\r\0\x0B\\");

        $extendsNameSpace =
            implode('\\', array_filter(explode('\\', $extends, -1), 'strlen'));
        $extendsClassName = array_pop(explode('\\', $extends));

        if ($namespace == $extendsNameSpace) {

            $alias = '';

        } else {

            $alias = <<< EOD

// 別名定義
use {$extends};

EOD;
        }

        $buffer = str_replace(
            [
                '#uniquestring#',
                '#uniquenum#',
                '#classname#',
                '#namespace#',
                '#version#',
                '#since#',
                '#alias#',
                '#extends#',
                '#template#',
                '#message#',
                '#code#',
                '#sort_order#',
                '#summary#',
                '#description#',
                '#details#',
            ],
            [
                strtoupper(strtr($namespace, '\\', '_').'_'.$classname),
                $uniqueNum++,
                $classname,
                $namespace,
                $version,
                $since,
                $alias,
                $extendsClassName,
                mb_convert_kana($template, 'asKV'),
                mb_convert_kana($message, 'asKV'),
                $code,
                $sortOrder,
                mb_convert_kana($summary, 'ask'),
                mb_convert_kana(implode('', $description), 'ask'),
                mb_convert_kana(implode('', $details), 'ask'),
            ],
            $buffer
        );

        if (!empty($package)) {
            $package = DIRECTORY_SEPARATOR."{$package}";

            if (!is_dir($expBaseDir.$package)) {
                if (!mkdir($expBaseDir.$package)) {
                    die('ディレクトリの作成に失敗した'.PHP_EOL);
                }
            }
        }

        if (file_put_contents(
                $expBaseDir.$package.DIRECTORY_SEPARATOR.$classname.'.php',
                $buffer
            ) === false) {
            die('書き込みに失敗した'.PHP_EOL);
        }
    }
}

echo 'Generation of exceptions were successful.'.PHP_EOL;

exit();
