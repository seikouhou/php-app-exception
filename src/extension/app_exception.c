/*
  +----------------------------------------------------------------------+
  | PHP Version 5                                                        |
  +----------------------------------------------------------------------+
  | Copyright (c) 1997-2015 The PHP Group                                |
  +----------------------------------------------------------------------+
  | This source file is subject to version 3.01 of the PHP license,      |
  | that is bundled with this package in the file LICENSE, and is        |
  | available through the world-wide-web at the following url:           |
  | http://www.php.net/license/3_01.txt                                  |
  | If you did not receive a copy of the PHP license and are unable to   |
  | obtain it through the world-wide-web, please send a note to          |
  | license@php.net so we can mail you a copy immediately.               |
  +----------------------------------------------------------------------+
  | Author:                                                              |
  +----------------------------------------------------------------------+
*/

/* $Id$ */

#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include "php.h"
#include "php_ini.h"
#include "ext/standard/info.h"
#include "zend_exceptions.h"
#include "zend_interfaces.h"
#include "php_app_exception.h"

/* If you declare any globals in php_app_exception.h uncomment this:
ZEND_DECLARE_MODULE_GLOBALS(app_exception)
*/

/* {{{ PHP_INI
 */
/* Remove comments and fill if you need to have entries in php.ini
PHP_INI_BEGIN()
    STD_PHP_INI_ENTRY("app_exception.global_value",      "42", PHP_INI_ALL, OnUpdateLong, global_value, zend_app_exception_globals, app_exception_globals)
    STD_PHP_INI_ENTRY("app_exception.global_string", "foobar", PHP_INI_ALL, OnUpdateString, global_string, zend_app_exception_globals, app_exception_globals)
PHP_INI_END()
*/
/* }}} */

/* Remove the following function when you have successfully modified config.m4
   so that your module can be compiled into PHP, it exists only for testing
   purposes. */

/* }}} */
/* The previous line is meant for vim and emacs, so it can correctly fold and
   unfold functions in source code. See the corresponding marks just before
   function definition, where the functions purpose is also documented. Please
   follow this convention for the convenience of others editing your code.
*/


/* {{{ php_app_exception_init_globals
 */
/* Uncomment this function if you have INI entries
static void php_app_exception_init_globals(zend_app_exception_globals *app_exception_globals)
{
    app_exception_globals->global_value = 0;
    app_exception_globals->global_string = NULL;
}
*/
/* }}} */

zend_class_entry *ce_AppException = NULL;
zend_class_entry *ce_Exception;

static int set_global_vars_snapshot(zval *object,int force)
{
    zval *enableGlobalVarsSnapShot,*global_vars;

    // 機能のON･OFFｽｲｯﾁの読み込み
    enableGlobalVarsSnapShot = zend_read_static_property(
        ce_AppException,
        "enableGlobalVarsSnapShot",
        sizeof("enableGlobalVarsSnapShot") - 1,
        0 TSRMLS_CC);
    convert_to_boolean(enableGlobalVarsSnapShot);

    // ｸﾞﾛｰﾊﾞﾙ変数のｽﾅｯﾌﾟｼｮｯﾄの取得
    if(force > 0 || (force == -1 && Z_BVAL_P(enableGlobalVarsSnapShot)))
    {
        MAKE_STD_ZVAL(global_vars);

        array_init_size(
            global_vars,
            zend_hash_num_elements(&EG(symbol_table)));
        zend_hash_copy(
            Z_ARRVAL_P(global_vars),
            &EG(symbol_table),
            (copy_ctor_func_t)zval_add_ref,
            NULL,
            sizeof(zval *));
        zend_update_property(
            ce_AppException,
            object,
            "globalVarsSnapShot",
            sizeof("globalVarsSnapShot") - 1,
            global_vars TSRMLS_CC);

        zval_ptr_dtor(&global_vars);
    }

    return SUCCESS;
}

