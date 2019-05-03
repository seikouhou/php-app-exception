<?php

/**
 * VisibilityBreakingWrapperｸﾗｽ
 *
 * 単体ﾃｽﾄ時に使用し、ｵﾌﾞｼﾞｪｸﾄの可視性を突破する為のﾗｯﾊﾟｰｸﾗｽで主な機能は下記となる
 *
 * <ul>
 *     <li>public以外のﾌﾟﾛﾊﾟﾃｨを外部から参照可能とする</li>
 *     <li>public、protected、private問わず外部からﾒｿｯﾄﾞをﾓｯｸに置き換える(要Runkit)</li>
 * </ul>
 *
 * ﾒｿｯﾄﾞの置き換えは外部から呼ばれる時だけでなく、ｵﾌﾞｼﾞｪｸﾄ自身からの内部的な呼び出しも置き換わっているので注意。
 *
 * @package SKJ\Test
 * @version 1.0.0
 * @author y3high <y3public@49364.net>
 * @copyright 2014 Seikouhou.
 * @license https://opensource.org/licenses/MIT MIT
 * @since Class available since Release 1.0.0
 */
class VisibilityBreakingWrapper
{
    /**
     * ﾓｯｸﾒｿｯﾄﾞの戻り値種別定数(0から始まらないのは自動型変換対策)
     *
     * @see self::registerMockMethod
     * @see self::mockMethod
     */
    const MOCK_IMMOBILITY = 2; // 戻り値は固定
    const MOCK_SEQUENCE = 3; // 戻り値は配列の値を繰り返す
    const MOCK_INDEX = 4; // 戻り値はCALL時の引数に対応した連想配列の値
    const MOCK_CALLBACK = 5; // 戻り値はCALLBACK関数によって返される
    public static $mockMethods = [];
    private $_target;
    private $_targetHashId;
    private $_targetClassName;
    private $_useRunKit;
    public $_mockMethods; // debugの為に可視化

    /**
     * ｺﾝｽﾄﾗｸﾀ
     *
     * @param object $target 可視性を突破したいｵﾌﾞｼﾞｪｸﾄ
     * @param bool $useRunKit runkitﾓｰﾄﾞで動かす場合は真
     * @throws \InvalidArgumentException 引数が間違っている
     */
    public function __construct($target, $useRunKit = false)
    {

        if (!is_object($target)) {

            throw new InvalidArgumentException(
                '第1引数がオブジェクトではありません'
            );
        }

        $this->_target = $target;
        $this->_targetHashId = spl_object_hash($this->_target);
        $this->_targetClassName = get_class($target);
        $this->_useRunKit = (boolean)$useRunKit;

        if (!array_key_exists($this->_targetClassName, self::$mockMethods)) {

            self::$mockMethods[$this->_targetClassName] = [];
        }

        $this->_mockMethods =& self::$mockMethods[$this->_targetClassName];
    }

    /**
     * ﾃﾞｽﾄﾗｸﾀ
     *
     * 各種後始末処理を行う(特に静的ﾒﾝﾊﾞ変数の掃除が重要なので注意!!)
     *
     * @see \VisibilityBreakingWrapper::unregisterMockMethod()
     */
    public function __destruct()
    {

        foreach ($this->_mockMethods as $methodName => $value) {

            if ($value['ownerObjectHashId'] === $this->_targetHashId) {

                $this->unregisterMockMethod($methodName);
            }
        }

        if (array_key_exists($this->_targetClassName, self::$mockMethods)) {

            if (count(self::$mockMethods[$this->_targetClassName]) == 0) {

                unset(self::$mockMethods[$this->_targetClassName]);
            }
        }
    }

    /**
     * 現在の対象ｵﾌﾞｼﾞｪｸﾄを返す
     *
     * @return object 現在の対象ｵﾌﾞｼﾞｪｸﾄ
     */
    public function getTestTargetObject()
    {
        return $this->_target;
    }

