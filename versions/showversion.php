<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/508/func.php');
if(isset($_POST['version_id'])&&$_POST['version_id']==""||!isset($_POST['version_id'])){
	$_SESSION['msg']='Missing version id...';
}
else{
	showVersion($_POST['version_id']);
}
?>