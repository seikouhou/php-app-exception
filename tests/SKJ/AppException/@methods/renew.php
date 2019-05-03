<?php
/**
 * @noinspection NonAsciiCharacters
 */

// このﾌｧｲﾙの名前空間の定義
namespace SKJ\Test\AppExceptionTest;

// 別名定義
use SKJ\AppException;
use SKJ\AppException\RuntimeException;

trait renew
{
    /**
     * @test
     * @throws \InvalidArgumentException VisibilityBreakingWrapperのｺﾝｽﾄﾗｸﾀで発生
     */
    public function renewの流しのﾃｽﾄ()
    {
        // 以前の例外
        $e1 = new AppException('test1', 100);

        // ﾋｯﾄｹｰｽ
        $e2 = (new AppException('test2', 101, $e1))->setFields('test')
            ->setStatusCode(1000);
        $e4 = $e2->renew(
            [
                101 => [201, null, 'test20'],
                103 => 203,
            ]
        );
        $this->assertSame(get_class($e4), get_class($e2));
        $this->assertSame($e4->getMessage(), 'test20');
        $this->assertSame($e4->getCode(), 201);
        $this->assertSame($e4->getPrevious(), $e2);
        $this->assertSame($e4->getFields(), $e2->getFields());
        $this->assertSame($e4->getStatusCode(), $e2->getStatusCode());
        $this->assertTrue($e4->wasCreatedInCurrentContext());

        // 空振りｹｰｽ
        $e3 = (new AppException('test3', 102, $e1))->setFields('test')
            ->setStatusCode(1000);
        $e5 = $e3->renew(
            [
                101 => [201, null, 'test20'],
                103 => 203,
            ]
        );
        $this->assertSame(get_class($e5), get_class($e3));
        $this->assertSame($e5->getMessage(), $e3->getMessage());
        $this->assertSame($e5->getCode(), $e3->getCode());
        $this->assertSame($e5->getPrevious(), $e3->getPrevious());
        $this->assertSame($e5, $e3); // 同じ実体を参照
        $this->assertSame($e5->getFields(), $e3->getFields());
        $this->assertSame($e5->getStatusCode(), $e3->getStatusCode());
        $this->assertTrue($e5->wasCreatedInCurrentContext());

        // ｺｰﾄﾞのみ変更
        $e6 = (new AppException('test4', 103, $e1))->setFields('test')
            ->setStatusCode(1000);
        $e7 = $e6->renew(
            [
                101 => [201, 'test20'],
                103 => 203,
            ]
        );
        $this->assertSame(get_class($e7), get_class($e6));
        $this->assertSame($e7->getMessage(), $e6->getMessage());
        $this->assertSame($e7->getCode(), 203);
        $this->assertSame($e7->getPrevious(), $e6);
        $this->assertSame($e7->getFields(), $e6->getFields());
        $this->assertSame($e7->getStatusCode(), $e6->getStatusCode());
        $this->assertTrue($e7->wasCreatedInCurrentContext());
        $e7 = $e6->renew(
            [
                101 => [201, 'test20'],
                103 => [204],
            ]
        );
        $this->assertSame(get_class($e7), get_class($e6));
        $this->assertSame($e7->getMessage(), $e6->getMessage());
        $this->assertSame($e7->getCode(), 204);
        $this->assertSame($e7->getPrevious(), $e6);
        $this->assertSame($e7->getFields(), $e6->getFields());
        $this->assertSame($e7->getStatusCode(), $e6->getStatusCode());
        $this->assertTrue($e7->wasCreatedInCurrentContext());

        /**
         * ｺﾝﾃﾅに梱包ｹｰｽ
         *
         * @var \SKJ\AppException $e8
         */
        $e8 = call_user_func(
            function (){

                return (new AppException('test8', 108))->setFields('test')
                    ->setStatusCode(1000);
            }
        );
        $e9 = $e8->renew(
            [
                101 => [201, null, 'test20'],
                103 => 203,
            ]
        );
        $this->assertSame(
            get_class($e9),
            'SKJ\AppException\Logic\ContainerException'
        );
        $this->assertSame($e9->getMessage(), $e8->getMessage());
        $this->assertSame($e9->getCode(), $e8->getCode());
        $this->assertSame($e9->getPrevious(), $e8);
        $this->assertSame($e9->getFields(), $e8->getFields());
        $this->assertSame($e9->getStatusCode(), $e8->getStatusCode());
        $this->assertTrue($e9->wasCreatedInCurrentContext());

        // ｸﾗｽの変更(ｸﾗｽ名)
        $e10 = (new AppException('test10', 103, $e1))->setFields('test')
            ->setStatusCode(1000);
        $e11 = $e10->renew(
            [
                101 => [201, 'test20'],
                103 => [null, 'SKJ\AppException\RuntimeException'],
            ]
        );
        $this->assertSame(
            get_class($e11),
            'SKJ\AppException\RuntimeException'
        );
        $this->assertSame($e11->getMessage(), $e10->getMessage());
        $this->assertSame($e11->getCode(), $e10->getCode());
        $this->assertSame($e11->getPrevious(), $e10);
        $this->assertSame($e11->getFields(), $e10->getFields());
        $this->assertNotEquals($e11->getStatusCode(), $e10->getStatusCode());
        $this->assertTrue($e11->wasCreatedInCurrentContext());

        // ｸﾗｽの変更(ｵﾌﾞｼﾞｪｸﾄ)
        $e12 = call_user_func(
            function (){

                return (new RuntimeException('test12', 12))->setFields('test')
                    ->setStatusCode(1000);
            }
        );
        $e13 = $e10->renew(
            [
                101 => [201, 'test20'],
                103 => $e12,
            ]
        );
        $this->assertSame(
            get_class($e13),
            'SKJ\AppException\RuntimeException'
        );
        $this->assertSame($e13->getMessage(), $e12->getMessage());
        $this->assertSame($e13->getCode(), $e12->getCode());
        $this->assertNull($e13->getPrevious());
        $this->assertSame($e13->getFields(), $e12->getFields());
        $this->assertSame($e13->getStatusCode(), $e12->getStatusCode());
        $this->assertTrue($e13->wasCreatedInCurrentContext());
        $this->assertSame($e13, $e12);
    }

