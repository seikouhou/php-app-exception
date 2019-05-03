dnl $Id$
dnl config.m4 for extension app_exception

dnl Comments in this file start with the string 'dnl'.
dnl Remove where necessary. This file will not work
dnl without editing.

dnl If your extension references something external, use with:

dnl PHP_ARG_WITH(app_exception, for app_exception support,
dnl Make sure that the comment is aligned:
dnl [  --with-app_exception             Include app_exception support])

dnl Otherwise use enable:

PHP_ARG_ENABLE(app_exception, whether to enable app_exception support,
Make sure that the comment is aligned:
[  --enable-app_exception           Enable app_exception support])

if test "$PHP_APP_EXCEPTION" != "no"; then
  dnl Write more examples of tests here...

  dnl # --with-app_exception -> check with-path
  dnl SEARCH_PATH="/usr/local /usr"     # you might want to change this
  dnl SEARCH_FOR="/include/app_exception.h"  # you most likely want to change this
  dnl if test -r $PHP_APP_EXCEPTION/$SEARCH_FOR; then # path given as parameter
  dnl   APP_EXCEPTION_DIR=$PHP_APP_EXCEPTION
  dnl else # search default path list
  dnl   AC_MSG_CHECKING([for app_exception files in default path])
  dnl   for i in $SEARCH_PATH ; do
  dnl     if test -r $i/$SEARCH_FOR; then
  dnl       APP_EXCEPTION_DIR=$i
  dnl       AC_MSG_RESULT(found in $i)
  dnl     fi
  dnl   done
  dnl fi
  dnl
  dnl if test -z "$APP_EXCEPTION_DIR"; then
  dnl   AC_MSG_RESULT([not found])
  dnl   AC_MSG_ERROR([Please reinstall the app_exception distribution])
  dnl fi

  dnl # --with-app_exception -> add include path
  dnl PHP_ADD_INCLUDE($APP_EXCEPTION_DIR/include)

  dnl # --with-app_exception -> check for lib and symbol presence
  dnl LIBNAME=app_exception # you may want to change this
  dnl LIBSYMBOL=app_exception # you most likely want to change this 

  dnl PHP_CHECK_LIBRARY($LIBNAME,$LIBSYMBOL,
  dnl [
  dnl   PHP_ADD_LIBRARY_WITH_PATH($LIBNAME, $APP_EXCEPTION_DIR/$PHP_LIBDIR, APP_EXCEPTION_SHARED_LIBADD)
  dnl   AC_DEFINE(HAVE_APP_EXCEPTIONLIB,1,[ ])
  dnl ],[
  dnl   AC_MSG_ERROR([wrong app_exception lib version or lib not found])
  dnl ],[
  dnl   -L$APP_EXCEPTION_DIR/$PHP_LIBDIR -lm
  dnl ])
  dnl
  dnl PHP_SUBST(APP_EXCEPTION_SHARED_LIBADD)

  PHP_NEW_EXTENSION(app_exception, app_exception.c, $ext_shared)
fi
