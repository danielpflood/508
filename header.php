<?php include_once('func.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
  	<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
    <title>508</title>
<<<<<<< HEAD
    <?php loadStuff(); ?>
  </head>
  <body>
<h1><a href="/508" style="text-decoration: none; color:black;">Molasses Music</a></h1>
<?php getAppMessage(); ?>
=======
    <?php 
    function loadStuff(){
		echo '<script language="javascript" type="text/javascript" src="/508/js/jquery-1.8.3.min.js"></script>'."\n";
		//echo '<script language="javascript" type="text/javascript" src="/508/js/bootstrap.min.js"></script>'."\n";
		//echo '<script language="javascript" type="text/javascript" src="/508/js/jquery.autoSuggest.js"></script>'."\n";
		echo '<link href="/508/css/reset.css" rel="stylesheet">'."\n";
		echo '<link href="/508/css/style.css" rel="stylesheet">'."\n";
		echo '<link href="/508/css/jquery.autocomplete.css" rel="stylesheet">'."\n";
		echo '<script src="/508/js/jquery.autocomplete.js"></script> '."\n";
		echo '<link href="/508/css/bootstrap.css" rel="stylesheet">'."\n";
	}
	loadStuff();
?>
  </head>
  <body>
	<div id="content" class="transparent">
<h1><a href="/508">Molasses Music</a></h1>
<?php 
function getAppMessage(){
	if (isset($_SESSION['msg']) && $_SESSION['msg'] != "") {
		echo '<p style="color:green; font-size:small;">'.$_SESSION['msg'].'</p>';
		unset($_SESSION['msg']);
	}
}	
getAppMessage(); 
?>
>>>>>>> 980121d2575feff76c7cb95b4eba7b6459894ef5
