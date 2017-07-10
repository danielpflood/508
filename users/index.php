<?php include('../header.php'); ?>
    
    <?php
  	if(loggedIn()){
      include('../loggedin.php');
      listUsers();
      ?>
      
      <?php
    	
	}
	else{
		 header("Location: /508");
	}
	?>
<?php include('../footer.php');