    /**
     * @param \SKJ\AppException $orgE
     * @param string $className
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     * @param array $fields
     * @param mixed $statusCode
     * @param bool $WCICC
     * @test
     * @dataProvider dp_renewのﾃｽﾄ
     */
    public function renewのﾃｽﾄ(
        AppException $orgE,
        $className,
        $message,
        $code,
        $previous,
        $fields,
        $statusCode,
        $WCICC
    ){
        $e = call_user_func(
            function (){

                return (new RuntimeException('test', 201))->setFields('test')
                    ->setStatusCode(5000);
            }
        );

        /**
         * @var AppException $newE
         */
        $newE = $orgE->renew(
            [
                100 => 200,
                101 => $e,
                102 => [202],
                103 => [203, '\SKJ\AppException\LogicException'],
                104 => [
                    204,
                    '\SKJ\AppException\HttpException',
                    'http exception!!',
                ],
                105 => [null, '\SKJ\AppException\LogicException'],
                106 => [null, null, 'test exception!!'],
                107 => [],
                108 => [null],
                109 => [null, null],
                110 => [null, null, null],
                111 => 'test string!!', // これは無効
                112 => new FakeObject(), // これは無効
                113 => ['205a'],
                114 => ['dfa', '\SKJ\AppException\HttpException', true],
                115 => [206.7, '\SKJ\AppException\HttpException2', false],
                116 => ['207.23', 'FakeObject', 123.45],
                117 => [208, '\SKJ\AppException\HttpException', [1, 2, 3]],
            ]
        );
        $this->assertSame(get_class($newE), $className);
        $this->assertSame($newE->getMessage(), $message);
        $this->assertSame($newE->getCode(), $code);
        $this->assertSame($newE->getPrevious(), $previous);
        $this->assertSame($newE->getFields(), $fields);
        $this->assertSame($newE->getStatusCode(), $statusCode);
        $this->assertSame($newE->wasCreatedInCurrentContext(), $WCICC);
    }