    /**
     * ﾓｯｸﾒｿｯﾄﾞの登録
     *
     * @param string $methodName 登録したいﾒｿｯﾄﾞ名
     * @param mixed $returnValue 第3引数で指定された形式での戻り値ﾃﾞｰﾀ
     * @param integer $returnType どんな戻り値を返すのかの種別(self::MOCK_*)
     * @return bool 常に真を返す
     * @throws \InvalidArgumentException 引数が間違っている
     * @throws \LogicException 異常動作時
     */
    public function registerMockMethod(
        $methodName,
        $returnValue,
        $returnType = self::MOCK_IMMOBILITY
    ){
        // PHPは関数名に関しては大文字小文字区別しない
        $methodName = strtolower($methodName);

        // ﾒｿｯﾄﾞの存在確認
        try {

            $methodRefObj = new ReflectionMethod($this->_target, $methodName);

        } catch (ReflectionException $e) {

            throw new InvalidArgumentException(
                '第1引数が存在しないメソッド名です'
            );
        }

        // 既に書き換えられている??
        if (array_key_exists($methodName, $this->_mockMethods)) {

            throw new InvalidArgumentException(
                '既にこのメソッドは書き換えられています'
            );
        }

        switch ($returnType) {

            case self::MOCK_IMMOBILITY:

                break;

            case self::MOCK_SEQUENCE:

                if (!is_array($returnValue) || !count($returnValue)) {

                    throw new InvalidArgumentException(
                        '第2引数が正常な戻り値リストではありません'
                    );
                }
                $returnValue = array_values($returnValue);

                break;

            case self::MOCK_INDEX:

                if (!is_array($returnValue) ||
                    !array_key_exists(0, $returnValue) ||
                    !array_key_exists(1, $returnValue) ||
                    !is_array($returnValue[0]) || !is_array($returnValue[1]) ||
                    !count($returnValue[0]) || !count($returnValue[1]) ||
                    count($returnValue[0]) != count($returnValue[1])) {

                    throw new InvalidArgumentException(
                        '第2引数が正常な戻り値リストではありません'
                    );
                }
                $returnValue[0] = array_values($returnValue[0]);
                $returnValue[1] = array_values($returnValue[1]);

                break;

            case self::MOCK_CALLBACK:

                if (!is_callable($returnValue)) {

                    throw new InvalidArgumentException(
                        '第2引数がcallableではありません'
                    );
                }

                break;

            default:

                throw new InvalidArgumentException(
                    '第3引数の戻り値種別が異常です'
                );
        }

        // 退避用ﾒｿｯﾄﾞ名作成
        $tempMethodName = strtolower(uniqid());

        // PECLrunkitを使用してﾒｿｯﾄﾞを書き換える
        if ($this->_useRunKit) {

            // ｵﾘｼﾞﾅﾙのﾒｿｯﾄﾞ名は名称を変更して保管
            if (!runkit_method_rename(
                $this->_targetClassName,
                $methodName,
                $tempMethodName
            )) {

                throw new LogicException('メソッドの保管に失敗しました');
            }

            // ﾒｿｯﾄﾞを追加
            if ($methodRefObj->isStatic() && defined('RUNKIT_ACC_STATIC')) {

                $flgs = RUNKIT_ACC_PUBLIC | RUNKIT_ACC_STATIC;

            } else {

                $flgs = RUNKIT_ACC_PUBLIC;
            }
            if (!runkit_method_add(
                $this->_targetClassName,
                $methodName,
                '',
                "return(VisibilityBreak::mockMethod('{$methodName}',".
                "func_get_args(),'{$this->_targetClassName}'));",
                $flgs
            )) {

                throw new LogicException(
                    'モックメソッドを追加できませんでした'
                );
            }
        }

        // 静的領域に格納
        $this->_mockMethods[$methodName] = [
            'returnType' => $returnType,
            'returnValue' => $returnValue,
            'index' => 0,
            'tempMethodName' => $tempMethodName,
            'ownerObjectHashId' => $this->_targetHashId,
        ];

        return (true);
    }

