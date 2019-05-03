<?php
$splLogicExceptions = [
    'BadFunctionCallException' => [
        'package' => 'Logic',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\Logic',
        'extends' => '\SKJ\AppException\LogicException',
        'template' => '%sで異常な関数呼び出しが発生しました',
        'message' => '異常な関数呼び出しが発生しました',
        'summary' => '異常な関数呼び出しﾛｼﾞｯｸ例外',
        'description' => '未定義の関数をｺｰﾙﾊﾞｯｸが参照したり､引数を指定しなかったりした場合にｽﾛｰされる例外です',
        'details' => [
            'この例外が発生した場合はｺｰﾄﾞの修正が必要です',
            '例)未定義の関数をｺｰﾙﾊﾞｯｸが参照した',
            '例)引数を指定しなかった',
        ],
    ],
    'BadMethodCallException' => [
        'package' => 'Logic',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\Logic',
        'extends' => '\SKJ\AppException\Logic\BadFunctionCallException',
        'template' => '%sで異常なﾒｿｯﾄﾞ呼び出しが発生しました',
        'message' => '異常なﾒｿｯﾄﾞ呼び出しが発生しました',
        'summary' => '異常なﾒｿｯﾄﾞ呼び出しﾛｼﾞｯｸ例外',
        'description' => '未定義のﾒｿｯﾄﾞをｺｰﾙﾊﾞｯｸが参照したり､引数を指定しなかったりした場合にｽﾛｰされる例外です',
        'details' => [
            'この例外が発生した場合はｺｰﾄﾞの修正が必要です',
            '例)未定義のﾒｿｯﾄﾞをｺｰﾙﾊﾞｯｸが参照した',
            '例)引数を指定しなかった',
        ],
    ],
    'DomainException' => [
        'package' => 'Logic',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\Logic',
        'extends' => '\SKJ\AppException\LogicException',
        'template' => '%sでﾃﾞｰﾀﾄﾞﾒｲﾝ外の値が発生しました',
        'message' => 'ﾃﾞｰﾀﾄﾞﾒｲﾝ外の値が発生しました',
        'summary' => 'ﾃﾞｰﾀﾄﾞﾒｲﾝ外値ﾛｼﾞｯｸ例外',
        'description' => '定義されたﾃﾞｰﾀﾄﾞﾒｲﾝに値が従わないときにｽﾛｰされる例外です',
        'details' => [
            'この例外が発生した場合はｺｰﾄﾞの修正が必要です',
            '基本的には事前に用意されているﾃﾞｰﾀﾘｽﾄに、あるはずの値が存在しない場合などに利用されます',
            '例)存在しない定数が参照された',
        ],
    ],
    'InvalidArgumentException' => [
        'package' => 'Logic',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\Logic',
        'extends' => '\SKJ\AppException\LogicException',
        'template' => '%sで無効な引数を受け取りました',
        'summary' => '引数異常ﾛｼﾞｯｸ例外',
        'description' => '無効な引数を受け取った場合にｽﾛｰされる例外です',
        'details' => [
            'この例外が発生した場合はｺｰﾄﾞの修正が必要です',
            '基本的にはｼｸﾞﾈﾁｬ&phpdocのparamから読み取れる情報が満たされていない場合や､ｺｰﾄﾞ修正が発生するようなｹｰｽに利用されます',
            '例)ｼｸﾞﾈﾁｬに反する型の引数を受け取った',
            '例)必要な数の引数が渡されなかった',
        ],
    ],
    'LengthException' => [
        'package' => 'Logic',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\Logic',
        'extends' => '\SKJ\AppException\LogicException',
        'template' => '%sでﾃﾞｰﾀ長例外が発生しました',
        'message' => '無効なﾃﾞｰﾀ長です',
        'summary' => '無効ﾃﾞｰﾀ長ﾛｼﾞｯｸ例外',
        'description' => '長さが無効な場合にｽﾛｰされる例外です',
        'details' => [
            'この例外が発生した場合はｺｰﾄﾞの修正が必要です',
            '例)引数で受け取った文字列長が長すぎる',
            '例)引数で受け取った文字列長が短すぎる',
        ],
    ],
    'OutOfRangeException' => [
        'package' => 'Logic',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\Logic',
        'extends' => '\SKJ\AppException\LogicException',
        'template' => '%sで静的範囲ｴﾗｰ例外が発生しました',
        'message' => '静的範囲ｴﾗｰ例外が発生しました',
        'summary' => '静的範囲ｴﾗｰﾛｼﾞｯｸ例外',
        'description' => '静的範囲ｴﾗｰが発生した事で発生する例外です',
        'details' => [
            'この例外が発生した場合はｺｰﾄﾞの修正が必要です',
            '値が有効なｷｰでなかった場合にｽﾛｰされる例外です',
            '例)固定的なｲﾝﾃﾞｯｸｽに対して範囲外のｷｰが発生した',
        ],
    ],
];