    public function dp_renewのﾃｽﾄ()
    {
        $previous = new AppException('previous exception!!', 1);

        $this->initializeTypeCheckList(self::clearAllTypes());
        $this->addTypeCheckList(
            [
                $e = new AppException('test100', 100, $previous),
                'SKJ\AppException',
                'test100',
                200,
                $e,
                [],
                1000,
                true,
            ],
            [
                $e = new AppException('test101', 101, $previous),
                'SKJ\AppException\RuntimeException',
                'test',
                201,
                null,
                ['test'],
                5000,
                true,
            ],
            [
                $e = (new AppException(
                    'test102', 102, $previous
                ))->setStatusCode(1024)->setFields('key', 'value'),
                'SKJ\AppException',
                'test102',
                202,
                $e,
                ['key', 'value'],
                1024,
                true,
            ],
            [
                $e = (new AppException(
                    'test103', 103, $previous
                ))->setStatusCode(1024)->setFields(['key', 'value']),
                'SKJ\AppException\LogicException',
                'test103',
                203,
                $e,
                ['key', 'value'],
                1024,
                true,
            ],
            [
                $e = new AppException('test104', 104, $previous),
                'SKJ\AppException\HttpException',
                'http exception!!',
                204,
                $e,
                [],
                500,
                true,
            ],
            [
                $e = new AppException('test105', 105, $previous),
                'SKJ\AppException\LogicException',
                'test105',
                105,
                $e,
                [],
                1200,
                true,
            ],
            [
                $e = new AppException('test106', 106, $previous),
                'SKJ\AppException',
                'test exception!!',
                106,
                $e,
                [],
                1000,
                true,
            ],
            [
                $e = new AppException('test107', 107, $previous),
                'SKJ\AppException',
                'test107',
                107,
                $e,
                [],
                1000,
                true,
            ],
            [
                $e = new AppException('test108', 108, $previous),
                'SKJ\AppException',
                'test108',
                108,
                $e,
                [],
                1000,
                true,
            ],
            [
                $e = new AppException('test109', 109, $previous),
                'SKJ\AppException',
                'test109',
                109,
                $e,
                [],
                1000,
                true,
            ],
            [
                $e = new AppException('test110', 110, $previous),
                'SKJ\AppException',
                'test110',
                110,
                $e,
                [],
                1000,
                true,
            ],
            [
                $e = new AppException('test111', 111, $previous),
                'SKJ\AppException',
                'test111',
                111,
                $previous,
                [],
                1000,
                false,
            ],
            [
                $e = new AppException('test112', 112, $previous),
                'SKJ\AppException',
                'test112',
                112,
                $previous,
                [],
                1000,
                false,
            ],
            [
                $e = new AppException('test113', 113, $previous),
                'SKJ\AppException',
                'test113',
                113,
                $e,
                [],
                1000,
                true,
            ],
            [
                $e = new AppException('test114', 114, $previous),
                'SKJ\AppException\HttpException',
                '1', // true
                114,
                $e,
                [],
                500,
                true,
            ],
            [
                $e = new AppException('test115', 115, $previous),
                'SKJ\AppException',
                '', // false
                206,
                $e,
                [],
                1000,
                true,
            ],
            [
                $e = new AppException('test116', 116, $previous),
                'SKJ\AppException',
                '123.45',
                207,
                $e,
                [],
                1000,
                true,
            ],
            [
                $e = new AppException('test117', 117, $previous),
                'SKJ\AppException\HttpException',
                'test117',
                208,
                $e,
                [],
                500,
                true,
            ],
            [
                $e = (new AppException(
                    'test118', 118, $previous
                ))->setStatusCode(1024)->setFields('key', 'value'),
                'SKJ\AppException\Logic\ContainerException',
                'test118',
                118,
                $e,
                ['key', 'value'],
                1024,
                true,
            ]
        );

        return $this->getTypeCheckList(
            function ($data){
                return $data;
            }
        );
    }
}
