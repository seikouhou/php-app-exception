<?php
/**
 * Runtime系例外の定義配列
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
    'WrongArgumentException' => [
        'extends' => '\SKJ\AppException\RuntimeException',
        'since' => '0.8.0',
        'template' => '引数%sに入力された値が間違っています',
        'message' => '引数値が間違っています',
        'summary' => '引数値異常実行例外',
        'description' => '引数値が間違っている場合に使用する例外です',
        'details' => [
            '仕様上ほしい形で引数値が渡されなかった場合に利用する',
            '基本的には関数､ﾒｿｯﾄﾞのｼｸﾞﾈﾁｬ&phpdocのparamだけでは判断できない､引数の仕様外の値に対して利用する',
            '例)日付の文字列が欲しい引数に､時刻の文字列が渡された',
        ],
    ],
    'ValidationException' => [
        'extends' => '\SKJ\AppException\AbstractValidationException',
        'since' => '0.8.0',
        'template' => '%sに入力された値が間違っています[%s]',
        'message' => '入力された値が間違っています',
        'sort_order' => 'self::SORT_ORDER_ASC',
        'summary' => 'ﾊﾞﾘﾃﾞｰｼｮﾝｴﾗｰ実行例外',
        'description' => 'ﾊﾞﾘﾃﾞｰｼｮﾝ処理が失敗した場合に使用する例外です',
        'details' => [
            'ﾊﾞﾘﾃﾞｰｼｮﾝ処理が失敗した場合に利用する',
            '例)ﾕｰｻﾞｰ入力のﾁｪｯｸで､異常なﾃﾞｰﾀを発見した',
        ],
    ],
    'DeadLockException' => [
        'extends' => '\SKJ\AppException\RuntimeException',
        'since' => '0.8.0',
        'template' => 'ﾃﾞｯﾄﾞﾛｯｸが発生しました[%s]',
        'message' => 'ﾃﾞｯﾄﾞﾛｯｸが発生しました',
        'summary' => 'ﾃﾞｯﾄﾞﾛｯｸ実行例外',
        'description' => 'ﾃﾞｯﾄﾞﾛｯｸが発生した場合に使用する例外です',
        'details' => [
            '各種処理中にﾃﾞｯﾄﾞﾛｯｸが発生した場合に利用される',
            '例)MySQLからｸｴﾘがﾃﾞｯﾄﾞﾛｯｸしたとのｴﾗｰが返ってきた',
        ],
    ],
    'DuplicationException' => [
        'extends' => '\SKJ\AppException\RuntimeException',
        'since' => '0.8.0',
        'template' => '%sは重複しています',
        'message' => '重複が発生しました',
        'summary' => '重複実行例外',
        'description' => '重複が発生した場合に使用する例外です',
        'details' => [
            '既に存在する、した行為を再度行った場合に使用する例外です',
            '例)DBなどで重複ｷｰが発生した',
            '例)既にﾀｽｸは実行されている',
            '例)既に購入した権利を再度購入しようとした',
            '例)既に入会している会員だった',
        ],
    ],
    'InvalidElementException' => [
        'extends' => '\SKJ\AppException\RuntimeException',
        'since' => '0.8.0',
        'template' => '無効な%sです',
        'message' => '無効な要素です',
        'summary' => '無効要素の実行例外',
        'description' => '無効な要素が発生した場合に使用する例外です',
        'details' => [
            '無効な要素が発生した場合に利用する',
            '例)無効なﾒｰﾙｱﾄﾞﾚｽだった',
            '例)無効なURLだった',
        ],
    ],
    'MissingElementException' => [
        'extends' => '\SKJ\AppException\RuntimeException',
        'since' => '0.8.0',
        'template' => '%sは見つかりませんでした',
        'message' => '要求した要素は見つかりませんでした',
        'summary' => '要求要素非存在時の実行例外',
        'description' => '要求した要素が存在しなかった場合に使用する例外です',
        'details' => [
            '要求した要素が存在しなかった場合に利用する',
            '例)ﾌｧｲﾙが存在しなかった',
            '例)ﾚｺｰﾄﾞが存在しなかった',
            '例)URLが存在しなかった',
        ],
    ],
    'TimeoutException' => [
        'extends' => '\SKJ\AppException\RuntimeException',
        'since' => '0.8.0',
        'template' => '制限時間(%s)をｵｰﾊﾞｰしました',
        'message' => '制限時間をｵｰﾊﾞｰしました',
        'summary' => '制限時間ｵｰﾊﾞｰの実行例外',
        'description' => '制限時間をｵｰﾊﾞｰした場合に使用する例外です',
        'details' => [
            'ﾘｸｴｽﾄﾀｲﾑｱｳﾄなど制限時間をｵｰﾊﾞｰした場合に利用する',
        ],
    ],
    'EmptyResultException' => [
        'extends' => '\SKJ\AppException\RuntimeException',
        'since' => '0.8.0',
        'template' => '%sから結果を得られませんでした',
        'message' => '結果が得られませんでした',
        'summary' => '空結果実行例外',
        'description' => '結果が得られなかった場合に使用する例外です',
        'details' => [
            '結果が得られなかった場合に利用される',
            '例)SELECT文を発行したが結果が得られなかった',
            '例)APIを呼び出したが､ﾚｽﾎﾟﾝｽﾃﾞｰﾀは0件だった',
        ],
    ],
    'UploadException' => [
        'extends' => '\SKJ\AppException\RuntimeException',
        'since' => '0.8.0',
        'template' => '%sのｱｯﾌﾟﾛｰﾄﾞに失敗しました',
        'message' => 'ｱｯﾌﾟﾛｰﾄﾞに失敗しました',
        'summary' => 'ｱｯﾌﾟﾛｰﾄﾞ実行例外',
        'description' => 'ｱｯﾌﾟﾛｰﾄﾞに失敗した場合に使用する例外です',
        'details' => [
            'ｱｯﾌﾟﾛｰﾄﾞに失敗した場合に利用する',
        ],
    ],
    'NoConditionException' => [
        'extends' => '\SKJ\AppException\RuntimeException',
        'since' => '0.8.0',
        'template' => '%sの条件を満たしていません',
        'message' => '条件を満たしていません',
        'summary' => '条件非適合実行例外',
        'description' => '必要条件が満たされなかった場合に使用する例外です',
        'details' => [
            '必要条件が満たされなかった場合に利用する',
            '例)購入処理を行ったが､必要ﾎﾟｲﾝﾄが無かった',
        ],
    ],
    'PermissionException' => [
        'extends' => '\SKJ\AppException\RuntimeException',
        'since' => '0.8.0',
        'template' => '%sには必要な権限がありません',
        'message' => '権限がありません',
        'summary' => '権限不足時の実行例外',
        'description' => '必要権限が満たされなかった場合に使用する例外です',
        'details' => [
            '必要権限が満たされなかった場合に利用する',
            '例)一般ﾕｰｻﾞｰが管理者のみに許される操作を行おうとした',
            '例)ﾌｧｲﾙﾊﾟｰﾐｯｼｮﾝによりﾌｧｲﾙの削除ができなかった',
        ],
    ],
    'TemporaryFailureException' => [
        'extends' => '\SKJ\AppException\RuntimeException',
        'since' => '0.8.0',
        'template' => '%sは一時的に失敗しました',
        'message' => '一時的に失敗しました',
        'summary' => '一時的な失敗での実行例外',
        'description' => '一時的に処理が失敗した場合に使用する例外です',
        'details' => [
            '一時的に処理が失敗した場合に利用する',
            '一時的というのは再実行時に成功する可能性がある事を意味する',
        ],
    ],
    'TransactionException' => [
        'extends' => '\SKJ\AppException\RuntimeException',
        'since' => '0.8.0',
        'template' => 'ﾄﾗﾝｻﾞｸｼｮﾝの実行に失敗しました[%s]',
        'message' => 'ﾄﾗﾝｻﾞｸｼｮﾝの実行に失敗しました',
        'summary' => 'ﾄﾗﾝｻﾞｸｼｮﾝ処理での実行例外',
        'description' => 'ﾄﾗﾝｻﾞｸｼｮﾝ処理が失敗した場合に使用する例外です',
        'details' => [
            'ﾄﾗﾝｻﾞｸｼｮﾝ処理が失敗した場合に利用する',
        ],
    ],
    'DurationException' => [
        'extends' => '\SKJ\AppException\AbstractDateTimeException',
        'since' => '0.8.0',
        'template' => '%sはまだ期間内です',
        'message' => '期間が満了ではありません',
        'summary' => '期間内ｴﾗｰ実行例外',
        'description' => '期間内である事により処理が失敗した場合に使用する例外です',
        'details' => [
            '期間内である事により処理が失敗した場合に利用する',
            '例)再利用禁止期間が過ぎていないのに､ﾘｿｰｽに対して操作ﾘｸｴｽﾄが発生した',
        ],
    ],
    'ExpiryException' => [
        'extends' => '\SKJ\AppException\AbstractDateTimeException',
        'since' => '0.8.0',
        'template' => '%sは期限切れです',
        'message' => '期限が満了しました',
        'summary' => '期限切れｴﾗｰ実行例外',
        'description' => '期限切れである事により処理が失敗した場合に使用する例外です',
        'details' => [
            '期限切れである事により処理が失敗した場合に利用する',
            '例)購読可能期間が切れているのにﾘｸｴｽﾄが発生した',
        ],
    ],
    'UnavailableServiceException' => [
        'extends' => '\SKJ\AppException\AbstractDateTimeException',
        'since' => '0.8.0',
        'template' => '%sはｻｰﾋﾞｽ停止中です',
        'message' => 'ｻｰﾋﾞｽ停止中です',
        'summary' => 'ｻｰﾋﾞｽ停止例外',
        'description' => '対象のｻｰﾋﾞｽが停止中に投げられる例外です',
        'details' => [
            'ｻｰﾋﾞｽがﾒﾝﾃﾅﾝｽや障害中で使用できない場合に利用する',
            '例)APIがｻｰﾊﾞｰ障害により利用できなかった',
            '例)ASPｻｰﾋﾞｽがﾒﾝﾃﾅﾝｽ中により利用できなかった',
        ],
    ],
    'AuthenticationException' => [
        'extends' => '\SKJ\AppException\RuntimeException',
        'since' => '0.8.0',
        'template' => '%sは認証に失敗しました',
        'message' => '認証に失敗しました',
        'summary' => '認証実行例外',
        'description' => '認証になんらかの問題があった場合に使用する例外です',
        'details' => [
            '認証に失敗した場合に利用する',
            '例)存在しないﾕｰｻﾞｰ',
            '例)ﾊﾟｽﾜｰﾄﾞが間違っている',
        ],
    ],
];