$splRuntimeExceptions = [
    'OutOfBoundsException' => [
        'package' => 'Runtime',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\Runtime',
        'extends' => '\SKJ\AppException\RuntimeException',
        'template' => '%sで範囲外のｷｰを受け取りました',
        'message' => '範囲外のｷｰを受け取りました',
        'summary' => '範囲外ｷｰ実行例外',
        'description' => '値が有効なｷｰでなかった場合に発生する例外です',
        'details' => [
            '実行時にしか確認できないものが対象です',
            '値が有効なｷｰでなかった場合にｽﾛｰされる例外です',
            '例)実行時に決定されるようなｲﾝﾃﾞｯｸｽの範囲外のｷｰが発生した',
        ],
    ],
    'OverflowException' => [
        'package' => 'Runtime',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\Runtime',
        'extends' => '\SKJ\AppException\RuntimeException',
        'template' => '%sでｵｰﾊﾞｰﾌﾛｰ例外が発生しました',
        'message' => 'ｵｰﾊﾞｰﾌﾛｰが発生しました',
        'summary' => 'ｵｰﾊﾞｰﾌﾛｰ実行例外',
        'description' => '上限となるｺﾝﾃﾅへのﾃﾞｰﾀ追加で発生する例外です',
        'details' => [
            '実行時にしか確認できないものが対象です',
            'いっぱいになっているｺﾝﾃﾅに要素を追加した場合にｽﾛｰされる例外です',
            '数値の桁あふれが発生する状況でも使用します',
        ],
    ],
    'RangeException' => [
        'package' => 'Runtime',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\Runtime',
        'extends' => '\SKJ\AppException\RuntimeException',
        'template' => '%sで範囲ｴﾗｰ例外が発生しました',
        'message' => '動的範囲ｴﾗｰが発生しました',
        'summary' => '動的範囲ｴﾗｰ実行例外',
        'description' => '動的範囲ｴﾗｰが発生した事で発生する例外です',
        'details' => [
            '実行時にしか確認できないものが対象です',
            'ｱﾝﾀﾞｰﾌﾛｰやｵｰﾊﾞｰﾌﾛｰ以外の計算ｴﾗｰで使用します',
        ],
    ],
    'UnderflowException' => [
        'package' => 'Runtime',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\Runtime',
        'extends' => '\SKJ\AppException\RuntimeException',
        'template' => '%sでｱﾝﾀﾞｰﾌﾛｰが発生しました',
        'message' => 'ｱﾝﾀﾞｰﾌﾛｰが発生しました',
        'summary' => 'ｱﾝﾀﾞｰﾌﾛｰ実行例外',
        'description' => '空のｺﾝﾃﾅに対する削除操作等で発生する例外です',
        'details' => [
            '実行時にしか確認できないものが対象です',
            '空のｺﾝﾃﾅ上で無効な操作 (要素の削除など) を試みたときにｽﾛｰされる例外です',
            '数値の小数点以下の有効桁数ｵｰﾊﾞｰでも使用します',
        ],
    ],
    'UnexpectedValueException' => [
        'package' => 'Runtime',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\Runtime',
        'extends' => '\SKJ\AppException\RuntimeException',
        'template' => '%sで想定外の値を受け取りました',
        'message' => '想定外の値を受け取りました',
        'summary' => '想定外値実行例外',
        'description' => '外部から想定する値が戻ってこなかった事で発生する例外です',
        'details' => [
            '実行時にしか確認できないものが対象です',
            '※基本的にはLogic系の意味合いが強いので、Logicにある同名の例外を使用して下さい',
            '例)関数やﾒｿｯﾄﾞの戻り値で想定した型や値でなかった',
            '例)APIなどをｺｰﾙして想定した値が戻ってこなかった',
        ],
    ],
];

