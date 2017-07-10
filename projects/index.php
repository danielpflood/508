<?php 
include($_SERVER['DOCUMENT_ROOT'].'/508/header.php');
    
  	if(loggedIn()){
      include($_SERVER['DOCUMENT_ROOT'].'/508/loggedin.php');
<<<<<<< HEAD
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
=======
      	function listOwnedProjects(){
			$userID = getCurrentUserID();
			$getProjects = mysql_query("SELECT * FROM `Project` WHERE `projectID` IN (SELECT DISTINCT `projectID` FROM `UserOwnsProject` WHERE `userId` = '$userID')");
			$i=0;
			while($row = mysql_fetch_array($getProjects)){
				$i++;
				if($i==1){	echo '<h3>Projects you own:</h3><ul class="project_list">';}
				echo '<li>
					<a href="'.curPageURL().'viewProject.php?projID='.$row['projectID'].'" style="font-size:16px; text-decoration:none; padding-left:10px;">'.$row['name'].'</a>  <span style="float:right; font-size:small; color:grey;">'.$row['dateCreated'].'</span>
					&nbsp;&nbsp;
					<a href="'.curPageURL().'addCollaborator.php?projID='.$row['projectID'].'" class="btn" style="font-size:12px; text-decoration:none; padding:0px;padding-left:10px; padding-right:10px;">Add Collaborator</a>
					<form style="display:inline;" id="owned-projects" method="post" action="deleteProject.php"><button name="deleteID" class="del_proj" style="font-size:12px; text-decoration:none; padding:0px;padding-left:10px; padding-right:10px;" value="'.$row['projectID'].'">Delete</button></form></li>';
			}
			echo '</ul>';
		}
		listOwnedProjects();
		function listCollabProjects(){
			$userID = getCurrentUserID();
			$getProjects = mysql_query("SELECT * FROM `Project` WHERE `projectID` IN (SELECT DISTINCT `projectID` FROM `ProjectHasCollaborator` WHERE `userId` = '$userID')");
			$i=0;
			while($row = mysql_fetch_array($getProjects)){
				$i++;
				if($i==1){echo '<h3>Collab Projects:</h3><ul>';}
				echo '<li><a href="'.curPageURL().'viewProject.php?projID='.$row['projectID'].'" style="font-size:16px; text-decoration:none; padding-left:10px;">'.$row['name'].'</a>  <span style="float:right; font-size:small; color:grey;">'.$row['dateCreated'].'</span></li>';
			}
			echo '</ul>';
		}
		listCollabProjects();
      echo '<br /><a href="/508/projects/new">New Project</a>';
	}
	else{
		$_SESSION['msg']="Must be logged in to access that page.";
		 header("Location: /508");
	}
include($_SERVER['DOCUMENT_ROOT'].'/508/footer.php');
?> 
>>>>>>> 980121d2575feff76c7cb95b4eba7b6459894ef5
