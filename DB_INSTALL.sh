#!/bin/bash
echo "Installing 508 Database..."
MYSQL=`which mysql`
dbname="508devDB"
dbuser="508"
dbpass="508devDBpass"
Q1="CREATE DATABASE IF NOT EXISTS \`$dbname\`;"
Q2="GRANT USAGE ON *.* TO \`$dbuser\`@localhost IDENTIFIED BY '$dbpass';"
Q3="GRANT ALL PRIVILEGES ON \`$dbname\`.* TO \`$dbuser\`@localhost;"
Q4="FLUSH PRIVILEGES;"
SQL="${Q1} ${Q2} ${Q3} ${Q4}"
#echo "$SQL"
$MYSQL -u root -p -e "$SQL"
echo "starting db sql import 1..."
$MYSQL -u root -p < collab.sql
echo "starting db sql import 2..."
#$MYSQL -u root -p < addedusername.sql
$MYSQL -u root -p < username.sql
echo "Finished installed 508 DB"