$httpExceptions = [
    'BadRequestException' => [
        'package' => 'HTTP',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\HTTP',
        'extends' => '\SKJ\AppException\HttpException',
        'template' => 'Bad Request',
        'message' => 'Bad Request',
        'summary' => 'Bad Request HTTP層実行例外',
        'code' => 400,
        'description' => 'ﾘｸｴｽﾄの構文を間違えている事を示す例外です',
        'details' => [
            '異常なﾊﾟﾗﾒｰﾀが指定されたなど､ﾘｸｴｽﾄの構文を間違えている場合に利用される',
            '他の4xx系ｴﾗｰｺｰﾄﾞに適さないようなｹｰｽでも利用される',
            'ｸﾗｲｱﾝﾄは未知の4xxｴﾗｰｺｰﾄﾞを受け取った時に､400と同じ扱いをする',
        ],
    ],
    'UnauthorizedException' => [
        'package' => 'HTTP',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\HTTP',
        'extends' => '\SKJ\AppException\HttpException',
        'template' => 'Unauthorized',
        'message' => 'Unauthorized',
        'summary' => 'Unauthorized HTTP層実行例外',
        'code' => 401,
        'description' => '認証情報を間違えている事を示す例外です',
        'details' => [
            '認証情報が渡されなかったり､間違っていた場合に利用される',
            'ﾚｽﾎﾟﾝｽにはWWW-Authenticateﾍｯﾀﾞが含まれ､そこで認証方式を指定する',
        ],
    ],
    'PaymentRequiredException' => [
        'package' => 'HTTP',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\HTTP',
        'extends' => '\SKJ\AppException\HttpException',
        'template' => 'Payment Required',
        'message' => 'Payment Required',
        'summary' => 'Payment Required HTTP層実行例外',
        'code' => 402,
        'description' => '料金が必要である事を示す例外です',
        'details' => [
            'これは実際には利用されていない例外です',
        ],
    ],
    'ForbiddenException' => [
        'package' => 'HTTP',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\HTTP',
        'extends' => '\SKJ\AppException\HttpException',
        'template' => 'Forbidden',
        'message' => 'Forbidden',
        'summary' => 'Forbidden HTTP層実行例外',
        'code' => 403,
        'description' => 'ﾘｿｰｽの操作禁止を示す例外です',
        'details' => [
            '認証以外の理由でﾘｿｰｽに対する操作ができない場合に利用される',
            '例)許可されていないIPｱﾄﾞﾚｽでｱｸｾｽされた',
            '例)古いﾊﾞｰｼﾞｮﾝのｸﾗｲｱﾝﾄでｱｸｾｽされた',
        ],
    ],
    'NotFoundException' => [
        'package' => 'HTTP',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\HTTP',
        'extends' => '\SKJ\AppException\HttpException',
        'template' => 'Not Found',
        'message' => 'Not Found',
        'summary' => 'Not Found HTTP層実行例外',
        'code' => 404,
        'description' => '指定されたﾘｿｰｽが存在しない事を示す例外です',
        'details' => [
            'ﾘｿｰｽが存在しない場合に利用されるが､ｾｷｭﾘﾃｨ的に詳細な理由を示したくない場合にも利用される',
        ],
    ],
    'MethodNotAllowedException' => [
        'package' => 'HTTP',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\HTTP',
        'extends' => '\SKJ\AppException\HttpException',
        'template' => 'Method Not Allowed',
        'message' => 'Method Not Allowed',
        'summary' => 'Method Not Allowed HTTP層実行例外',
        'code' => 405,
        'description' => '指定したﾒｿｯﾄﾞがｻﾎﾟｰﾄされていない事を示す例外です',
        'details' => [
            'あるURIが指定したﾒｿｯﾄﾞをｻﾎﾟｰﾄしていない場合に利用される',
            'ﾚｽﾎﾟﾝｽにはAllowﾍｯﾀﾞが含まれ､そこでこのURIがｻﾎﾟｰﾄするﾒｿｯﾄﾞの一覧を指定する',
        ],
    ],
    'NotAcceptableException' => [
        'package' => 'HTTP',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\HTTP',
        'extends' => '\SKJ\AppException\HttpException',
        'template' => 'Not Acceptable',
        'message' => 'Not Acceptable',
        'summary' => 'Not Acceptable HTTP層実行例外',
        'code' => 406,
        'description' => 'Accept-*ﾍｯﾀﾞで指定された表現が返せない事を示す例外です',
        'details' => [
            'ﾘｸｴｽﾄに含まれるAccept-*ﾍｯﾀﾞで指定された表現が返せない場合に利用される',
            'ﾚｽﾎﾟﾝｽﾎﾞﾃﾞｨにはこのｻｰﾊﾞが用意できるﾘｿｰｽの一覧が返される',
        ],
    ],
    'ProxyAuthenticationRequiredException' => [
        'package' => 'HTTP',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\HTTP',
        'extends' => '\SKJ\AppException\HttpException',
        'template' => 'Proxy Authentication Required',
        'message' => 'Proxy Authentication Required',
        'summary' => 'Proxy Authentication Required HTTP層実行例外',
        'code' => 407,
        'description' => 'ﾌﾟﾛｷｼ認証が必要である事を示す例外です',
        'details' => [
            'ﾌﾟﾛｷｼ認証がされていない場合に利用される',
            'ﾚｽﾎﾟﾝｽにはProxy-Authenticateﾍｯﾀﾞが含まれ､そこで認証方式を指定する',
        ],
    ],
    'RequestTimeoutException' => [
        'package' => 'HTTP',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\HTTP',
        'extends' => '\SKJ\AppException\HttpException',
        'template' => 'Request Timeout',
        'message' => 'Request Timeout',
        'summary' => 'Request Timeout HTTP層実行例外',
        'code' => 408,
        'description' => 'ｻｰﾊﾞｰ側でﾀｲﾑｱｳﾄした事を示す例外です',
        'details' => [
            'ｸﾗｲｱﾝﾄがｻｰﾊﾞｰへ一定時間内にﾘｸｴｽﾄを送りきらない場合に利用される',
            'ﾚｽﾎﾟﾝｽにはConnectionﾍｯﾀﾞを含む事ができ､接続の切断を指示する事ができる',
        ],
    ],
    'ConflictException' => [
        'package' => 'HTTP',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\HTTP',
        'extends' => '\SKJ\AppException\HttpException',
        'template' => 'Conflict',
        'message' => 'Conflict',
        'summary' => 'Conflict HTTP層実行例外',
        'code' => 409,
        'description' => 'ｸﾗｲｱﾝﾄが要求した操作が､現在のﾘｿｰｽの状態と矛盾する事を示す例外です',
        'details' => [
            'ｸﾗｲｱﾝﾄが要求した操作が､現在のﾘｿｰｽの状態と矛盾している為に操作が完了できない場合に利用される',
            'ﾚｽﾎﾟﾝｽにはLocationﾍｯﾀﾞを含む事ができ､そこには競合したﾘｿｰｽなどのURIを指定する',
            '例)存在しないﾃﾞｨﾚｸﾄﾘを削除する',
            '例)名前を変更しようとしたが､既に存在する名前だった',
        ],
    ],
    'GoneException' => [
        'package' => 'HTTP',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\HTTP',
        'extends' => '\SKJ\AppException\HttpException',
        'template' => 'Gone',
        'message' => 'Gone',
        'summary' => 'Gone HTTP層実行例外',
        'code' => 410,
        'description' => '以前は存在したﾘｿｰｽだが､現在は無い事を示す例外です',
        'details' => [
            '以前には存在したﾘｿｰｽである事を示したい場合に利用される',
        ],
    ],
    'LengthRequiredException' => [
        'package' => 'HTTP',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\HTTP',
        'extends' => '\SKJ\AppException\HttpException',
        'template' => 'Length Required',
        'message' => 'Length Required',
        'summary' => 'Length Required HTTP層実行例外',
        'code' => 411,
        'description' => 'ｸﾗｲｱﾝﾄがContent-Lengthﾍｯﾀﾞを送信しなければならない事を示す例外です',
        'details' => [
            'ﾘｿｰｽ操作にはContent-Lengthﾍｯﾀﾞが必須となるが､ｸﾗｲｱﾝﾄからのﾘｸｴｽﾄには､指定されていなかった場合に利用される',
        ],
    ],
    'PreconditionFailedException' => [
        'package' => 'HTTP',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\HTTP',
        'extends' => '\SKJ\AppException\HttpException',
        'template' => 'Precondition Failed',
        'message' => 'Precondition Failed',
        'summary' => 'Precondition Failed HTTP層実行例外',
        'code' => 412,
        'description' => '条件付きﾘｸｴｽﾄで指定された事前条件が､ｻｰﾊﾞｰ側で合わない事を示す例外です',
        'details' => [
            '条件付きﾘｸｴｽﾄで指定された事前条件が､ｻｰﾊﾞｰ側で合わない場合に利用される',
            'ﾚｽﾎﾟﾝｽには再度ETagﾍｯﾀﾞやLast-Modifiedﾍｯﾀﾞを含む事ができる',
            '条件付きﾘｸｴｽﾄは楽観的ﾛｯｸで利用される',
        ],
    ],
    'RequestEntityTooLargeException' => [
        'package' => 'HTTP',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\HTTP',
        'extends' => '\SKJ\AppException\HttpException',
        'template' => 'Request Entity Too Large',
        'message' => 'Request Entity Too Large',
        'summary' => 'Request Entity Too Large HTTP層実行例外',
        'code' => 413,
        'description' => 'ﾘｸｴｽﾄが大きすぎる事を示す例外です',
        'details' => [
            'ｻｰﾊﾞｰ側で処理できないほど､ﾘｸｴｽﾄﾒｯｾｰｼﾞが巨大である場合に利用される',
            'ﾚｽﾎﾟﾝｽにはConnectionﾍｯﾀﾞを含む事ができ､接続の切断を指示する事ができる',
        ],
    ],
    'RequestUriTooLongException' => [
        'package' => 'HTTP',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\HTTP',
        'extends' => '\SKJ\AppException\HttpException',
        'template' => 'Request-URI Too Long',
        'message' => 'Request-URI Too Long',
        'summary' => 'Request-URI Too Long HTTP層実行例外',
        'code' => 414,
        'description' => 'URIが長すぎる事を示す例外です',
        'details' => [
            'ｻｰﾊﾞｰ側で処理できないほど､ﾘｸｴｽﾄのURIが長い場合に利用される',
        ],
    ],
    'UnsupportedMediaTypeException' => [
        'package' => 'HTTP',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\HTTP',
        'extends' => '\SKJ\AppException\HttpException',
        'template' => 'Unsupported Media Type',
        'message' => 'Unsupported Media Type',
        'summary' => 'Unsupported Media Type HTTP層実行例外',
        'code' => 415,
        'description' => '処理できないﾒﾃﾞｨｱﾀｲﾌﾟである事を示す例外です',
        'details' => [
            'ﾘｸｴｽﾄに指定されたﾒﾃﾞｨｱﾀｲﾌﾟをｻｰﾊﾞｰ側がｻﾎﾟｰﾄできない場合に利用される',
            '例)JPG形式しか保存できないｻｰﾊﾞｰに､GIF形式で保存しようとした',
        ],
    ],
    'RequestedRangeNotSatisfiableException' => [
        'package' => 'HTTP',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\HTTP',
        'extends' => '\SKJ\AppException\HttpException',
        'template' => 'Requested Range Not Satisfiable',
        'message' => 'Requested Range Not Satisfiable',
        'summary' => 'Requested Range Not Satisfiable HTTP層実行例外',
        'code' => 416,
        'description' => '指定されたRangeﾍｯﾀﾞの範囲とﾘｿｰｽ範囲が合っていない事を示す例外です',
        'details' => [
            'ﾘｸｴｽﾄで指定されたRangeﾍｯﾀﾞの範囲が､実際のﾘｿｰｽの範囲と合っていない場合に利用される',
        ],
    ],
    'ExpectationFailedException' => [
        'package' => 'HTTP',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\HTTP',
        'extends' => '\SKJ\AppException\HttpException',
        'template' => 'Expectation Failed',
        'message' => 'Expectation Failed',
        'summary' => 'Expectation Failed HTTP層実行例外',
        'code' => 417,
        'description' => 'Expectﾍｯﾀﾞを処理できない事を示す例外です',
        'details' => [
            'ｻｰﾊﾞｰ側でExpectﾍｯﾀﾞ(100-continue)を処理できない場合に利用される',
        ],
    ],
    'UnprocessableEntityException' => [
        'package' => 'HTTP',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\HTTP',
        'extends' => '\SKJ\AppException\HttpException',
        'template' => 'Unprocessable Entity',
        'message' => 'Unprocessable Entity',
        'summary' => 'Unprocessable Entity HTTP層実行例外',
        'code' => 422,
        'description' => '構文的に正しいが､意味的に間違っている事を示す例外です',
        'details' => [
            'WebDAVにおいて､ｸﾗｲｱﾝﾄが送信したXMLが構文的にはあってはいるが､意味的には間違っている場合に利用される',
            'WebDAVではなくとも､400よりも狭い意味でｴﾗｰを限定したい場合も､このｺｰﾄﾞが利用できる',
            'ﾚｽﾎﾟﾝｽﾎﾞﾃﾞｨにはｴﾗｰ詳細(JSONなどで)を渡す事も可能',
        ],
    ],
    'LockedException' => [
        'package' => 'HTTP',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\HTTP',
        'extends' => '\SKJ\AppException\HttpException',
        'template' => 'Locked',
        'message' => 'Locked',
        'summary' => 'Locked HTTP層実行例外',
        'code' => 423,
        'description' => 'ﾘｿｰｽがﾛｯｸされている事を示す例外です',
        'details' => [
            'WebDAVにおいて､ﾛｯｸされたﾘｿｰｽを操作しようとした場合に利用される',
        ],
    ],
    'FailedDependencyException' => [
        'package' => 'HTTP',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\HTTP',
        'extends' => '\SKJ\AppException\HttpException',
        'template' => 'Failed Dependency',
        'message' => 'Failed Dependency',
        'summary' => 'Failed Dependency HTTP層実行例外',
        'code' => 424,
        'description' => '依存関係に問題が発生した事を示す例外です',
        'details' => [
            'WebDAVにおいて､ｸﾗｲｱﾝﾄが要求したﾒｿｯﾄﾞが依存している他のﾒｿｯﾄﾞが失敗した為､もとのﾘｸｴｽﾄ自体が失敗した場合に利用される',
        ],
    ],
    'InternalServerErrorException' => [
        'package' => 'HTTP',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\HTTP',
        'extends' => '\SKJ\AppException\HttpException',
        'template' => 'Internal Server Error',
        'message' => 'Internal Server Error',
        'summary' => 'Internal Server Error HTTP層実行例外',
        'code' => 500,
        'description' => 'ｻｰﾊﾞｰ側でｴﾗｰが発生した事を示す例外です',
        'details' => [
            'ｻｰﾊﾞｰ側で回復不能なｴﾗｰが発生した場合に利用される',
            '他の5xx系ｴﾗｰｺｰﾄﾞに適さないようなｹｰｽでも利用される',
            'ｸﾗｲｱﾝﾄは未知の5xxｴﾗｰｺｰﾄﾞを受け取った時に､500と同じ扱いをする',
        ],
    ],
    'NotImplementedException' => [
        'package' => 'HTTP',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\HTTP',
        'extends' => '\SKJ\AppException\HttpException',
        'template' => 'Not Implemented',
        'message' => 'Not Implemented',
        'summary' => 'Not Implemented HTTP層実行例外',
        'code' => 501,
        'description' => 'ﾘｸｴｽﾄされたﾒｿｯﾄﾞが､このﾘｿｰｽでは提供していない事を示す例外です',
        'details' => [
            'あるURIにおいて､本来なら実装されるべきﾒｿｯﾄﾞが現時点ではｻﾎﾟｰﾄされていない場合に利用される',
            '405 Method Not Allowedとの違いとしては､いつかは実装されるという事であり､その為に5xx系となっている',
        ],
    ],
    'BadGatewayException' => [
        'package' => 'HTTP',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\HTTP',
        'extends' => '\SKJ\AppException\HttpException',
        'template' => 'Bad Gateway',
        'message' => 'Bad Gateway',
        'summary' => 'Bad Gateway HTTP層実行例外',
        'code' => 502,
        'description' => '転送ﾘｸｴｽﾄが失敗した事を示す例外です',
        'details' => [
            'ﾌﾟﾛｷｼが上流のｻｰﾊﾞｰにﾘｸｴｽﾄを転送したが､処理結果が正常終了しなかった場合に利用される',
        ],
    ],
    'ServiceUnavailableException' => [
        'package' => 'HTTP',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\HTTP',
        'extends' => '\SKJ\AppException\HttpException',
        'template' => 'Service Unavailable',
        'message' => 'Service Unavailable',
        'summary' => 'Service Unavailable HTTP層実行例外',
        'code' => 503,
        'description' => 'ｻｰﾋﾞｽの提供ができない事を示す例外です',
        'details' => [
            'ﾒﾝﾃﾅﾝｽなどでｻｰﾋﾞｽの提供ができない場合に利用される',
        ],
    ],
    'GatewayTimeoutException' => [
        'package' => 'HTTP',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\HTTP',
        'extends' => '\SKJ\AppException\HttpException',
        'template' => 'Gateway Timeout',
        'message' => 'Gateway Timeout',
        'summary' => 'Gateway Timeout HTTP層実行例外',
        'code' => 504,
        'description' => '転送ﾘｸｴｽﾄがﾀｲﾑｱｳﾄした事を示す例外です',
        'details' => [
            'ﾌﾟﾛｷｼが上流のｻｰﾊﾞｰにﾘｸｴｽﾄを転送したが､接続できない､もしくはﾀｲﾑｱｳﾄした場合に利用される',
        ],
    ],
    'HttpVersionNotSupportedException' => [
        'package' => 'HTTP',
        'since' => '0.8.0',
        'namespace' => 'SKJ\AppException\HTTP',
        'extends' => '\SKJ\AppException\HttpException',
        'template' => 'HTTP Version Not Supported',
        'message' => 'HTTP Version Not Supported',
        'summary' => 'HTTP Version Not Supported HTTP層実行例外',
        'code' => 505,
        'description' => 'ｻﾎﾟｰﾄ外のHTTPﾊﾞｰｼﾞｮﾝである事を示す例外です',
        'details' => [
            'ｸﾗｲｱﾝﾄが送信したﾘｸｴｽﾄが､ｻｰﾊﾞｰ側でｻﾎﾟｰﾄしていないHTTPﾊﾞｰｼﾞｮﾝである場合に利用される',
        ],
    ],
];

