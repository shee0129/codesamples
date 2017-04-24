<?php 
//include($_SERVER['DOCUMENT_ROOT'] . "/include/db_connect.php");
//include($_SERVER['DOCUMENT_ROOT'] . "/credential/mail/htmlMimeMail5.php");
include($_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php");
$page = new Web_Page(189); 
?> 
<!DOCTYPE html>   
<html>  
<head>
<meta charset="UTF-8" />
<title>Gopher Athletics Credential Request</title>
<link rel="stylesheet" href="/credentials/style.css" />
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700' rel='stylesheet' type='text/css'>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>


<link href="select/select2/css/select2.min.css" rel="stylesheet" />
<script src="select/select2/js/select2.min.js"></script>
 	 
      <style>
	table 
	{
		width: 70%;
		margin-top:15px;
		
	}
	td.search
	{
		width: 45%;
		vertical-align: top;
	}
	#searchTitle
	{
		font-weight:bold;
		font-size: 16px;
		padding-bottom: 5px;
		
		
	}
	#searchSub
	{
		font-size: 14px;
			margin:5px;
	}
	#or
	{ 
		font-size: 24px;
		font-weight: bold;
		margin: 5px;  
		color: #761e2e;
		text-align:center;
	}
	#nameinput 
	{
		height:20px; 
		width:220px;   
		padding:5px 8px;
		border:1px solid #aaa;
		box-shadow: 0px 0px 3px #ccc, 0 10px 15px #eee inset;
		border-radius:2px; 
		padding-right:30px;	
			margin:5px;
	}
	#confinput 
	{
		height:20px; 
		width:100px;   
		padding:5px 8px;
		border:1px solid #aaa;
		box-shadow: 0px 0px 3px #ccc, 0 10px 15px #eee inset;
		border-radius:2px; 
		padding-right:30px;	
			margin:5px;
	}	

/* Button Style */
button.submit {
    background-color: #761e2e;
    background: -webkit-gradient(linear, left top, left bottom, from(#A95161), to(#761E2E));
    background: -webkit-linear-gradient(top, #A95161, #761E2E);
    background: -moz-linear-gradient(top, #A95161, #761E2E);
    background: -ms-linear-gradient(top, #A95161, #761E2E);
    background: -o-linear-gradient(top, #A95161, #761E2E);
    background: linear-gradient(top, #A95161, #761E2E); 
    border: 1px solid #5d0515;
    border-radius: 3px;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    -ms-border-radius: 3px;
    -o-border-radius: 3px;
 /*   box-shadow: inset 0 1px 0 0 #9fd574; 
    -webkit-box-shadow: 0 1px 0 0 #9fd574 inset ;
    -moz-box-shadow: 0 1px 0 0 #9fd574 inset;
    -ms-box-shadow: 0 1px 0 0 #9fd574 inset;
    -o-box-shadow: 0 1px 0 0 #9fd574 inset;*/
    color: white;
    font-weight: bold;
    padding: 6px 20px;
    text-align: center;
   /* text-shadow: 0 -1px 0 #396715;*/
} 
button.submit:hover {
    opacity:.85;
    cursor: pointer; 
}
button.submit:active {
    border: 1px solid #761e2e;
    box-shadow: 0 0 10px 5px #761e2e inset; 
    -webkit-box-shadow:0 0 10px 5px #761e2e inset ;
    -moz-box-shadow: 0 0 10px 5px #761e2e inset;
    -ms-box-shadow: 0 0 10px 5px #761e2e inset;
    -o-box-shadow: 0 0 10px 5px #761e2e inset;

  
}

	.contact_form ul.contact { 
    width:750px;
    list-style-type:none;
    list-style-position:outside;
    margin:0px;
    padding:0px;
} 
.contact_form ul.contact li{ 
    padding:5px; 
   /* border-bottom:1px solid #eee;*/
    position:relative;
	width: 90%;
}


.contact_form ul.contact li:first-child  {
    border-bottom:1px solid #777; 
}

h2
{ 
    margin:0;
    display: inline; 
	color:#761e2e; 
}
.label { 
   width: 30%; 
    /* margin-top: 3px;*/
    display:inline-block;
    float:left; 
    padding:3px; 
	font-size: 1.2em;
	font-weight:bold; 
}
#contact  { 
    height:20px; 
    width:220px;  
    padding:5px 8px;

	padding-right:30px;	
}
ul.showRequest { 
    width:750px;
    list-style-type:none;
    list-style-position:outside;
    margin:0px;
    padding:0px;
}
ul.showRequest  li{ 
    padding:5px; 
   /* border-bottom:1px solid #eee;*/
    position:relative;
	width: 90%;
}
ul.showRequest li:first-child  {
    border-bottom:1px solid #777; 
}
	</style>
</head>
 

</style> 
 
<body>  

<div class="container">


    <p class="headline"><img src="https://www.athletics.umn.edu/images/m.gif" hspace="10" />Single Game Credential - Look Up Request Status</p>

	<?php //print_r($_POST); 
	//print_r($_GET);
	?>

<?php 
if(isset($_POST['lookUp']) || isset($_GET['confirmationNum']))  
{
	if(isset($_GET['confirmationNum'])) 
	{
		$confirmationLookUp = "confirmation_id like '%".$_GET['confirmationNum']."%'";
	}
	else if(isset($_POST['confirmationNum']))  
	{
		$confirmationLookUp = "confirmation_id like '%".$_POST['confirmationNum']."%'";
	}
	else if(isset($_POST['name'])) 
	{ 
		$nameLookUp = "name like '%".$_POST['name']."%'";

	}	

	$lookUp = array(); 
	$lookUp_q = "SELECT s.id, s.name, phone, email, s.affiliation, m.name as mname, calendar_ids, s.timestamp, notes, confirmation_id
				FROM credentials_single_game s
				LEFT JOIN modules m
				ON s.affiliation = m.id
				WHERE " . $confirmationLookUp . $nameLookUp;
			//echo ($lookUp_q);				
	$lookUp_r = $page->db->query($lookUp_q);
	$lookUp = $lookUp_r->fetchAll(PDO::FETCH_ASSOC);	 
	
	





	
	 
	if(count($lookUp) == 0)
	{
		echo "<h2>NO REQUESTS WERE FOUND. PLEASE TRY AGAIN.</h2>";
		echo "<p>If you are still having issues, please email <a href='mailto:icaweb@umn.edu'>icaweb@umn.edu</a> for technical help.</p>";		 
		unset($_POST['lookUp']);
	}
	else{


		
		echo "<div style='text-align: center; padding-bottom: 15px; width: 100%;'><h2 >Request details below.</h2></div>";

		foreach($lookUp as $lU)  
		{
			
			if(substr($lU['affiliation'],0,3) == "999")
			{
				
				$affiliation = substr($lU['affiliation'],4);
			}
			else if($lU['affiliation'] == "998")
			{
				$affiliation =  "Media"; 
			}			    
			else 
			{
				$affiliation = $lU['mname'];
			}	
			
?>			 
	    <ul class='showRequest' style="padding-top: 15px;">
            <li>  
                 <h2>Your Contact Information</h2>
            </li>
            <li>
                <div class="label">Name:</div>
                <div class="output"><?php echo $lU['name']; ?> </div>
            </li>
            <li>
                <div class="label">Phone Number:</div>
                <div class="output"><?php echo $lU['phone']; ?> </div>
            </li>     
            <li>
                <div class="label">Email Address:</div>
                <div class="output"><?php echo $lU['email']; ?> </div>
            </li> 
            <li>
                <div class="label">Affiliation:</div>
                <div class="output"><?php echo $affiliation ?> </div>
            </li>           
            
    	</ul> 		
			
			<style>
			.calendarName
			{
				font-size: 14px;
				font-weight:bold;
		
			
				
			}
			.date
			{
				
				font-size: 12px;
			
				
			}	
			td.cellLabel { 
  
    padding:3px;
	font-size: 1.2em;
	font-weight:bold;  
}		 
			</style> 

<div id="personcontainer" style="padding-top:50px;">
    <h2>Request Status</h2> 
    <hr/> 

			<?php 
			
				$statusLookUp = array();  
				$statusLookUp_q = "SELECT l.user, l.timestamp, l.notes, s.name
									FROM credentials_status_log l
									JOIN credential_statuses s
									ON l.status_id = s.id 
									WHERE request_id = ".$lU['id'] ." 
									AND type = 'single'
									ORDER BY l.timestamp desc"; 
				$statusLookUp_r = $page->db->query($statusLookUp_q);		 	
				$statusLookUp = $statusLookUp_r->fetchAll(PDO::FETCH_ASSOC);	 
				
				$count == 0;
				
				foreach($statusLookUp  as $sL)
				{ 
					if($sL['user'] == 'requester') 
					{   
						$user = $lU['name'];
					} else 					
					{  
						$user = Web_Data::get_fullname($sL['user'], $page->db) ; 
					} 
						
					if($count == 0) 
						echo "<strong>Current status: ". $sL['name'] ."</strong> - updated by " . $user . " on " .date("M j g:i a",$sL['timestamp'])  ." <br/><br/>";
					else if($count == 1) 
					{
						echo ("<i>Past updates: </i><br/><div style='padding-left:20px;'>");
						
						echo (date("M j g:i a",$sL['timestamp']) . " - updated to <i>" .  $sL['name'] . "</i> by " . $user  . "<br/>");
					}
					else {	

						echo (date("M j g:i a",$sL['timestamp']) . " - updated to <i>" .  $sL['name'] . "</i> by " . $user  . "<br/>");
							
					}
					
					if($sL['notes'] != "")
							echo "<span style='margin-left: 25px;'><strong>Notes for Update: </strong>" . $sL['notes'] . "</span><br/>";	
							
							
					$count++;
					
				}
				
				if($count > 1) 
				{ 
					echo ("</div>");
				}
			
			?> 
                  
     </div>		
                 
<div id="personcontainer" style="padding-top:50px;"> 
    <h2>Games Requested</h2> 
    <hr/> 
			<table>
			<?php 
			
				$calendarLookUp = array();  
				$calendarLookUp_q = "SELECT * FROM calendar
									WHERE id in (".$lU['calendar_ids'].")";
				$calendarLookUp_r = $page->db->query($calendarLookUp_q);		 	
				$calendarLookUp = $calendarLookUp_r->fetchAll(PDO::FETCH_ASSOC);	 
				
				foreach($calendarLookUp  as $cL)
				{
					echo "<tr><td><div class='calendarName'>".$cL['event'].":</div></td><td><div class='date'>".date("l, F j, Y", $cL["event_startdate"])."</div></td></tr>";
				}
			
			?>
            </table>                
</div>	
			
<div id="personcontainer" style="padding-top:50px;">
    <h2>Credential Details</h2> 
    <hr/> 
		           <table cellpadding="5" cellspacing="1" style="background-color:#FFFFFF;" id="fields">
        <thead>
        <tr>
        <td class="cellLabel">Type</td>
        <td class="cellLabel" id="zonesHead0"></td>
        <td class="cellLabel">Name</td>
        <td class="cellLabel">Affiliation/Department</td>         
        <td class="cellLabel" id="zonesHead0">Markings(if applicable)</td>        
        <td class="cellLabel" id="zonesHead0">Zones(if applicable)</td>                        
        </tr>
        </thead>  
        <tbody>
			<?php  
			
				$detailsLookUp = array();  
				$detailsLookUp_q = "SELECT * FROM credentials_single_details 
									WHERE request_id = ".$lU['id'];
				$detailsLookUp_r = $page->db->query($detailsLookUp_q);		 	
				$detailsLookUp = $detailsLookUp_r->fetchAll(PDO::FETCH_ASSOC);	 
				
				foreach($detailsLookUp  as $dL)
				{
					echo "<tr>";
						
					echo "<td>";
					
					switch($dL['type'])
					{  
						case "1":  echo "Media"; break;
						case "2": echo "Photo"; break;
						case "3":  echo "Marching Band"; break;                                 
						case "4":  echo "Football Family"; break;  
						case "5":  echo "Team VIP"; break;                   
						case "6";  echo "Premium Guest"; break;  
						case "7";  echo "DQ Club Guest"; break;    
						case "8";  echo "Game Services"; break;  
						case "9":  echo "Vendor/Contractor"; break;  
						case "10":  echo "Event Production"; break;    
						case "11":  echo "Field VIP"; break;    
						case "12":  echo "Recruit"; break;  
						case "13":  echo "Pregame Guest"; break;                 
						case "14":  echo "Other"; break;				
					}
 
					echo "</td>";
					echo "<td></td>";
					echo "<td>".$dL['name']."</td>";
					echo "<td>".$dL['affiliation']."</td>";
					echo "<td>".$dL['markings']."</td>";
					echo "<td>".$dL['zones']."</td>";					
					
					echo "</tr>";
				}
			
			?>
        		              
        </tbody>
    </table>              
     </div>				
			
<?php			
		}
	


















		
	}

	 
	 
}
if(!(isset($_POST['lookUp'])) && !(isset($_GET['confirmationNum'])))
{
	



?>
 <form class="contact_form" action="" method="post" name="lookup">
    <ul class='contact'>
        <li> 
             <h2>Look Up the Status of Your Request</h2>
        </li>
    </ul> 
    
   
      
    <table>
   		<tr> 
        	<td class="search"> 
            
            	<div style="width: 80%; margin: 0 auto;">
                    <div id="searchTitle">Search using your Confirmation Number:</div>
                    
                    <input type="text" name="confirmationNum" id="confinput"/>
            	</div>
            </td>
       <!--     <td> <div id="or">OR</div> </td>
            <td class="search">  
            	<div style="width: 80%; margin: 0 auto;">
                    <div id="searchTitle">Search with name used to request credentials: </div>
                    <div id="searchSub"><input type="text" name="name" id="nameinput"/></div>
                    
                </div>
            
            </td> 
        -->
       
       
       
       </tr> 
   
    <tr>
    	<td colspan="3">
<div style="text-align:center;">
    
    <button name="lookUp" id="lookUp" class="submit" type="submit" value="submit" >Search for my Request!</button>
    </div>
    </td>
        </table>
   </form>
   	
     


 
<?php } ?> 
 
<div style="border-top: 2px solid #761e2e; padding:20px; margin-top: 15px;">
<img src="https://www.athletics.umn.edu/images/m.gif" hspace="10" /> <a href="index.php">Back to Credential Request Home Page</a>
</div>

</div>
</body>
</html>
<?php
$page->db = NULL;
?>