static int set_caller_vars_snapshot(zval *object,int force)
{
    zval *enableCallerVarsSnapShot,*local_vars,*this;

    // 機能のON･OFFｽｲｯﾁの読み込み
    enableCallerVarsSnapShot = zend_read_static_property(
        ce_AppException,
        "enableCallerVarsSnapShot",
        sizeof("enableCallerVarsSnapShot") - 1,
        0 TSRMLS_CC);
    convert_to_boolean(enableCallerVarsSnapShot);

    //    zend_call_method_with_1_params(NULL, NULL, NULL, "var_dump", NULL, enableCallerVarsSnapShot);
    // 呼び出し元ｽｺｰﾌﾟの変数のｽﾅｯﾌﾟｼｮｯﾄの取得
    if(force > 0 || (force == -1 && Z_BVAL_P(enableCallerVarsSnapShot)))
    {
    MAKE_STD_ZVAL(local_vars);

        array_init_size(
            local_vars,
            zend_hash_num_elements(EG(active_symbol_table)));
        zend_hash_copy(
            Z_ARRVAL_P(local_vars),
            EG(active_symbol_table),
            (copy_ctor_func_t)zval_add_ref,
            NULL,
            sizeof(zval *));
        // $thisの読み込み(これをしないとﾛｰｶﾙｽｺｰﾌﾟに$thisが現れない)
        if(EG(current_execute_data->current_this) != NULL)
        {
            //this = EG(current_execute_data->current_this);
            //INIT_PZVAL_COPY(this,EG(current_execute_data->current_this));
            //zval_copy_ctor(this);

            //MAKE_COPY_ZVAL(&this,EG(current_execute_data->current_this));
            add_assoc_zval(local_vars,"this",EG(current_execute_data->current_this));
            Z_ADDREF_P(EG(current_execute_data->current_this));
            /*
            MAKE_STD_ZVAL(this);

            array_init_size(
                this,
                zend_hash_num_elements(&EG(current_execute_data->current_this)));
            zend_hash_copy(
                Z_ARRVAL_P(this),
                &EG(symbol_table),
                (copy_ctor_func_t)zval_add_ref,
                NULL,
                sizeof(zval *));
            */
        }
        zend_update_property(
            ce_AppException,
            object,
            "callerVarsSnapShot",
            sizeof("callerVarsSnapShot") - 1,
            local_vars TSRMLS_CC);

        zval_ptr_dtor(&local_vars);
        /*
        Z_DELREF_P(this);
        Z_DELREF_P(this);
        zval_ptr_dtor(&this);
        */
    }

    return SUCCESS;
}

static int set_debug_trace(zval *object)
{
    zval *empty_array,*trace,*retval,*argv[1],*func;

    // ﾌﾟﾛﾊﾟﾃｨの初期化
    MAKE_STD_ZVAL(empty_array);
    array_init(empty_array);
    zend_update_property(
        ce_AppException,
        object,
        "callQueue",
        sizeof("callQueue") - 1,
        empty_array TSRMLS_CC);
    zval_ptr_dtor(&empty_array);

    // ﾃﾞﾊﾞｯｸﾞﾄﾚｰｽの取得
    MAKE_STD_ZVAL(trace);
    zend_fetch_debug_backtrace(trace,0,0,0 TSRMLS_CC);
    argv[0] = trace;

    // 逆転
    MAKE_STD_ZVAL(retval);
    MAKE_STD_ZVAL(func);
    ZVAL_STRING(func,"array_reverse",1);
    if((call_user_function(
        EG(function_table),NULL,func,retval,1,argv TSRMLS_CC) == FAILURE))
    {
        /*
        zval_ptr_dtor(&trace);
        zval_ptr_dtor(&retval);
        zval_ptr_dtor(&func);
        */
        return FAILURE;
    }

    // ﾌﾟﾛﾊﾟﾃｨへSET
    zend_update_property(
        ce_AppException,
        object,
        "callQueue",
        sizeof("callQueue") - 1,
        retval TSRMLS_CC);

    // 片付け
    /*
    zval_ptr_dtor(&trace);
    zval_ptr_dtor(&retval);
    zval_ptr_dtor(&func);
    */

    return SUCCESS;
}

