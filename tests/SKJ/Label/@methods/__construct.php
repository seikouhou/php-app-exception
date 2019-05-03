<?php
/**
 * @noinspection NonAsciiCharacters
 */

// このﾌｧｲﾙの名前空間の定義
namespace SKJ\Test\LabelTest;

// 別名定義
use SKJ\Label;
use VisibilityBreakingWrapper;

trait __construct
{
    /**
     * @test
     * @throws \InvalidArgumentException VisibilityBreakingWrapperのｺﾝｽﾄﾗｸﾀで発生
     */
    public function __constructの行補正値のﾃｽﾄ()
    {
        new VisibilityBreakingWrapper(new Label());
        $this->assertEquals(0, Label::$correctedLine);
        new VisibilityBreakingWrapper(new Label(100));
        $this->assertEquals(100, Label::$correctedLine);
    }
}
