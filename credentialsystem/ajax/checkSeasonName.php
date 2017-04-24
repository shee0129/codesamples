<?php 
include($_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php");
$page = new Web_Page(189);

if (isset($_GET["contactName"])) {
	
		$checkName_q = 'SELECT id FROM credentials_photo_request WHERE name = "'.$_GET["contactName"].'"';
		$checkName_r = $page->db->query($checkName_q);
		$checkName = $checkName_r->fetch(PDO::FETCH_ASSOC);
		
		
		if($checkName['id'] > 0)
		{
			echo $checkName['id'];
		}
		else
		{
			echo "0";
		}
	
	
} else if (isset($_GET["contactPhone"])) {
	
		$checkName_q = 'SELECT id FROM credentials_photo_request WHERE phone = "'.$_GET["contactPhone"].'"';
		$checkName_r = $page->db->query($checkName_q);
		$checkName = $checkName_r->fetch(PDO::FETCH_ASSOC);
		
		
		if($checkName['id'] > 0)
		{
			echo $checkName['id'];
		}
		else
		{
			echo "0";
		}
	
	
} else if (isset($_GET["contactEmail"])) {
	
		$checkName_q = 'SELECT id FROM credentials_photo_request WHERE email = "'.$_GET["contactEmail"].'"';
		$checkName_r = $page->db->query($checkName_q);
		$checkName = $checkName_r->fetch(PDO::FETCH_ASSOC);
		
		
		if($checkName['id'] > 0)
		{
			echo $checkName['id'];
		}
		else
		{
			echo "0";
		}
	
	
}

?>