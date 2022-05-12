#!/bin/sh

cp /etc/mysql/conf.d/source/* /etc/mysql/conf.d/

/entrypoint.sh mysqld --default-authentication-plugin=mysql_native_password
