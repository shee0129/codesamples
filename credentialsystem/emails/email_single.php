<?php
$managersEmail_q = "SELECT username FROM credentials_managers WHERE sport_id = '".$_POST['sport']."' AND email_flg = '1'";
$managersEmail_r = $page->db->query($managersEmail_q);
$managersEmail = $managersEmail_r->fetchAll(PDO::FETCH_ASSOC);		


$recipients_array = array();

foreach($managersEmail as $mE)
{
	$recipients = $mE["username"] . "@umn.edu"; 
	array_push($recipients_array,$recipients);
}
	//array_push($recipients_array,"rhie0012@umn.edu");
	array_push($recipients_array,"icaweb@umn.edu");
	array_push($recipients_array,$_POST['contactEmail']);
		
$recipients = implode(",",$recipients_array);
			
$htmlcontent .= "<html><body style='font-family: 'Helvetica Neue', Helvetica,Arial,sans-serif;'>";
$htmlcontent .= "<table style='width: 600px; ' align='center'><tr>";
$htmlcontent .= "<td align='center' valign='middle'><img src='http://www.athletics.umn.edu/eventmanagement/icons/MIcon.jpeg' width='50px'/>";
$htmlcontent .= "</td><td align='center' valign='top'><h2>Gopher Athletics <br/>        		2015-16 Credential Request</h2>";
$htmlcontent .= "<h3>Single Game</h3>";
$htmlcontent .= "</td></tr><tr><td colspan='2'>";
$htmlcontent .= "<p style='padding-top:15px;'><strong>Your credential request has been submitted. Full details are below. Keep this email for your records.</strong></p>";
$htmlcontent .= "<table style='margin-bottom: 15px;'>";
$htmlcontent .= "<tr><td>Requester:</td><td>".$_POST['contactName']."</td></tr>";
$htmlcontent .= "<tr><td>Phone:</td><td>".$_POST['contactPhone']."</td></tr>";
$htmlcontent .= "<tr><td>Email:</td>".$_POST['contactEmail']."<td></td></tr>";



	if($_POST['affiliation'] == '999')
	{
		$htmlcontent .= "<tr><td>Affiliation:</td><td>".$_POST['otherAffiliation']."</td></tr></table>";	
	}
	else
	{
		$dept_q = "SELECT name FROM modules WHERE id = '".$_POST['affiliation']."'";
		//echo "<br/>". $dept_q; 
		$dept_r = $page->db->query($dept_q);
		$dept = $dept_r->fetch(PDO::FETCH_ASSOC);				

		$htmlcontent .= "<tr><td>Affiliation:</td><td>".$dept['name']."</td></tr></table>";					
	}

$htmlcontent .= "<h3>Games Requested</h3>";
$htmlcontent .= "<table>";

	$eventsEmail_q = "SELECT event, event_startdate 
							FROM credential_calendar_2016 cc
							JOIN calendar c 
							ON cc.calendar_id = c.id
							WHERE request_id = " . $request_id;					  
	$eventsEmail_r = $page->db->query($eventsEmail_q);
	$eventsEmail = $eventsEmail_r->fetchAll(PDO::FETCH_ASSOC);	 
	
	foreach($eventsEmail as $eE)
	{
		$htmlcontent .= "<tr><td>".date("l, F j, Y", $eE["event_startdate"])."</td><td>".$eE['event']."</td></tr>";		
		$htmlcontent .= "<tr><td colspan='2'><hr/></tr>";		
	}
	
$htmlcontent .= "<h3>Credentials Requested</h3>";
$htmlcontent .= "<table>";

	$credentialsEmail_q = "SELECT * FROM credential_details_2016 WHERE request_id = " . $request_id;
	//echo "<br/>". $credentialsEmail_q; 
	$credentialsEmail_r = $page->db->query($credentialsEmail_q);
	$credentialsEmail = $credentialsEmail_r->fetchAll(PDO::FETCH_ASSOC);	 
	
	foreach($credentialsEmail as $cE)
	{	

			switch ($cE['type'])
			{
				case "2" : $htmlcontent .= "<tr><td>Type:</td><td>Photo</td></tr>"; break;
				case "3" : $htmlcontent .= "<tr><td>Type:</td><td>Marching Band</td></tr>"; break;                                 
				case "4" : $htmlcontent .= "<tr><td>Type:</td><td>Football Family</td></tr>"; break;
				case "5" : $htmlcontent .= "<tr><td>Type:</td><td>Team VIP</td></tr>"; break;    
				case "6" : $htmlcontent .= "<tr><td>Type:</td><td>Premium Guest</td></tr>"; break;
				case "7" : $htmlcontent .= "<tr><td>Type:</td><td>DQ Club Guest</td></tr>"; break;
				case "8" : $htmlcontent .= "<tr><td>Type:</td><td>Game Services</td></tr>"; break;
				case "9" : $htmlcontent .= "<tr><td>Type:</td><td>Vendor/Contractor</td></tr>"; break;
				case "10" : $htmlcontent .= "<tr><td>Type:</td><td>Event Production</td></tr>"; break;
				case "11" : $htmlcontent .= "<tr><td>Type:</td><td>Field VIP</td></tr>"; break;
				case "12" : $htmlcontent .= "<tr><td>Type:</td><td>Recruit</td></tr>"; break;
				case "13" : $htmlcontent .= "<tr><td>Type:</td><td>Pregame Guest</td></tr>"; break;
				case "14" : $htmlcontent .= "<tr><td>Type:</td><td>Other</td></tr>"; break;	
				case "15" : $htmlcontent .= "<tr><td>Type:</td><td>All Access</td></tr>"; break;	
				case "16" : $htmlcontent .= "<tr><td>Type:</td><td>Promotions</td></tr>"; break;	
				case "17" : $htmlcontent .= "<tr><td>Type:</td><td>Television</td></tr>"; break;	
				case "18" : $htmlcontent .= "<tr><td>Type:</td><td>Game Services</td></tr>"; break;	
				case "19" : $htmlcontent .= "<tr><td>Type:</td><td>Special Guest</td></tr>"; break;			
			}


		$htmlcontent .= "<tr><td>Name:</td><td>".$cE['name']."</td></tr>";  
		$htmlcontent .= "<tr><td>Affiliation:</td><td>".$cE['affiliation']."</td></tr>";  		
		


		$htmlcontent .= "<tr><td colspan='2'><hr/></tr>";

	}
$htmlcontent .= "</table>";
$htmlcontent .= "<p style='padding-top:15px;'>Please stay tuned for future request updates.</p> ";
$htmlcontent .= "<p>Thank you for your request. Go Gophers!</p>";
$htmlcontent .= "</td></tr></table></body></html>";

$requestermail = new mail_htmlMimeMail5();    
			  
			// Set the sender address     
			$requestermail->setFrom("icaweb@umn.edu");  
			 
			// Set the reply-to address
			$requestermail->setReturnPath("icaweb@umn.edu");
			
			// Set the mail subject 
			$requestermail->setSubject("Gopher Athletics Credential System - Request Submitted");
			
			// Set the mail body text
			//$requestermail->setText($requestertextcontent);
			
			// Set the HTML part of the email
			$requestermail->setHTML($htmlcontent);
			
			//$requesterEmail = $diam['req_email'];
			// Send the email! 	
			$res2 = $requestermail->send(array($recipients));

//				$res2 = $requestermail->send(array("icaweb@umn.edu"));
			
		//	if($res2 != false)
		//		echo "EMAIL SENT";						
				  
				  
?>