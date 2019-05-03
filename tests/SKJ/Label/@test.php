<?php
/**
 * @noinspection NonAsciiCharacters
 */

// このﾌｧｲﾙの名前空間の定義
namespace SKJ\Test;

// 別名定義
use PHPUnit\Framework\CustomTest\AbstractCustomTestCase;
use SKJ\Label;
use function PHPUnit\Framework\CustomTest\aggregateTraits;

/**
 * ﾌｧｲﾙの取り込み
 *
 * @noinspection PhpIncludeInspection
 */
{
    require_once('CustomTestCase.php');
    require_once('autoload.php');
    require_once('VisibilityBreakingWrapper.php');
}

// 統一ﾄﾚｲﾄの作成
if (($unificationTraitPath = aggregateTraits(__NAMESPACE__)) === false) {

    die('統一トレイトの生成に失敗しました');

} else {

    define(
        sprintf('%s\%s\DATA_DIR', __NAMESPACE__, 'LabelTest'),
        dirname($unificationTraitPath).DIRECTORY_SEPARATOR
    );
}

class LabelTest extends AbstractCustomTestCase
{
    /**
     * ﾃｽﾄﾒｿｯﾄﾞの取り込み
     */
    use LabelTestMethods;
}

/**
 * 言語ﾚﾍﾞﾙのinspection対策(可視性の対策)
 */
interface FakeLabelInterface
{
    /**
     * ﾗﾍﾞﾙ作成処理
     *
     * 指定された名前で定数ﾗﾍﾞﾙを作成する
     *
     * @param string $name ﾗﾍﾞﾙ名称
     * @param int $correctedLine ﾗﾍﾞﾙが指し示す場所への行補正
     * @param array $trace debug_backtrace関数の戻り値
     * @param Label|Object|null $_this ｲﾝｽﾀﾝｽ
     * @throws \InvalidArgumentException 引数異常
     */
    public static function makeLabel(
        $name,
        $correctedLine,
        array $trace,
        Label $_this = null
    );
}
