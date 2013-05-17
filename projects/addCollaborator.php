<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/508/header.php');
  if(loggedIn()){
  	if(isset($_POST['collab_user'])){
		//$dump = var_dump($_POST);
		//print_r($dump);
		$users = split(",", trim($_POST['collab_user']));
		foreach ($users as $tempuser) {
			addUserToProject($_POST['projectID'], getUserID($tempuser));
		}
		header("Location: /508/projects");
  	}
  	else{
  		include($_SERVER['DOCUMENT_ROOT'].'/508/loggedin.php');
  		
	    echo '<h2>Add a Collaborator</h2>';
	    echo '<br />';
	    if(isset($_GET['projID'])){
	    	loadAutoCompleteUser();
		    if(isOwner($_GET['projID'],getCurrentUserID())){//current user owns the project
				echo '
		    	 <form id="newcollab" name="newcollab" method="post" action="';
		    	 echo curPageURL();
		    	 echo '">
					Collaborator\'s Username <input name="collab_user" type="text" id="collab_user" class="userfield" value="" size="42" /><br />
				<input name="addcollaborator" type="submit" id="addcollaborator" value="Add Collaborator" />
				<input name="projectID" type="hidden" id="projectID" value="'.$_GET['projID'].'" />
				</form>';
		    }
		    else{//doesnt own this project
		    	echo '<p>You don\'t own this project...</p>';
		    }
		}
		else{
			echo '<p>No project selected...</p>';
		}
  	}
  }
  else{
     header("Location: /508");
  }
include($_SERVER['DOCUMENT_ROOT'].'/508/footer.php');
?>