    /**
     * ﾓｯｸﾒｿｯﾄﾞの解除
     *
     * @param string $methodName 解除したいﾒｿｯﾄﾞ名
     * @return bool 常に真を返す
     * @throws \InvalidArgumentException 引数が間違っている
     * @throws \LogicException 異常動作時
     */
    public function unregisterMockMethod($methodName)
    {
        // PHPは関数名に関しては大文字小文字区別しない
        $methodName = strtolower($methodName);

        // 登録されていない!!
        if (!array_key_exists($methodName, $this->_mockMethods)) {

            throw new InvalidArgumentException(
                'モックメソッドは登録されていません'
            );
        }

        // 登録したのは違うｵﾌﾞｼﾞｪｸﾄ
        if ($this->_mockMethods[$methodName]['ownerObjectHashId'] !==
            $this->_targetHashId) {

            throw new InvalidArgumentException(
                'モックメソッドの解除は登録したオブジェクトでのみ可能です'
            );
        }

        if ($this->_useRunKit) {

            // ﾓｯｸﾒｿｯﾄﾞを削除
            if (!runkit_method_remove($this->_targetClassName, $methodName)) {

                throw new LogicException(
                    'モックメソッドの削除に失敗しました'
                );
            }

            // ｵﾘｼﾞﾅﾙのﾒｿｯﾄﾞを復元
            if (!runkit_method_rename(
                $this->_targetClassName,
                $this->_mockMethods[$methodName]['tempMethodName'],
                $methodName
            )) {

                throw new LogicException('メソッドの復元に失敗しました');
            }
        }

        unset($this->_mockMethods[$methodName]);

        return (true);
    }

    /**
     * ﾌﾟﾛﾊﾟﾃｨの設定
     *
     * 基本的にﾏｼﾞｯｸﾒｿｯﾄﾞなので直接呼ばれない。可視性を無効にしたいﾌﾟﾛ
     * ﾊﾟﾃｨ名がﾌﾟﾛｸﾞﾗﾑの文脈上で出現した場合に代わりに呼び出される。
     *
     * @param string $propertyName 取得したいﾌﾟﾛﾊﾟﾃｨ名
     * @param mixed $value 設定したい値
     * @return bool 常に真を返す
     */
    public function __set($propertyName, $value)
    {
        try {

            $refClass = new ReflectionClass($this->_target);
            $property = $refClass->getProperty($propertyName);

        } catch (ReflectionException $e) {

            // ﾌﾟﾛﾊﾟﾃｨが存在しない場合
            // これは対象ｵﾌﾞｼﾞｪｸﾄの(ここでは$this->_target)の__set(ｵｰﾊﾞ
            // ｰﾛｰﾄﾞ)に対応するためのｺｰﾄﾞ
            $this->_target->$propertyName = $value;

            return (true);
        }

        $property->setAccessible(true);

        if ($property->isStatic()) {

            $property->setValue($value);

        } else {

            $property->setValue($this->_target, $value);
        }

        return (true);
    }

    /**
     * ﾌﾟﾛﾊﾟﾃｨの取得
     *
     * 基本的にﾏｼﾞｯｸﾒｿｯﾄﾞなので直接呼ばれない。可視性を無効にしたいﾌﾟﾛ
     * ﾊﾟﾃｨ名がﾌﾟﾛｸﾞﾗﾑの文脈上で出現した場合に代わりに呼び出される。
     *
     * @param string $propertyName 取得したいﾌﾟﾛﾊﾟﾃｨ名
     * @return mixed ﾌﾟﾛﾊﾟﾃｨに設定されている値を返す
     */
    public function __get($propertyName)
    {

        try {

            $refClass = new ReflectionClass($this->_target);
            $property = $refClass->getProperty($propertyName);

        } catch (ReflectionException $e) {

            // ﾌﾟﾛﾊﾟﾃｨが存在しない場合
            // これは対象ｵﾌﾞｼﾞｪｸﾄの(ここでは$this->_target)の__get(ｵｰﾊﾞ
            // ｰﾛｰﾄﾞ)に対応するためのｺｰﾄﾞ
            return ($this->_target->$propertyName);
        }

        $property->setAccessible(true);

        if ($property->isStatic()) {

            return ($property->getValue());

        } else {

            return ($property->getValue($this->_target));
        }
    }

