<?php 
include($_SERVER['DOCUMENT_ROOT'].'/508/header.php');
  if(loggedIn()){
    include($_SERVER['DOCUMENT_ROOT'].'/508/loggedin.php');
    ?>
    <h2>New Project</h2>
    <form id="newproj" name="newpeoj" method="post" action="newproject.php">
      Project Name <input name="project_name" type="text" id="project_name" value="" size="42" /><br />
    <input name="createproject" type="submit" id="createproject" value="create project" />
    </form>
<?php
  }
  else{
     header("Location: /508");
  }
include($_SERVER['DOCUMENT_ROOT'].'/508/footer.php');
?>