<?php
if (isset($_POST['search'])) {
	if(trim($_POST['search'])!=""){
	    include_once($_SERVER['DOCUMENT_ROOT'].'/508/func.php');
	    $word = mysql_real_escape_string($_POST['search']);
	    $word = htmlentities($word);
	    $sql = "SELECT `userID`, `username` FROM `User` WHERE `username` LIKE '%" . $word . "%' ORDER BY `username` LIMIT 10";
	    $res = mysql_query($sql);
	    $end_result = '';
	    while($row = mysql_fetch_array($res)){
		    $result         = $row['username'];
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