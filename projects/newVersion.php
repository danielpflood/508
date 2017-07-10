<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/508/header.php');
function createNewVersion($project_id,$changes,$creator){
	$currentVersion = getCurrentVersionID($project_id);
	$newVersionNumber = $currentVersion+1;
	$datetime = date( 'Y-m-d H:i:s' );
	echo 'currentversion result= '.$currentVersion.'<br />';
	$newVersion = mysql_query("INSERT INTO `Version` (`versionNumber`, `projectID`, `createdBy`, `dateCreated`, `changes`) VALUES ('$newVersionNumber', '$project_id', '$creator', '$datetime', '$changes');");
	if($newVersion){
		$_SESSION['msg'].='Created new version. Version "'.($newVersionNumber).'.';
		$_SESSION['msg'].="\n";
	}
	else{
		//todo add error handling
		$_SESSION['msg'].='Error creating version "';
		$_SESSION['msg'].='$project_id,$changes,$creator ->'.$project_id.','.$changes.','.$creator."\n";
	}
}

  if(loggedIn()){
  	if(isset($_POST['projectID'])&&
  		isset($_POST['change_notes'])&&
  		 isset($_POST['creatorID'])){
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