static int call_convert_to_app_exception(zval *object,zval *previous)
{
    zval *retval,*argv[2],*func,*result = NULL;
    zend_class_entry *ce = Z_OBJCE_P(object);

    MAKE_STD_ZVAL(retval);
    MAKE_STD_ZVAL(func);
    MAKE_STD_ZVAL(argv[1]);
    ZVAL_STRING(func,"method_exists",1);
    ZVAL_STRING(argv[1],"convertToAppException",1);
    argv[0] = object;

    if((call_user_function(
        EG(function_table),NULL,func,retval,2,argv TSRMLS_CC) == FAILURE))
    {
        return FAILURE;
    }

    if(Z_BVAL_P(retval))
    {
        EG(exception) = NULL;

        zend_call_method_with_1_params(&object,ce,NULL,"converttoappexception",&result,previous);

        zend_update_property(
            ce_Exception, // ￩実行ｺﾝﾃｷｽﾄ､ﾌﾟﾛﾊﾟﾃｨの可視性とかに関係
            object,
            "previous",
            sizeof("previous") - 1,
            result TSRMLS_CC);
    }else{
        zend_update_property(
            ce_Exception, // ￩実行ｺﾝﾃｷｽﾄ､ﾌﾟﾛﾊﾟﾃｨの可視性とかに関係
            object,
            "previous",
            sizeof("previous") - 1,
            previous TSRMLS_CC);
    }

    // 開放
    zval_ptr_dtor(&func);
    zval_ptr_dtor(&argv[1]);
    zval_ptr_dtor(&retval);
    if(result != NULL)
    {
        zval_ptr_dtor(&result);
    }

    return SUCCESS;
}

static int call__initialize(zval *object)
{
    zval *retval,*argv[2],*func,*result = NULL;
    zend_class_entry *ce = Z_OBJCE_P(object);

    MAKE_STD_ZVAL(retval);
    MAKE_STD_ZVAL(func);
    MAKE_STD_ZVAL(argv[1]);
    ZVAL_STRING(func,"method_exists",1);
    ZVAL_STRING(argv[1],"_initialize",1);
    argv[0] = object;

    if((call_user_function(
        EG(function_table),NULL,func,retval,2,argv TSRMLS_CC) == FAILURE))
    {
        return FAILURE;
    }

    if(Z_BVAL_P(retval))
    {
        EG(exception) = NULL;

        zend_call_method_with_0_params(&object,ce,NULL,"_initialize",&result);
    }

    // 開放
    zval_ptr_dtor(&func);
    zval_ptr_dtor(&argv[1]);
    zval_ptr_dtor(&retval);
    if(result != NULL)
    {
        zval_ptr_dtor(&result);
    }

    return SUCCESS;
}

static int call_initialize(zval *object)
{
    zval *retval,*argv[2],*func,*result = NULL;
    zend_class_entry *ce = Z_OBJCE_P(object);

    MAKE_STD_ZVAL(retval);
    MAKE_STD_ZVAL(func);
    MAKE_STD_ZVAL(argv[1]);
    ZVAL_STRING(func,"method_exists",1);
    ZVAL_STRING(argv[1],"initialize",1);
    argv[0] = object;

    if((call_user_function(
        EG(function_table),NULL,func,retval,2,argv TSRMLS_CC) == FAILURE))
    {
        return FAILURE;
    }

    if(Z_BVAL_P(retval))
    {
        EG(exception) = NULL;

        zend_call_method_with_0_params(&object,ce,NULL,"initialize",&result);
    }

    // 開放
    zval_ptr_dtor(&func);
    zval_ptr_dtor(&argv[1]);
    zval_ptr_dtor(&retval);
    if(result != NULL)
    {
        zval_ptr_dtor(&result);
    }

    return SUCCESS;
}

