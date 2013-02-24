<?php 
include($_SERVER['DOCUMENT_ROOT'].'/508/header.php');
  if(loggedIn()){
    include($_SERVER['DOCUMENT_ROOT'].'/508/loggedin.php');
    echo '<h2>Viewing Project</h2>';
    showProject($_GET['projID']);
  }
  else{
     header("Location: /508");
  }
include($_SERVER['DOCUMENT_ROOT'].'/508/footer.php');
?>