$userLogicExceptions = [
    'ContainerException' => [
        'extends' => '\SKJ\AppException\AbstractContainerException',
        'since' => '0.8.0',
        'template' => '未知、未分類の例外です[%s]',
        'message' => '未知、未分類の例外です',
        'summary' => '未知､未分類の例外が連結されたﾛｼﾞｯｸ例外',
        'code' => 1201,
        'description' => '未知､未分類の例外を受け取った場合､その例外を連結して使用する例外です',
        'details' => [
            '呼び出した関数やﾒｿｯﾄﾞから､特に特別な処理をしない(できない)例外を受け取った場合､この例外を連結して再度上流へと投げる為に利用される',
            '呼び出し側に通知が不必要な例外や、発生する事自体を認識していない例外は､全てこの例外に連結することによって､未知、未分類の例外という抽象化をする為に使用する',
            'これを使用する事によってphpdocの記述を単純化させる',
            'また､AppExceptionが持ついくつかの機能では標準で､この例外を無視する仕様となっている(例えばｲﾃﾚｰﾀとして利用時に､この例外だけは飛ばすなど)',
            'この例外のﾒｯｾｰｼﾞ､例外ｺｰﾄﾞ､状態ｺｰﾄﾞ、ﾌｨｰﾙﾄﾞ名などは連結された例外のものが自動的に設定される',
            'この例外が発生した場所と同一ｽｺｰﾌﾟで発生した例外をｺﾝｽﾄﾗｸﾀの引数<var>$previous</var>に渡した場合は、この例外が作成されずに<var>$previous</var>が再ｽﾙｰされる',
            'ｺﾝｽﾄﾗｸﾀの引数<var>$previous</var>にContainerExceptionのｲﾝｽﾀﾝｽが渡された場合は、この例外が作成されずに<var>$previous</var>が再ｽﾙｰされる',
        ],
    ]
];

