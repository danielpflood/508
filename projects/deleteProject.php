<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/508/func.php');
//TODO:add security measures!!!!!!!
if (isset($_POST['deleteID'])) {
	deleteProject(intval($_POST['deleteID']));
}
else{
	$_SESSION['msg'].='Please select a project to be deleted.';
	header("Location: /508/projects");
}
?>