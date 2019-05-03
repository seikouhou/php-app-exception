<?php
/**
 * Logic系例外の定義配列
 *
 * <code>
 * [
 *     [
 *         'since' => (string)どのﾊﾞｰｼﾞｮﾝから追加されたかを指定,
 *         'extends' => (string)継承する例外,
 *         'template' => (sting)sprintf関数のformat形式で例外ﾒｯｾｰｼﾞ(ﾊﾟﾗﾒｰﾀは例外の生成時に第1引数に配列で渡す),
 *         'message' => (string)例外ﾒｯｾｰｼﾞ,
 *         'summary' => (string)ｸﾗｽのphpdocに書かれる概要,
 *         'description' => (string)ｸﾗｽのphpdocに書かれる説明見出し,
 *         'details' => [
 *             (string)ｸﾗｽのphpdocに説明部分に箇条書きで書かれる詳細,...(項目の数だけ繰り返し)
 *         ]
 *     ],...(必要な例外の数だけ繰り返し)
 * ];
 * <\code>
 */

return [
    'EnvironmentException' => [
        'extends' => '\SKJ\AppException\LogicException',
        'since' => '0.8.0',
        'template' => '環境要因によって失敗しました[%s]',
        'message' => '環境要因によって失敗しました',
        'summary' => '環境要因でのﾛｼﾞｯｸ例外',
        'description' => '環境要因での障害発生時に使用する例外です',
        'details' => [
            'ｼｽﾃﾑの環境要因の不備などが原因となって起きた障害に利用される',
        ],
    ],
    'DependencyInjectionException' => [
        'extends' => '\SKJ\AppException\Logic\EnvironmentException',
        'since' => '0.8.0',
        'template' => '%sｵﾌﾞｼﾞｪｸﾄが注入されていません',
        'message' => '必要とされる依存性が解決していません',
        'summary' => '依存性の注入ﾛｼﾞｯｸ例外',
        'description' => '依存性が満たされていない場合に使用する例外です',
        'details' => [
            '外部から必要な依存性が注入されていない場合に利用される',
            'その他､依存性の注入に関連するｴﾗｰでも利用できる',
        ],
    ],
    'CircularReferenceException' => [
        'extends' => '\SKJ\AppException\LogicException',
        'since' => '0.8.0',
        'template' => '%sの参照が循環しています',
        'message' => '参照が循環しています',
        'summary' => '循環参照実行例外',
        'description' => '参照が循環した場合に使用する例外です',
        'details' => [
            '参照が循環した場合に利用する',
            '無限ﾙｰﾌﾟにならないように､検知し次第この例外を投げる',
        ],
    ],
    'UnexpectedValueException' => [
        'extends' => '\SKJ\AppException\LogicException',
        'since' => '0.8.0',
        'template' => '%sで想定外の値を受け取りました',
        'message' => '想定外の値を受け取りました',
        'summary' => '想定外値実行例外',
        'description' => '外部から規定外の型や値が返ってきた事で発生する例外です',
        'details' => [
            '仕様や規格上で明示された以外の値が返ってきたような場合が対象です',
            '例)関数やﾒｿｯﾄﾞの戻り値で規定外の型や値が返ってきた',
            '例)APIなどをｺｰﾙして規定外の型や値が返ってきた',
        ],
    ],
];

