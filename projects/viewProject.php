<?php 
include($_SERVER['DOCUMENT_ROOT'].'/508/header.php');
  if(loggedIn()){
    include($_SERVER['DOCUMENT_ROOT'].'/508/loggedin.php');
    $projID=$_GET['projID'];
    ?>
    <div id="content1">
      <?php showProject($projID); ?>
    </div>
    <div id="content2">
      <?php showProjectVersions($projID); ?>
    </div>
    <div id="content3">
      <?php listProjectCollaborators($projID); ?>
    </div>

    <?php
  }
  else{
     header("Location: /508");
  }
include($_SERVER['DOCUMENT_ROOT'].'/508/footer.php');
?>