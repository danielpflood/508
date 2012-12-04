<?php 
include($_SERVER['DOCUMENT_ROOT'].'/508/header.php');
  if(loggedIn()){
    include($_SERVER['DOCUMENT_ROOT'].'/508/loggedin.php');
    ?>
    <h2>New Message</h2>
    <?php
    include('form.php');
  }
  else{
     header("Location: /508");
  }
include($_SERVER['DOCUMENT_ROOT'].'/508/footer.php');
?>