if (($additionalLogicExceptions = require_once('logic.php')) === false and
    !is_array($additionalLogicExceptions)) {

    die('Logic系例外の読み込みに失敗した'.PHP_EOL);
}

$userLogicExceptions += $additionalLogicExceptions;

foreach ($userLogicExceptions as &$exception) {

    if (!array_key_exists('package', $exception)) {
        $exception['package'] = 'Logic';
    }

    if (!array_key_exists('namespace', $exception)) {
        $exception['namespace'] = 'SKJ\AppException\Logic';
    }
}

$userRuntimeExceptions = [];

if (($additionalRuntimeExceptions = require_once('runtime.php')) === false and
    !is_array($additionalRuntimeExceptions)) {

    die('Runtime系例外の読み込みに失敗した'.PHP_EOL);
}

$userRuntimeExceptions += $additionalRuntimeExceptions;

foreach ($userRuntimeExceptions as &$exception) {

    if (!array_key_exists('package', $exception)) {
        $exception['package'] = 'Runtime';
    }

    if (!array_key_exists('namespace', $exception)) {
        $exception['namespace'] = 'SKJ\AppException\Runtime';
    }
}

// 最終的な結合
return [
    $splLogicExceptions,
    $splRuntimeExceptions,
    $httpExceptions,
    $userLogicExceptions,
    $userRuntimeExceptions,
];
