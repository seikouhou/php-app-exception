<?php
/**
 * @noinspection NonAsciiCharacters
 */

// このﾌｧｲﾙの名前空間の定義
namespace SKJ\Test\AppExceptionTest;

// 別名定義
use SKJ\AppException;
use VisibilityBreakingWrapper;

/** @noinspection PhpUndefinedClassInspection */

trait accessorFields
{
    /**
     * @test
     * @throws \InvalidArgumentException VisibilityBreakingWrapperのｺﾝｽﾄﾗｸﾀで発生
     */
    public function setFields＆getFieldsのﾃｽﾄ()
    {
        /**
         * @var AppException|VisibilityBreakingWrapper $testTarget
         */
        $testTarget = new VisibilityBreakingWrapper(new AppException());

        $this->assertSame($testTarget->getFields(), []);

        $this->assertSame(
            $testTarget->getTestTargetObject(),
            $testTarget->setFields('benyy')
        );

        $testTarget->setFields(['benyy', 'y3']);
        $this->assertSame($testTarget->getFields(), ['benyy', 'y3']);
        $testTarget->setFields(
            1,
            ['benyy', 'y3'],
            ['takashi', 'yasutake'],
            'sawamura'
        );
        $this->assertSame(
            $testTarget->getFields(),
            ['1', 'benyy', 'y3', 'takashi', 'yasutake', 'sawamura']
        );
    }
}