// ｺﾝｽﾄﾗｸﾀ
PHP_METHOD(ce_AppException,__construct)
{
    zval *object,*message = NULL,*code = NULL,*previous = NULL,*options = NULL;
    int argc = ZEND_NUM_ARGS();

    // ｲﾝｽﾀﾝｽの取得
    object = getThis();

    // 引数の読み込み
    if(zend_parse_parameters_ex(
        ZEND_PARSE_PARAMS_QUIET,
        argc TSRMLS_CC,
        "|z!z!O!z!",
        &message,
        &code,
        &previous,
        ce_Exception,
        &options,
        ce_AppException) == FAILURE)
    {
        zend_error(
            E_RECOVERABLE_ERROR,
            "A wrong parameter type for _AppException([string $exception = NULL [, int $code = NULL [, Exception $previous = NULL [, int $options = NULL]]]])"
        );
    }

    zval *tmp,*argv[2],*func,*retval;

    // ｴﾗｰﾒｯｾｰｼﾞの初期化
    if(message == NULL || (Z_TYPE_P(message) != IS_STRING && Z_TYPE_P(message) != IS_ARRAY))
    {
        tmp = zend_read_property(
            ce_AppException,
            object,
            "defMessage",
            sizeof("defMessage") - 1,
            1 TSRMLS_CC);
        zend_update_property(
            ce_Exception,
            object,
            "message",
            sizeof("message") - 1,
            tmp TSRMLS_CC);
        //zval_ptr_dtor(&tmp);
    }else if(Z_TYPE_P(message) == IS_ARRAY){

        MAKE_STD_ZVAL(retval);
        MAKE_STD_ZVAL(func);
        ZVAL_STRING(func,"vsprintf",1);

        argv[0] = zend_read_property(
            ce_AppException,
            object,
            "messageTemplate",
            sizeof("messageTemplate") - 1,
            1 TSRMLS_CC);
        argv[1] = message;

        if((call_user_function(
            EG(function_table),NULL,func,retval,2,argv TSRMLS_CC) == FAILURE))
        {
            zend_error(
                E_ERROR,
                "A wrong parameter for _AppException([string $exception = NULL [, int $code = NULL [, Exception $previous = NULL [, int $options = NULL]]]])"
            );
        }

        zend_update_property(
            ce_Exception,
            object,
            "message",
            sizeof("message") - 1,
            retval TSRMLS_CC);

        zval_ptr_dtor(&func);
        zval_ptr_dtor(&retval);
        //zval_ptr_dtor(&argv[0]);
    }else{
        zend_update_property(
            ce_Exception,
            object,
            "message",
            sizeof("message") - 1,
            message TSRMLS_CC);
    }

    // ｴﾗｰｺｰﾄﾞの初期化
    if(code == NULL || Z_TYPE_P(code) != IS_LONG)
    {
        // silent引数は存在しないzval変数にｱｸｾｽした際に､ｴﾗｰを出すかどう
        // かの設定
        tmp = zend_read_property(
            ce_AppException,
            object,
            "defCode",
            sizeof("defCode") - 1,
            1 TSRMLS_CC);
        zend_update_property(
            ce_Exception,
            object,
            "code",
            sizeof("code") - 1,
            tmp TSRMLS_CC);
        //zval_ptr_dtor(&tmp);
    }else{
        zend_update_property(
            ce_Exception,
            object,
            "code",
            sizeof("code") - 1,
            code TSRMLS_CC);
    }

    // 以前に使われた例外の初期化
    if(previous != NULL)
    {
        // convertToAppExceptionﾒｿｯﾄﾞの呼び出し
        if(call_convert_to_app_exception(object,previous) == FAILURE)
        {
            zend_error(
                E_CORE_ERROR,
                "Failed to call function: call_convert_to_app_exception"
            );
        }
    }

    // ｼﾝﾎﾞﾙﾃｰﾌﾞﾙの再構築
    if(!EG(active_symbol_table))
    {
        zend_rebuild_symbol_table(TSRMLS_C);
    }

    // ﾌﾟﾛﾊﾟﾃｨの初期化
    zval *empty_array;

    MAKE_STD_ZVAL(empty_array);
    array_init(empty_array);

    zend_update_property(
        ce_AppException,
        object,
        "globalVarsSnapShot",
        sizeof("globalVarsSnapShot") - 1,
        empty_array TSRMLS_CC);
    zend_update_property(
        ce_AppException,
        object,
        "callerVarsSnapShot",
        sizeof("callerVarsSnapShot") - 1,
        empty_array TSRMLS_CC);

    zval_ptr_dtor(&empty_array);

    if(options == NULL || Z_TYPE_P(options) == IS_LONG)
    {

        int force;

        // ｸﾞﾛｰﾊﾞﾙ変数のｽﾅｯﾌﾟｼｮｯﾄ
        force =
            options == NULL ? -1 : Z_LVAL_P(options) & GLOBAL_VARS_SNAPSHOT_FLG;
        if(set_global_vars_snapshot(object,force) == FAILURE)
        {
            zend_error(
                E_CORE_ERROR,
                "Failed to call function: set_global_vars_snapshot"
            );
        }

        // ﾛｰｶﾙ変数のｽﾅｯﾌﾟｼｮｯﾄ
        force =
            options == NULL ? -1 : Z_LVAL_P(options) & CALLER_VARS_SNAPSHOT_FLG;
        if(set_caller_vars_snapshot(object,force) == FAILURE)
        {
            zend_error(
                E_CORE_ERROR,
                "Failed to call function: set_caller_vars_snapshot"
            );
        }
    }

    /*
    int i = 0;
    for(i = 1;i < 10000000;i++)
    {
        printf("\r%d",i);
        if(set_caller_vars_snapshot(object,force) == FAILURE)
        {
            zend_error(
                E_CORE_ERROR,
                "Failed to call function: set_caller_vars_snapshot"
            );
        }
    }*/


    // ﾃﾞﾊﾞｯｸﾞﾄﾚｰｽの保管
    /*
    if(set_debug_trace(object) == FAILURE)
    {
        zend_error(
            E_CORE_ERROR,
            "Failed to call function: set_debug_trace"
        );
    }*/

    // _initializeﾒｿｯﾄﾞの呼び出し
    if(call__initialize(object) == FAILURE)
    {
        zend_error(
            E_CORE_ERROR,
            "Failed to call function: call__initialize"
        );
    }

    // initializeﾒｿｯﾄﾞの呼び出し
    if(call_initialize(object) == FAILURE)
    {
        zend_error(
            E_CORE_ERROR,
            "Failed to call function: call_initialize"
        );
    }
}

