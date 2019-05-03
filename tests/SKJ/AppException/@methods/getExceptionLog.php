<?php
/**
 * @noinspection NonAsciiCharacters PhpUnusedLocalVariableInspection
 */

// このﾌｧｲﾙの名前空間の定義
namespace SKJ\Test\AppExceptionTest;

// 別名定義
use SKJ\AppException;
use SKJ\AppException\Logic\ContainerException;
use SKJ\AppException\LogicException;
use SKJ\AppException\RuntimeException;

/** @noinspection PhpUndefinedClassInspection */

trait getExceptionLog
{
    /**
     * @test
     */
    public function getExceptionLogのﾃｽﾄ()
    {
        /**
         * @var AppException $e1
         * @var AppException $e2
         * @var AppException $e3
         * @var AppException $e4
         * @var AppException $e5
         * @var AppException $e6
         * @var AppException $e7
         * @var AppException $e8
         */
        $file = __FILE__;

        list($e1l, $e1, $e2l, $e2, $e3l, $e3, $e4l, $e4) = call_user_func(
            function (){

                $e1l = __LINE__ + 1;
                $e1 = new AppException();
                $e2l = __LINE__ + 1;
                $e2 = new LogicException(null, null, $e1);
                $e3l = __LINE__ + 1;
                $e3 = new LogicException(null, null, $e2);
                $e4l = __LINE__ + 1;
                $e4 = new RuntimeException(null, null, $e3);

                return [$e1l, $e1, $e2l, $e2, $e3l, $e3, $e4l, $e4];
            }
        );

        $e5l = __LINE__ + 1;
        $e5 = new ContainerException(null, null, $e4);

        list($e6l, $e6, $e7l, $e7) = call_user_func(
            function ($e5){

                $e6l = __LINE__ + 1;
                $e6 = new LogicException(null, null, $e5);
                $e7l = __LINE__ + 1;
                $e7 = new RuntimeException(null, null, $e6);

                return [$e6l, $e6, $e7l, $e7];
            },
            $e5
        );

        $e8l = __LINE__ + 1;
        $e8 = new ContainerException(null, null, $e7);
        $el = __LINE__ + 1;
        $e = new AppException(null, null, $e8);

        $regex = "[%s] -> %s(%d) [%d]%s\n%s";
        $this->assertSame(
            $e->getExceptionLog(),
            [
                0 => sprintf(
                    $regex,
                    get_class($e),
                    $file,
                    $e->getline(),
                    $e->getCode(),
                    $e->getMessage(),
                    $e->getTraceAsString()
                ),
                1 => sprintf(
                    $regex,
                    get_class($e7),
                    $file,
                    $e7->getline(),
                    $e7->getCode(),
                    $e7->getMessage(),
                    $e7->getTraceAsString()
                ),
                2 => sprintf(
                    $regex,
                    get_class($e6),
                    $file,
                    $e6->getline(),
                    $e6->getCode(),
                    $e6->getMessage(),
                    $e6->getTraceAsString()
                ),
                3 => sprintf(
                    $regex,
                    get_class($e4),
                    $file,
                    $e4->getline(),
                    $e4->getCode(),
                    $e4->getMessage(),
                    $e4->getTraceAsString()
                ),
                4 => sprintf(
                    $regex,
                    get_class($e3),
                    $file,
                    $e3->getline(),
                    $e3->getCode(),
                    $e3->getMessage(),
                    $e3->getTraceAsString()
                ),
                5 => sprintf(
                    $regex,
                    get_class($e2),
                    $file,
                    $e2->getline(),
                    $e2->getCode(),
                    $e2->getMessage(),
                    $e2->getTraceAsString()
                ),
                6 => sprintf(
                    $regex,
                    get_class($e1),
                    $file,
                    $e1->getline(),
                    $e1->getCode(),
                    $e1->getMessage(),
                    $e1->getTraceAsString()
                ),
            ]
        );
    }
}
