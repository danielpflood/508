<?php 
include($_SERVER['DOCUMENT_ROOT'].'/508/header.php');
  if(loggedIn()){
    include($_SERVER['DOCUMENT_ROOT'].'/508/loggedin.php');
    $projID=$_GET['projID'];
    showProject($projID);
    showProjectVersions($projID);
    listProjectCollaborators($projID);
  }
  else{
     header("Location: /508");
  }
include($_SERVER['DOCUMENT_ROOT'].'/508/footer.php');
?>