    /**
     * ﾒｿｯﾄﾞの呼び出し
     *
     * 基本的にﾏｼﾞｯｸﾒｿｯﾄﾞなので直接呼ばれない。可視性を無効にしたい、
     * もしくはﾓｯｸﾒｿｯﾄﾞの対象となるﾒｿｯﾄﾞ名が、ﾌﾟﾛｸﾞﾗﾑの文脈上で出
     * 現した場合に代わりに呼び出される。
     *
     * @param string $methodName 呼び出したいﾒｿｯﾄﾞ名
     * @param array $args ﾒｿｯﾄﾞに渡す引数
     * @return mixed 呼び出したﾒｿｯﾄﾞに応じた値を返す
     * @throws \BadMethodCallException 未定義のﾒｿｯﾄﾞ名が渡された
     * @throws \OutOfBoundsException 異常動作時
     * @see \VisibilityBreakingWrapper::mockMethod()
     */
    public function __call($methodName, $args)
    {
        $lowerMethodName = strtolower($methodName);

        if (array_key_exists($lowerMethodName, $this->_mockMethods) and
            !$this->_useRunKit) {

            return (self::mockMethod(
                $lowerMethodName,
                $args,
                $this->_targetClassName
            ));
        }

        try {

            $method = new ReflectionMethod($this->_target, $lowerMethodName);

        } catch (ReflectionException $e) {

            // ﾒｿｯﾄﾞが存在しない場合
            // これは対象ｵﾌﾞｼﾞｪｸﾄの(ここでは$this->_target)の__call(ｵｰﾊﾞ
            // ｰﾛｰﾄﾞ)に対応するためのｺｰﾄﾞ
            // ﾏｼﾞｯｸﾒｿｯﾄﾞに渡す関係上、小文字強制ではなくｵﾘｼﾞﾅﾙﾒｿ
            // ｯﾄﾞ名で渡す(例えﾓｯｸでも関数呼び出しは問題ないはず)
            return (call_user_func_array(
                [$this->_target, $methodName],
                $args
            ));
        }

        $method->setAccessible(true);

        if ($method->isStatic()) {

            return ($method->invokeArgs(null, $args));

        } else {

            return ($method->invokeArgs($this->_target, $args));
        }
    }

    /**
     * ﾓｯｸﾒｿｯﾄﾞの実行
     *
     * 基本的には直接呼ばれずに、__callからの転送もしくは置き換えられたﾒｿｯﾄﾞからの呼び出しとなる。
     *
     * @param string $methodName 呼び出したいﾒｿｯﾄﾞ名
     * @param array $args ﾒｿｯﾄﾞに渡す引数
     * @param string $className ﾒｿｯﾄﾞが属するｸﾗｽ名
     * @return mixed ﾓｯｸﾒｿｯﾄﾞに設定された値を返す
     * @throws \BadMethodCallException 未定義のﾒｿｯﾄﾞ名が渡された
     * @throws \OutOfBoundsException 異常動作時
     */
    public function mockMethod($methodName, $args, $className)
    {
        $methodName = strtolower($methodName);

        foreach (self::$mockMethods as $index => $value) {

            if ($index != $className) {

                continue;
            }

            if (!array_key_exists($methodName, $value)) {

                throw new BadMethodCallException('未定義のメソッドです');
            }

            $info =& self::$mockMethods[$className][$methodName];

            switch ($info['returnType']) {

                case self::MOCK_IMMOBILITY:

                    return ($info['returnValue']);

                case self::MOCK_SEQUENCE:

                    if ($info['index'] >= count($info['returnValue'])) {

                        $info['index'] = 0;
                    }

                    return ($info['returnValue'][$info['index']++]);

                case self::MOCK_INDEX:

                    if (($key = array_search(
                            $args,
                            $info['returnValue'][0]
                        )) === false) {

                        throw new OutOfBoundsException(
                            '該当する引数パターンが見つかりません'
                        );
                    }

                    return ($info['returnValue'][1][$key]);

                case self::MOCK_CALLBACK:

                    return (call_user_func_array($info['returnValue'], $args));

                default:

                    throw new OutOfBoundsException('戻り値種別が異常です');
            }
        }
    }
}
