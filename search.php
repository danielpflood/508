<?php
if (isset($_POST['search'])) {
	if(trim($_POST['search'])!=""){
	    include_once($_SERVER['DOCUMENT_ROOT'].'/508/func.php');
	    $word = mysql_real_escape_string($_POST['search']);
	    $word = htmlentities($word);
<<<<<<< HEAD
	    $sql = "SELECT `userID`, `email` FROM `User` WHERE `email` LIKE '%" . $word . "%' ORDER BY `email` LIMIT 10";
	    $res = mysql_query($sql);
	    $end_result = '';
	    while($row = mysql_fetch_array($res)){
		    $result         = $row['email'];
=======
	    $sql = "SELECT `userID`, `username` FROM `User` WHERE `username` LIKE '%" . $word . "%' ORDER BY `username` LIMIT 10";
	    $res = mysql_query($sql);
	    $end_result = '';
	    while($row = mysql_fetch_array($res)){
		    $result         = $row['username'];
>>>>>>> 980121d2575feff76c7cb95b4eba7b6459894ef5
	        $bold           = '<b>' . $word . '</b>';    
	        $end_result     .= '<li>' . str_ireplace($word, $bold, $result) . '</li>';  
		} 
		if(trim($end_result)!=""){
			echo $end_result;
		}
		else{
			echo 'No results.';
		}
	}
	else{
		echo 'Please enter your search first.';
	}
}
?>