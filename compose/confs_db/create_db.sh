#!/bin/bash

WD="/docker-entrypoint-initdb.d/"
DB_FILE="cacti_db_test.gz"

MYSQL="mysql --user=root --password=$MYSQL_ROOT_PASSWORD"

cd $WD

echo "Creating database"
echo "DROP DATABASE IF EXISTS $DB_NAME; CREATE DATABASE $DB_NAME;" | $MYSQL
echo "Creating user"
echo "CREATE USER '$DB_USER'@'%' IDENTIFIED BY '$DB_PASSWORD';" | $MYSQL
sleep 1
zcat $DB_FILE | $MYSQL $DB_NAME
echo "Database created"
