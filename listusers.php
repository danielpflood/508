<?php
include_once('db.php');
$q = strtolower($_GET["q"]);
if (!$q) return;

$rsd = mysql_query("SELECT * FROM `User` WHERE `username` LIKE '%$q%'");
while($rs = mysql_fetch_array($rsd)) {
        $uname = $rs['username'];
        echo "$uname\n";
}

/*
$input = strtolower($_GET["q"]);

$data = array();
// query your DataBase here looking for a match to $input
$query = mysql_query("SELECT * FROM `User` WHERE `username` LIKE '%$input%'");
$sugg = array();
while ($row = mysql_fetch_assoc($query)) {
	array_push($sugg, $row['username']);
}
$data['query'] = $input;
$data['suggestions'] = $sugg;
header("Content-type: application/json");
echo json_encode($data);*/
?>