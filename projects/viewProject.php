<?php 
include($_SERVER['DOCUMENT_ROOT'].'/508/header.php');
  if(loggedIn()){
    include($_SERVER['DOCUMENT_ROOT'].'/508/loggedin.php');
    $projID=$_GET['projID'];
    ?>
    <div id="content1">
      <?php
      function showProject($id){
        if (isset($id) && $id != "") {
          $tempName = getProjectName($id);
            $sql = mysql_query("SELECT * FROM `Project` WHERE `projectID` = '$id';");
          echo '<h3>'.getProjectName($id).'</h3>';
          if($sql){
            $row = mysql_fetch_row($sql);
            $row2 = mysql_fetch_row(mysql_query("SELECT `userId` FROM `UserOwnsProject` WHERE `projectID` = '$id';"));
            $owner = $row2[0];
            if(getCurrentUserID()==$owner){
              echo '<p>You own this project</p>';
            }
          }

          //Get current version.
          $sql = "SELECT * FROM `Version` WHERE `projectID` = ".$id." ORDER BY `versionNumber` DESC LIMIT 0, 30 ";
          $getVersions= mysql_query($sql);
          $row = mysql_fetch_array($getVersions);
          $versionID = $row['versionID'];

          //Get all file ids from current version.
          $sql = "SELECT * FROM `VersionHasFile` WHERE `versionID` = ".$versionID;
          $getFileIds= mysql_query($sql);
          $theFiles = array();
          while($row = mysql_fetch_array($getFileIds)){
            array_push($theFiles, $row['fileID']);
          }
          echo '<h2>Files</h2>';

          //Loop through files displayting info.
          foreach($theFiles as $fileID){
            $sql = "SELECT * FROM `File` WHERE `fileID` = ".$fileID;
            $getFiles= mysql_query($sql);
            $row = mysql_fetch_array($getFiles);
            echo '
              <p><a href="'.dirname($_SERVER['PHP_SELF']).$row['filePath'].$row['fileName'].'">'.$row['fileName'].'</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row['uploadDate'].'</p>';
          }
        }
      }
      showProject($projID); ?>
    </div>
    <div id="content2">
      <?php 
        function getUserUsername($id){
          if (isset($id) && $id != "") {
            $getUserUsername = mysql_query("SELECT DISTINCT `username` FROM `User` WHERE `userID` = '$id'");
          $row = mysql_fetch_array($getUserUsername);
          if(isset($row)){
            $userUsername = $row['username'];
            return $userUsername;
          }
          }
      }
      function showProjectVersions($project_id){
        if (isset($project_id) && $project_id != "") {
          $tempName = getProjectName($project_id);
          $sql = mysql_query("SELECT * FROM `Project` WHERE `projectID` = '$project_id';");
          echo '<h3>Versions</h3>';
          $getVersions = mysql_query("SELECT * FROM `Version` WHERE `projectID` = '$project_id';");
          echo '<table>';
          while($row = mysql_fetch_array($getVersions)){
            $createdBy = getUserUsername($row['createdBy']);

            //<td>'.$row['versionID'].'</td>
            echo '<tr>
                    <td><h4>Version '.$row['versionNumber'].'</h4></td>
                    <td>Created by '.$createdBy.'.</td>
                    <td>'.$row['dateCreated'].'</td>
                  </tr>
                  <tr>
                    <td>'.$row['changes'].'</td>
                  </tr>';
          }
          echo '</table><a href="/508/projects/newVersion.php?projID='.$project_id.'" class="btn" style="font-size:16px; text-decoration:none; padding-left:10px;">Create New Version</a>';
          }
      }
      showProjectVersions($projID); 
      ?>
    </div>
    <div id="content3">
      <?php
        function listProjectCollaborators($project_id){
          $userID = getCurrentUserID();
          $getProjects = mysql_query("SELECT * FROM `ProjectHasCollaborator` WHERE `projectID` = $project_id");
          $i=0;
          while($row = mysql_fetch_array($getProjects)){
            $i++;
            if($i==1){echo '<h3>Collaborators</h3><ul>';}
            echo '<li>'.getUserUsername($row['userID']).'</li>';
          }
          echo '</ul>';
          echo '<a href="/508/projects/addCollaborator.php?projID='.$project_id.'" class="btn" style="font-size:16px; text-decoration:none; padding-left:10px;">Add Collaborator</a>';
        }
        listProjectCollaborators($projID); 
       ?>
    </div>

    <?php
  }
  else{
     header("Location: /508");
  }
include($_SERVER['DOCUMENT_ROOT'].'/508/footer.php');
?>