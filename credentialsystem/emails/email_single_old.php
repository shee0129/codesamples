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
				array_push($recipients_array,"icaweb@umn.edu");	
				array_push($recipients_array,$_POST['email']);	
					 
			$recipients = implode(",",$recipients_array);
 
			$htmlcontent = '<html><head></head><body> <style> h1{font-weight: bold; font-size:14px; color: #761e2e;} p{	font-size: 12px;} a{color: #761e2e;}</style>';
			$htmlcontent .= '<table align="center" style="width:70%;">	<tr>  	<td width="60"><img src="http://www.athletics.umn.edu/eventmanagement/icons/MIcon.jpeg" width="50px"/>';
			$htmlcontent .= '</td> <td> 	<h1>Golden Gopher Athletics Credential System <br/>Non-Media <br/>Single Game   </h1> </td> </tr> <tr> <td colspan="2">';
			  
			$htmlcontent .= ' <p style="padding-top:15px;"><strong>Your credential request has been submitted. Full details are below. Keep your Confirmation ID to look up request status.</strong></p>';
			$htmlcontent .= '<table>';
			$htmlcontent .= '<tr><td><strong>Confirmation ID:</strong></td><td><strong>'.$confirmation.'</strong></td></tr>';       		
			$htmlcontent .= '<tr><td>Requester:</td><td>'.$_POST['name'].'</td></tr>';
			$htmlcontent .= '<tr><td>Request Email:</td><td>'.$_POST['email'].'</td></tr>';
			$htmlcontent .= '<tr><td>Request Phone:</td><td>'.$_POST['phone'].'</td></tr>';
			$htmlcontent .= '<tr><td>Requester Notes:</td><td>'.$_POST['notes'].'</td></tr>';			
			//$htmlcontent .= '<tr><td style="line-height:24px;"> Number of Credentials Requested:</td><td></td></tr>';
			$htmlcontent .= '</table></td></tr>';
			
			$htmlcontent .= '<tr><td colspan="2" style="padding-top:15px;">';
			$htmlcontent .= '<table > <tr><td style="vertical-align: top;"> <strong>Game(s) Requested:</strong></p></td> <td>';
			$htmlcontent .= $gamesEmail;
			$htmlcontent .= '</td></tr> </table>';
			$htmlcontent .= '</td>';
			$htmlcontent .= '</tr>';
						 
			$htmlcontent .= '<tr><td colspan="2"> <p style="padding-top:15px;"><strong>Credential Details:</strong></p>';
			  
			$htmlcontent .= '<table align="center" width="100%">';
			$htmlcontent .= '<tr style="font-weight: bold;"><td>Name</td><td>Affiliation</td><td>Type</td><td>Zones (if applicable)</td></tr>';
			$htmlcontent .= $emailAdd;
			$htmlcontent .= '</table></td></tr>';
			$htmlcontent .= '<tr><td colspan="2"> <p><a href="http://www.athletics.umn.edu/credentials/lookUpSingle.php?confirmationNum='.$confirmation.'">See full details here along with status updates here.</a></p></td></tr>';
			

			if($footballGame == 1)			
							$htmlcontent .= '<tr><td colspan="2"><p style="padding-top:15px;"><u>You will be able to pick up your single game credential at the Pass Gate located at Dodge County entrance on the day of the game. The Pass Gate at the Dodge County entrance will open 4 hours prior to game time. Please have a photo ID ready to show to receive your credential.</u></p></td></tr>';
			
										

			
			$htmlcontent .= '</table></body></html>'; 
			
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
			
		//	$res2 = $requestermail->send(array($recipients));	
			
			$res2 = $requestermail->send(array("icaweb@umn.edu"));							
		

?>