// getGlobalVarsﾒｿｯﾄﾞ
PHP_METHOD(ce_AppException,getGlobalVars)
{
    zval *object,*globalVarsSnapShot;

    // ｲﾝｽﾀﾝｽの取得
    object = getThis();

    // ﾌﾟﾛﾊﾟﾃｨの読み込み
    globalVarsSnapShot = zend_read_property(
        ce_AppException,
        object,
        "globalVarsSnapShot",
        sizeof("globalVarsSnapShot") - 1,
        0 TSRMLS_CC);

    // 戻り値を返す
    *return_value = *globalVarsSnapShot;
    zval_copy_ctor(return_value);

    // 参照ｶｳﾝﾄを初期化
    INIT_PZVAL(return_value);
}

// getCallerVarsﾒｿｯﾄﾞ
PHP_METHOD(ce_AppException,getCallerVars)
{
    zval *object,*callerVarsSnapShot;

    // ｲﾝｽﾀﾝｽの取得
    object = getThis();

    // ﾌﾟﾛﾊﾟﾃｨの読み込み
    callerVarsSnapShot = zend_read_property(
        ce_AppException,
        object,
        "callerVarsSnapShot",
        sizeof("callerVarsSnapShot") - 1,
        0 TSRMLS_CC);

    // 戻り値を返す
    *return_value = *callerVarsSnapShot;
    zval_copy_ctor(return_value);

    // 参照ｶｳﾝﾄを初期化
    INIT_PZVAL(return_value);
}

/*
PHP_METHOD(ce_AppException,__destruct)
{
}
*/

