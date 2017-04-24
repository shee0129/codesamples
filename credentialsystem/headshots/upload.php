<?php 
include($_SERVER['DOCUMENT_ROOT'] . "/include/db_connect.php");

/*
Server-side PHP file upload code for HTML5 File Drag & Drop demonstration
Featured on SitePoint.com
Developed by Craig Buckler (@craigbuckler) of OptimalWorks.net 
*/
$fn = (isset($_SERVER['HTTP_X_FILENAME']) ? $_SERVER['HTTP_X_FILENAME'] : false);

// form submit
	$id = $_POST['request_id'];
	
	
	
if ($fn) {

	
	// AJAX call
	file_put_contents(
		$fn,
		file_get_contents('php://input')
	);
	echo "$fn uploaded";


			$execute = array(); 
			$filesid = ""; 
		/*	$insertquery = $db->prepare("INSERT INTO files SET module='161',
						  active='1',
						  name='".stripslashes($name)."',  
						  size='".$_FILES['images']['size'][$f]."', 
						  type='".$_FILES['images']['type'][$f]."', 
						  label='headshot', 
						  timestamp=" . time() . ", 
						  user='photoRequest'");
		*/ 

			$insertquery = $db->prepare("INSERT INTO files SET module='161',
						  active='1',
						  name='".$fn."',  
						  size='test', 
						  type='test', 
						  label='headshot', 
						  timestamp=" . time() . ", 
						  user='photoRequest'");
		
				
			if (!$insertresult = $insertquery->execute($execute)) {
				$data = 'error'; 
				echo("<script>console.log('PHP: ".json_encode($data)."');</script>");
				echo("<script>console.log('PHP:ERROR');</script>");
				
			} else {
				//echo "<h3>Media was successfully inserted into the database.</h3>";
				$maxid = array();
				$maxid_q = "SELECT id, name 
							FROM files 
							ORDER BY id desc
							LIMIT 0,1";
				$maxid_r = $db->query($maxid_q); 
				$maxid = $maxid_r->fetch(PDO::FETCH_ASSOC);	 
				$filesid = $maxid['id'];
				
		/*		$updatequery = $db->prepare("UPDATE credentials_photo_request 
									SET headshot_file_ids = CONCAT(headshot_file_ids , ',', " . $filesid . ")" .
									" WHERE id = " . $id); 
			*/ 
			$execute2 = array(); 
					$updatequery = $db->prepare("UPDATE credentials_photo_request  
									SET headshot_file_ids = 'test2' " .
									" WHERE id = " . $id);
				$update = $updatequery->execute($execute2); 
							
			}

 
	
	exit();  

}
else {
 
	// form submit
	$files = $_FILES['fileselect'];

	foreach ($files['error'] as $id => $err) {
		if ($err == UPLOAD_ERR_OK) {
			$fn = $files['name'][$id];
			move_uploaded_file( 
				$files['tmp_name'][$id],
				 $fn
			);
			echo "<p>File $fn uploaded.</p>";
		}
	}

}

$db = NULL;
?>