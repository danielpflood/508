<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/508/header.php');
  if(loggedIn()){
  	if(isset($_POST['projectID'])&&
  		isset($_POST['change_notes'])&&
  		 isset($_POST['creatorID'])){//$project_id,$changes,$creator
		//$dump = var_dump($_POST);
		//print_r($dump);
		createNewVersion($_POST['projectID'],$_POST['change_notes'],$_POST['creatorID']);
		header("Location: /508/projects/viewProject.php?projID=".$_POST['projectID']."");
  	}
  	else{
  		include($_SERVER['DOCUMENT_ROOT'].'/508/loggedin.php');
  		
	    echo '<h2>Create new version</h2>';
	    echo '<br />';
	    if(isset($_GET['projID'])){
		    if(isOwner($_GET['projID'],getCurrentUserID())||isCollaborator($_GET['projID'],getCurrentUserID())){//current user owns the project
				echo '
		    	 <form id="newversion" name="newversion" method="post" action="';
		    	 echo curPageURL();
		    	 echo '">
					Change notes <input name="change_notes" type="textarea" id="change_notse" value=""/><br />
				<input name="createversion" type="submit" id="createversion" value="Create Version" />
				<input name="projectID" type="hidden" id="projectID" value="'.$_GET['projID'].'" />
				<input name="creatorID" type="hidden" id="creatorID" value="'.getCurrentUserID().'" />
				</form>';
		    }
		    else{//doesnt own this project
		    	echo '<p>You are not a collaborator on this project.</p>';
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