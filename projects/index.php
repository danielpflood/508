<?php 
include($_SERVER['DOCUMENT_ROOT'].'/508/header.php');
    
  	if(loggedIn()){
      include($_SERVER['DOCUMENT_ROOT'].'/508/loggedin.php');
      listOwnedProjects();
      ?>
      <a href="/508/projects/new">New Project</a>
      <?php
	}
	else{
		 header("Location: /508");
	}
include($_SERVER['DOCUMENT_ROOT'].'/508/footer.php');
?>