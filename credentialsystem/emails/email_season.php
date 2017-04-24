<?php
$managersEmail_q = "SELECT username FROM credentials_managers WHERE sport_id = '161' AND email_flg = '1'";
$managersEmail_r = $page->db->query($managersEmail_q);
$managersEmail = $managersEmail_r->fetchAll(PDO::FETCH_ASSOC);		


$recipients_array = array();

foreach($managersEmail as $mE)
{
	$recipients = $mE["username"] . "@umn.edu"; 
	array_push($recipients_array,$recipients);
}

	array_push($recipients_array,"icaweb@umn.edu");	
	array_push($recipients_array,$_POST['contactEmail']);
		
$recipients = implode(",",$recipients_array);
			
$htmlcontent .= "<html><body style='font-family: 'Helvetica Neue', Helvetica,Arial,sans-serif;'>";
$htmlcontent .= "<table style='width: 600px; ' align='center'><tr>";
$htmlcontent .= "<td align='center' valign='middle'><img src='http://www.athletics.umn.edu/eventmanagement/icons/MIcon.jpeg' width='50px'/>";
$htmlcontent .= "</td><td align='center' valign='top'><h2>Gopher Athletics <br/>        		2015-16 Credential Request</h2>";
$htmlcontent .= "<h3>Season Working</h3>";
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
		//echo $dept_q;
		$dept_r = $page->db->query($dept_q);
		$dept = $dept_r->fetch(PDO::FETCH_ASSOC);

		$htmlcontent .= "<tr><td>Affiliation:</td><td>".$dept['name']."</td></tr></table>";
	}


$htmlcontent .= "<h3>Credentials Requested</h3>";
$htmlcontent .= "<table>";

	$credentialsEmail_q = "SELECT * FROM credential_details_2016 WHERE request_id = " . $request_id;
	$credentialsEmail_r = $page->db->query($credentialsEmail_q);
	$credentialsEmail = $credentialsEmail_r->fetchAll(PDO::FETCH_ASSOC);	 
	
	$maincount = 1;
	foreach($credentialsEmail as $cE)
	{	
		$htmlcontent .= "<tr><td>Request #</td><td>".$maincount."</td></tr>";
		$htmlcontent .= "<tr><td>Name:</td><td>".$cE['name']."</td></tr>";
		$htmlcontent .= "<tr><td>Postion:</td><td>".$cE['title']."</td></tr>";  
		
			switch ($cE['emp_type'])
			{
				 case "1": 
					$htmlcontent .= "<tr><td>Employee Type:</td><td>Staff</td></tr>";
					break;
				case "2": 
					$htmlcontent .= "<tr><td>Employee Type:</td><td>Event</td></tr>";
					break;					
			}
		
			switch ($cE['cred_loc'])
			{
				 case "1": 
					$htmlcontent .= "<tr><td>Credential Location:</td><td>All Facilities</td></tr>";
					break;
				case "2": 
					$htmlcontent .= "<tr><td>Credential Location:</td><td>TCF Bank Stadium</td></tr>";
					break;		
				case "3": 
					$htmlcontent .= "<tr><td>Credential Location:</td><td>Williams Arena / Sports Pavilion</td></tr>";
					break;	
				case "4": 
					$htmlcontent .= "<tr><td>Credential Location:</td><td>Mariucci Arena / Ridder Arena</td></tr>";
					break;	
				case "5": 
					$htmlcontent .= "<tr><td>Credential Location:</td><td>Outdoor (ELR, JSC, Siebert)</td></tr>";
					break;																			
			}
			
			if($cE['cred_loc'] == "1" || $cE['cred_loc'] == "2")
			{
				$markingsEmail = explode("|",$cE['markings']);
				$markingsEmailAll = "";
				
				$count = 0;
				foreach($markingsEmail as  $keys1 => $values1)
				{
					
					switch($values1)
					{
						case 'F': $markingsEmailAll .= "Field Access (F)";
								break;
						case 'P': $markingsEmailAll .= "Pregame/Postgame Field Access (P)";
								break;
						case 'E': $markingsEmailAll .= "Escort Privileges (E)";
								break;																
					}
					
					$count++;
					
					if($count < count($markingsEmail))
						$markingsEmailAll .= ",";
						
					
				}
				
				$htmlcontent .= "<tr><td>TCF Marking(s):</td><td>".$markingsEmailAll."</td></tr>";

				$ZonesEmail = explode("|",$cE['zones']);
				$zonesEmailAll = "";
				
				$count2 = 0;
				foreach($ZonesEmail as  $keys2 => $values2)
				{
					
					switch($values2)
					{

						case '0':  $zonesEmailAll .= "Zone 0: Home team locker Room"; break;
						case '1':  $zonesEmailAll .= "Zone 1: Field"; break;
						case '2':  $zonesEmailAll .= "Zone 2: Home team bench, recruiting room"; break;
						case '3':  $zonesEmailAll .= "Zone 3: DQ Club Room"; break;
						case '4':  $zonesEmailAll .= "Zone 4: Premium Areas (excluding DQ Club)"; break;
						case '5':  $zonesEmailAll .= "Zone 5: Visiting team bench, visiting team locker room"; break;
						case '6':  $zonesEmailAll .= "Zone 6: 600 level (non-premium areas)"; break;
						case '7':  $zonesEmailAll .= "Zone 7: Service level working areas "; break;
						case '8':  $zonesEmailAll .= "Zone 8: Marching band areas "; break;
																						
					}
					
					$count2++;
					
					if($count2 < count($ZonesEmail))
						$zonesEmailAll .= ",";
						
					
				}
		
				$htmlcontent .= "<tr><td>TCF Zones(s):</td><td>".$zonesEmailAll."</td></tr>";				
				
			}


		$htmlcontent .= "<tr><td colspan='2'><hr/></tr>";
		
		$maincount++;
	}
$htmlcontent .= "</table>";

if($_POST['notes'] != "")
{
	$htmlcontent .= "<h3>Request Notes:</h3>";
	$htmlcontent .= "<p>".$_POST['notes']."</p>";
}

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

//$res2 = $requestermail->send(array("icaweb@umn.edu"));
			
		//	if($res2 != false)
		//		echo "EMAIL SENT";						
				  
				  
?>