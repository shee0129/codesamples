<?php
include($_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php");
$page = new Web_Page(189);
 
 //echo '<script>console.log("HERE");</script>';
if (!empty($_FILES)) {
     
    $tempFile = $_FILES['file']['tmp_name'];          //3             
      
    $targetPath = "../headshots/";  //4
     
    $targetFile =  $targetPath. $_FILES['file']['name'];  //5
 
    move_uploaded_file($tempFile,$targetFile); //6
     
}

/*if (!empty($_FILES)) {
     
			if (isset($_FILES['imagefile']['tmp_name']) && $_FILES['imagefile']['tmp_name'] != "") {
				if (!copy ($_FILES['imagefile']['tmp_name'],"../headshots/" .$_FILES['imagefile']['name'])) {
					echo "<h3>There was a problem uploading the file to the server - please contact ".$page->webmaster."</h3>";
				} else {
					echo "<h3>File upload completed.</h3>";
				}
			}
			
			     
}*/
?> 