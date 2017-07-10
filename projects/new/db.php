<?php
$mysql_hostname = "localhost";
$mysql_user = "508";
$mysql_password = "508devDBpass";
$mysql_database = "508devDB";
$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Opps some thing went wrong with connection");
mysql_select_db($mysql_database, $bd) or die("Opps some thing went wrong! can't select db!");

?>