<?php
/**
 * @noinspection NonAsciiCharacters
 */

// このﾌｧｲﾙの名前空間の定義
namespace SKJ\Test\LabelTest;

// 別名定義
use SKJ\Label;
use SKJ\Test\FakeLabelInterface;
use VisibilityBreakingWrapper;

trait makeLabel
{
    /**
     * @test
     * @throws \InvalidArgumentException VisibilityBreakingWrapperのｺﾝｽﾄﾗｸﾀで発生
     */
    public function makeLabelの正常系ﾃｽﾄ()
    {
        /**
         * @var Label|FakeLabelInterface|VisibilityBreakingWrapper $label
         */
        $label = new VisibilityBreakingWrapper(new Label());
        $trace[0]['line'] = 100;

        $label->makeLabel(
            'testLabel1',
            0,
            $trace,
            $label->getTestTargetObject()
        );

        /** @noinspection PhpUndefinedConstantInspection */
        $this->assertEquals(L_testLabel1, 100);
        /** @noinspection PhpUndefinedFieldInspection */
        $this->assertEquals($label->L_testLabel1, 100);

        $label->makeLabel(
            'testLabel2',
            10,
            $trace,
            $label->getTestTargetObject()
        );

        /** @noinspection PhpUndefinedConstantInspection */
        $this->assertEquals(L_testLabel2, 110);
        /** @noinspection PhpUndefinedFieldInspection */
        $this->assertEquals($label->L_testLabel2, 110);

        Label::$labelPrefix = 'XXX';

        $label->makeLabel(
            'testLabel3',
            -10,
            $trace,
            $label->getTestTargetObject()
        );

        /** @noinspection PhpUndefinedConstantInspection */
        $this->assertEquals(XXX_testLabel3, 90);
        /** @noinspection PhpUndefinedFieldInspection */
        $this->assertEquals($label->XXX_testLabel3, 90);
    }

    /**
     * test
     * @expectedException \InvalidArgumentException
     * @throws \InvalidArgumentException VisibilityBreakingWrapperのｺﾝｽﾄﾗｸﾀで発生
     */
    public function makeLabelの例外系TEST()
    {
        /**
         * @var Label|FakeLabelInterface|VisibilityBreakingWrapper $label
         */
        $label = new VisibilityBreakingWrapper(new Label());
        $trace[0]['line'] = 100;
        $label->makeLabel(
            'testLabel1',
            0,
            $trace,
            $label->getTestTargetObject()
        );
    }
}
