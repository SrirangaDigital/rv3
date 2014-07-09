#!/bin/sh

host="localhost"
db="rv"
usr="root"
pwd="mysql"

echo "drop database rv; create database rv charset utf8 collate utf8_general_ci;" | /usr/bin/mysql -uroot -pmysql

perl insert_author.pl $host $db $usr $pwd
perl insert_articles.pl $host $db $usr $pwd
perl ocr.pl $host $db $usr $pwd
perl searchtable.pl $host $db $usr $pwd
