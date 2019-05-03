<?php
/**
 * @noinspection NonAsciiCharacters
 */

// このﾌｧｲﾙの名前空間の定義
namespace SKJ\Test\AbstractContainerExceptionTest;

// 別名定義
use SKJ\AppException;
use SKJ\Test\ContainerExceptionTest;

trait initialize
{
    /**
     * @test
     * @throws \InvalidArgumentException VisibilityBreakのｺﾝｽﾄﾗｸﾀで発生
     */
    public function initializeのﾃｽﾄ()
    {
        //
        $line = __LINE__ + 1;
        $e = new ContainerExceptionTest();
        $this->assertSame('例外が発生しました', $e->getMessage());
        $this->assertSame(999, $e->getCode());
        $this->assertNull($e->getPrevious());
        $this->assertSame(9999, $e->getStatusCode());
        $this->assertSame([], $e->getFields());
        $this->assertSame(__FILE__, $e->getFile());
        $this->assertSame($line, $e->getLine());
        $this->assertTrue($e->wasCreatedInCurrentContext());

        //
        $line = __LINE__ + 1;
        $e = new ContainerExceptionTest(
            'test', 111, call_user_func(
                function (){
                    return (new AppException('kid', 222))->setStatusCode(
                        'apple'
                    )->setFields(['a', 'b']);
                }
            )
        );
        $this->assertSame('kid', $e->getMessage());
        $this->assertSame(222, $e->getCode());
        $this->assertNotNull($e->getPrevious());
        $this->assertSame('apple', $e->getStatusCode());
        $this->assertSame(['a', 'b'], $e->getFields());
        $this->assertSame(__FILE__, $e->getFile());
        $this->assertSame($line, $e->getLine());
        $this->assertTrue($e->wasCreatedInCurrentContext());

        // 同一ｸﾗｽではニ度梱包しないTEST
        try {

            $line = __LINE__ + 4;
            throw (new ContainerExceptionTest(
                'test1', 1, call_user_func(
                    function (){
                        return (new ContainerExceptionTest(
                            'test2', 2
                        ))->setStatusCode(
                            'apple2'
                        )->setFields(['a2', 'b2']);
                    }
                )
            ))->setStatusCode(
                'apple1'
            )->setFields(['a1', 'b1']);

        } catch (AppException $e) {

            $this->assertSame(
                'SKJ\Test\ContainerExceptionTest',
                get_class($e)
            );
            $this->assertSame('test2', $e->getMessage());
            $this->assertSame(2, $e->getCode());
            $this->assertNull($e->getPrevious());
            $this->assertSame('apple2', $e->getStatusCode());
            $this->assertSame(['a2', 'b2'], $e->getFields());
            $this->assertSame(__FILE__, $e->getFile());
            $this->assertSame($line, $e->getLine());
            $this->assertFalse($e->wasCreatedInCurrentContext());
        }

        // 同一ｺﾝﾃｷｽﾄTEST
        try {

            $line = __LINE__ + 4;
            throw (new ContainerExceptionTest(
                'test1',
                1,
                (new AppException('test2', 2))->setStatusCode('apple2')
                    ->setFields(['a2', 'b2'])
            ))->setStatusCode('apple1')->setFields(['a1', 'b1']);

        } catch (AppException $e) {

            $this->assertSame('SKJ\AppException', get_class($e));
            $this->assertSame('test2', $e->getMessage());
            $this->assertSame(2, $e->getCode());
            $this->assertNull($e->getPrevious());
            $this->assertSame('apple2', $e->getStatusCode());
            $this->assertSame(['a2', 'b2'], $e->getFields());
            $this->assertSame(__FILE__, $e->getFile());
            $this->assertSame($line, $e->getLine());
            $this->assertTrue($e->wasCreatedInCurrentContext());
        }
    }
}
