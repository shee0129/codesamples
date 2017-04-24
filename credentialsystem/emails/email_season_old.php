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
				array_push($recipients_array,$_POST['email']);	
					
			$recipients = implode(",",$recipients_array);
		
			
			$htmlcontent = '<html><head></head><body> <style> h1{font-weight: bold; font-size:14px; color: #761e2e;} p{	font-size: 12px;} a{color: #761e2e;}</style>';
			$htmlcontent .= '<table align="center" style="width:80%;">	<tr>  	<td width="60"><img src="http://www.athletics.umn.edu/eventmanagement/icons/MIcon.jpeg" width="50px"/>';
			$htmlcontent .= '</td> <td> 	<h1>Golden Gopher Athletics Credential System <br/>Non-Media <br/>Season Working     </h1> </td> </tr> <tr> <td colspan="2">';
			  
			$htmlcontent .= ' <h2>Season Working Credential Request</h2> 
							<p style="padding-top:15px;"><strong>Your credential request has been submitted. Full details are below. Keep your Confirmation ID to look up request status.</strong></p>';
			$htmlcontent .= '<table>';
			$htmlcontent .= '<tr><td><strong>Confirmation ID:</strong></td><td><strong>'.$confirmation.'</strong></td></tr>';       		
			$htmlcontent .= '<tr><td>Requester:</td><td>'.$_POST['name'].'</td></tr>';
			$htmlcontent .= '<tr><td>Request Email:</td><td>'.$_POST['email'].'</td></tr>';
			$htmlcontent .= '<tr><td>Request Phone:</td><td>'.$_POST['phone'].'</td></tr>';
			$htmlcontent .= '<tr><td>Requester Notes:</td><td>'.$_POST['notes'].'</td></tr>';			
			$htmlcontent .= '<tr><td style="line-height:24px;"> Number of Credentials Requested:</td><td>'.($count).'</td></tr>';
			$htmlcontent .= '</table></td></tr>'; 	  
			  
			$htmlcontent .= '<tr><td colspan="2"> <p style="padding-top:15px;"><strong>Credential Details:</strong></p>';
			  
			$htmlcontent .= '<table align="center" width="100%">';
			$htmlcontent .= '<tr style="font-weight: bold;"><td>Name</td><td>Employee Type</td><td>Location</td><td>Marking (if application)</td><td>Zones (if applicable)</td></tr>';
			$htmlcontent .= $emailAdd;
			$htmlcontent .= '</table></td></tr>';
			 
			if($headshots != "")
				$htmlcontent .= '<tr><td colspan="2"><strong>Headshots uploaded:</strong>'.$headshots.'</td></tr>';
				
			$htmlcontent .= '<tr><td colspan="2"> <p><a href="http://www.athletics.umn.edu/credentials/lookUpSeason.php?confirmationNum='.$confirmation.'">See full details here along with status updates here.</a></p></td></tr></table></body></html>'; 
					
			
			
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
			//$res2 = $requestermail->send(array($recipients]));	
			
			$res2 = $requestermail->send(array($recipients));		
			
		//	$res2 = $requestermail->send(array("icaweb@umn.edu"));		
			
		//	if($res2 != false)
		//		echo "EMAIL SENT";						
		

?>