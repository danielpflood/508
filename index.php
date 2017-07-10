<?php include('header.php'); ?>
    
    <?php
  	if(loggedIn()){
      include('loggedin.php');
      ?>
      <h4>You are home.</h4>
      <p>Site under construction.</p>
      <?php
    	
	}
	else{
		include('form.php');
	}
	?>
<?php include('footer.php');