/* {{{ arginfo */
ZEND_BEGIN_ARG_INFO_EX(arginfo__app_exception____construct,0,0,0)
    ZEND_ARG_INFO(0,message)
    ZEND_ARG_INFO(0,code)
    ZEND_ARG_INFO(0,previous)
    ZEND_ARG_INFO(0,options)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO(arginfo__app_exception_getGlobalVars,0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO(arginfo__app_exception_getCallerVars,0)
ZEND_END_ARG_INFO()
/* }}} */

static const zend_function_entry AppException_methods[] = {
    PHP_ME(
        ce_AppException,
        __construct,
        arginfo__app_exception____construct,
        ZEND_ACC_PUBLIC)
    PHP_ME(
        ce_AppException,
        getGlobalVars,
        arginfo__app_exception_getGlobalVars,
        ZEND_ACC_PUBLIC)
    PHP_ME(
        ce_AppException,
        getCallerVars,
        arginfo__app_exception_getCallerVars,
        ZEND_ACC_PUBLIC)
    PHP_FE_END
};

PHP_MINIT_FUNCTION(app_exception)
{
    zend_class_entry ce;

    // 定数の登録
    /*
    REGISTER_LONG_CONSTANT(
        "GLOBAL_VARS_SNAPSHOT",
        GLOBAL_VARS_SNAPSHOT_FLG,
        CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT(
        "CALLER_VARS_SNAPSHOT",
        CALLER_VARS_SNAPSHOT_FLG,
        CONST_CS | CONST_PERSISTENT);
    */

    // ｸﾗｽの初期化
    ce_Exception = zend_exception_get_default(TSRMLS_C);
    INIT_CLASS_ENTRY_EX(
        ce,"_AppException",strlen("_AppException"),AppException_methods);
    ce_AppException =
        zend_register_internal_class_ex(&ce,ce_Exception,NULL TSRMLS_CC);
    ce_AppException->create_object = ce_Exception->create_object;

    // ﾌﾟﾛﾊﾟﾃｨの初期化
    zend_declare_property_bool(
        ce_AppException,
        "enableGlobalVarsSnapShot",
        sizeof("enableGlobalVarsSnapShot") - 1,
        0,
        (ZEND_ACC_STATIC | ZEND_ACC_PUBLIC) TSRMLS_DC);
    zend_declare_property_bool(
        ce_AppException,
        "enableCallerVarsSnapShot",
        sizeof("enableCallerVarsSnapShot") - 1,
        1,
        (ZEND_ACC_STATIC | ZEND_ACC_PUBLIC) TSRMLS_DC);

    /*
    zend_declare_property_null(
        ce_AppException,
        "messageTemplate",
        sizeof("messageTemplate") - 1,
        ZEND_ACC_PROTECTED TSRMLS_CC);
    zend_declare_property_null(
        ce_AppException,
        "defMessage",
        sizeof("defMessage") - 1,
        ZEND_ACC_PROTECTED TSRMLS_CC);
    zend_declare_property_null(
        ce_AppException,
        "defCode",
        sizeof("defCode") - 1,
        ZEND_ACC_PROTECTED TSRMLS_CC);
    */
    zend_declare_property_string(
        ce_AppException,
        "messageTemplate",
        sizeof("messageTemplate") - 1,
        "",
        ZEND_ACC_PROTECTED TSRMLS_CC);
    zend_declare_property_string(
        ce_AppException,
        "defMessage",
        sizeof("defMessage") - 1,
        "",
        ZEND_ACC_PROTECTED TSRMLS_CC);
    zend_declare_property_long(
        ce_AppException,
        "defCode",
        sizeof("defCode") - 1,
        0,
        ZEND_ACC_PROTECTED TSRMLS_CC);

    zend_declare_property_null(
        ce_AppException,
        "globalVarsSnapShot",
        sizeof("globalVarsSnapShot") - 1,
        ZEND_ACC_PROTECTED TSRMLS_CC);
    zend_declare_property_null(
        ce_AppException,
        "callerVarsSnapShot",
        sizeof("callerVarsSnapShot") - 1,
        ZEND_ACC_PROTECTED TSRMLS_CC);

    /*
    zend_declare_property_null(
        ce_AppException,
        "callQueue",
        sizeof("callQueue") - 1,
        ZEND_ACC_PROTECTED TSRMLS_CC);
    */

    return SUCCESS;
}

/* }}} */
/* {{{ app_exception_module_entry
 */
zend_module_entry app_exception_module_entry = {
    STANDARD_MODULE_HEADER_EX,
    NULL,
    NULL,
    "_AppException",
    NULL,
    PHP_MINIT(app_exception),
    NULL,
    NULL,
    NULL,
    NULL,
    "0.1",
    STANDARD_MODULE_PROPERTIES
};
/* }}} */

#ifdef COMPILE_DL_APP_EXCEPTION
ZEND_GET_MODULE(app_exception)
#endif


/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4 fdm=marker
 * vim<600: noet sw=4 ts=4
 */
