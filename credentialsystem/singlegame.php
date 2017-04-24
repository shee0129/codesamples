<?php
include($_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php");
$page = new Web_Page(189); 

?> 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Gopher Athletics Single Game Working Credentials</title>

    <!-- Font Awesome -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Bootstrap -->
    <link href="/include/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script> 

    <script src="/include/bootstrap/js/bootstrap.min.js"></script>
    
    
  <style>
 body
 {
	 background-color: #761e2e;
	 margin:0;
	 font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;
	 font-size:14px;
	 line-height:1.42857143;
	 color:#333;
 }

  .container
  {
	  background-color:#ffffff;
	  
  }
 
  html{font-size:10px;-webkit-tap-highlight-color:rgba(0,0,0,0)}


select.location {
    display: block;
    width: 100%;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
}

#addperson, #addMultiple, #massUpload, .deleteRow {
  
    color: #791e2e;
    font-weight: bold;
    padding: 0px 20px;
    text-align: center;
   /* text-shadow: 0 -1px 0 #396715;*/
   float: left;
   margin-right: 10px;
} 
.deleteRow
{
/*	padding-top: 25px;*/
}
#addperson:hover, #addMultiple:hover, #massUpload:hover, .deleteRow:hover {
    opacity:.85;
    cursor: pointer; 
}

#addperson img, #addMultiple img, #massUpload img, .deleteRow img{
  
    height: 12px;
	margin-right: 5px;
} 
  </style>
</head>
<body>

<div class="container">
<?php //echo print_r($_POST); echo "<br/>".print_r($_FILES); ?>
<div class="page-header">
  
  <h1><img src="https://www.athletics.umn.edu/images/m.gif" hspace="10" /> Single Game Credentials</h1>
</div>

<?php
if(isset($_POST['credNums']) && $_POST['credNums'] > 0)
{
	//print_r($_POST);

	//********INSERT STATEMENT MAIN REQUEST ********************/				
	$insertquery = ('INSERT INTO credential_request_2016 
					SET requester_name="'.$_POST['contactName'].'", 
				  requester_phone="'.$_POST['contactPhone'].'", 
				  reqester_email="'.$_POST['contactEmail'].'", 
				  requester_aff_id="'.$_POST['affiliation'].'", 
				  requester_aff_name="'.$_POST['otherAffiliation'].'",
				  notes="'.$_POST['notes'].'", 	
				  status_id="1", 
				  req_type="SINGLE", 			  	  				  
				  timestamp="'.time() . '"');
//	echo $insertquery;
	$insertquery_results = $page->db->query($insertquery);
			
				
	$maxid = array();
	$maxid_q = "SELECT max(id) as id FROM credential_request_2016";
	$maxid_r = $page->db->query($maxid_q);
	$maxid = $maxid_r->fetch(PDO::FETCH_ASSOC);	  
	$request_id = $maxid['id'];

	//********INSERT STATUS ********************/				
	$statusinsert = ("INSERT INTO credential_status_log_2016 SET
				  user = 'requester',
				  request_id = '".$request_id."',
				  timestamp=" . time() . ", 
				  status_id='1'");
	//echo "<br/>".$statusinsert;
	$statusinsert_results = $page->db->query($statusinsert);
	

	for($i = 1; $i <= $_POST['credNums']; $i++)
	{
				
		$insertcredentials = ('INSERT INTO credential_details_2016 
						SET request_id="'.$request_id.'",
					  name="'.$_POST['credential_name_'.$i].'", 
					  affiliation="'.$_POST['credential_aff_'.$i].'", 
					  type="'.$_POST['credential_type_'.$i].'"');
		//echo "<br/>".$insertcredentials;
		$insertcredentials_results = $page->db->query($insertcredentials);		
	}


	foreach($_POST['games'] as $keys => $values)
	{
				
		$insertGames = ('INSERT INTO credential_calendar_2016 
						SET request_id='.$request_id.',
					  calendar_id='.$values);
		//echo "<br/>".$insertGames;
		$insertGames_results = $page->db->query($insertGames);		
	}	

	//echo "SENDING EMAIL";
	include "emails/email_single.php";
//	echo "<br/>EMAIL SENT";		
    echo "<p>Thank you for submitting your credential request. Your request will be addressed within the next 2-3 business days. If you have any questions please contact the Event Management office.</p>";

} 
else {



?>

<form action="singlegame.php" method="post" id="form1">
	<div style="width:50%">
        <div class="panel panel-default">
          <div class="panel-heading">Your Contact Information</div>
          <div class="panel-body">
          
           
            
            <div class="form-group row">
                <label for="contactName" class="col-sm-4 form-control-label">Name:</label>
                <div class="col-sm-8">
                <input type="text" class="form-control" name="contactName" placeholder="John Doe" required>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="contactPhone" class="col-sm-4 form-control-label">Phone:</label>
                <div class="col-sm-8">
                  <input type="text"  class="form-control" name="contactPhone" placeholder="(555)555-5555" required>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="contactEmail" class="col-sm-4 form-control-label">Email:</label>
                <div class="col-sm-8">
                  <input type="email" class="form-control" id="contactEmail" name="contactEmail" placeholder="john_doe@example.com" required>
                </div>
            </div>
            
            <div class="form-group row">
            <label for="contactAffiliation" class="col-sm-4 form-control-label">Affiliation:</label>
                <div class="col-sm-8">
                    <select name="affiliation" class="form-control" id="affiliation" required>
			<option value=''></option><option value='999'>Non-Athletic Department</option><option value="164">Academic Counseling</option><option value="163">Athletic Administration</option><option value="159">Athletic Communications</option><option value="136">Athletic Facilities</option><option value="134">Athletic Medicine</option><option value="135">Athletics Business Office</option><option value="132">Compliance</option><option value="183">Creative Services</option><option value="166">Equipment Rooms</option><option value="161">Event Management</option><option value="162">Golden Gopher Fund</option><option value="179">Gopher M Club</option><option value="187">Gopher Sports Properties</option><option value="190">Human Resources</option><option value="165">Licensing and Athletic Property</option><option value="158">Marketing</option><option value="144">Men's Baseball</option><option value="156">Men's Basketball</option><option value="142">Men's Cross Country</option><option value="138">Men's Football</option><option value="167">Men's Golf</option><option value="155">Men's Gymnastics</option><option value="151">Men's Hockey</option><option value="153">Men's Swimming and Diving</option><option value="149">Men's Tennis</option><option value="139">Men's Track and Field</option><option value="157">Men's Wrestling</option><option value="141">Spirit Squads</option><option value="175">Strength and Conditioning</option><option value="186">Student-Athlete Development</option><option value="100">Technology Services</option><option value="133">Ticket Office</option><option value="202">unknown</option><option value="137">Women's Basketball</option><option value="143">Women's Cross Country</option><option value="168">Women's Golf</option><option value="145">Women's Gymnastics</option><option value="148">Women's Hockey</option><option value="152">Women's Rowing</option><option value="146">Women's Soccer</option><option value="178">Women's Softball</option><option value="154">Women's Swimming and Diving</option><option value="150">Women's Tennis</option><option value="140">Women's Track and Field</option><option value="122">Women's Volleyball</option>		</select>

                </div>
            </div>  

            <div class="form-group row" id='otherAffiliationRow' style="display:none;">
            <label for="otherAffiliation" class="col-sm-4 form-control-label"></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="otherAffiliation" id="otherAffiliation" placeholder="Enter Affiliation" />

                </div>
            </div>  

      
            
      
            
            
             
                 
          </div><!--panel-body-->
        </div><!--panel panel-default-->
	</div> <!--panel panel-default container-->


    <div class="panel panel-default">
      <div class="panel-heading">Game details <br/> <small>Games will appear after sport is selected</small></div>
      <div class="panel-body">

		<div style="width:50%;">
            <div class="form-group row">
                <label for="sport" class="col-sm-4 form-control-label">Pick a sport:</label>
                <div class="col-sm-8">
                    <select name="sport" id="sport" class="form-control">
                        <option value="0"></option>
                        <option value="144">Baseball</option>
                        <option value="156">Basketball, Men</option>
                        <option value="137">Basketball, Women</option>
                        <option value="142">Cross Country, Men</option>
                        <option value="143">Cross Country, Women</option>
                        <option value="138">Football </option>
                        <option value="167">Golf, Men</option>
                        <option value="168">Golf, Women</option>
                        <option value="155">Gymnastics, Men</option>
                        <option value="145">Gymnastics, Women</option>
                        <option value="151">Hockey, Men</option>
                        <option value="148">Hockey, Women</option>
                        <option value="152">Rowing</option>
                        <option value="146">Soccer</option>
                        <option value="178">Softball</option>
                        <option value="153">Swimming and Diving, Men</option>
                        <option value="154">Swimming and Diving, Women</option>
                        <option value="149">Tennis, Men</option>
                        <option value="150">Tennis, Women</option>
                        <option value="139">Track and Field, Men</option>
                        <option value="140">Track and Field, Women</option>
                        <option value="122">Volleyball</option>
                        <option value="157">Wrestling</option>
                    </select>
                    <?php
               /* $sportq = $page->db->query("SELECT id, name FROM modules WHERE flags LIKE '%sport%' ORDER BY name");
                $sports = $sportq->fetchAll(PDO::FETCH_ASSOC);
                foreach ($sports as $sport) { 
                    //Remove Spirit Squads [141] and Novice Rowing [174] from the list.
                    if ($sport["id"] != 141 && $sport["id"] != 174) { 
                        ?> 
                        <option value="<?php echo $sport["id"]; ?>"><?php echo $sport["name"]; ?></option>
                        <?php 	
                    } 
                }*/
                ?>

                </div>
            </div>
        </div>

<style>
			.well
			{
				width: 46%;
				float: left;
				margin: 1% 2%;
				padding: 0 9px;
				background-color: rgba(252,186,61,.3);
			}
			.checkbox label
			{
				width: 100%;
			}
			</style>
            
        <div id="gamecontainer">	
        	
	
        </div> 
               
             
      </div><!--panel-body-->
    </div><!--panel panel-default-->


    <div class="panel panel-default" id="credentialDetails" style="display: none;">
      <div class="panel-heading">Credential Details <br/> <small><p>Add the names of each person for whom you are requesting a credential.</p></div>
      <div class="panel-body">

            
        <div id="credentialsRequest" >	
            <table class="table" id="table">
        <thead> 
        <tr>
            <th >#</th>
            <th >Type</th>
            <th>Name</th>
            <th>Affiliation/Department </th>   
            <th></th>       
        </tr>
        </thead>  
        <tbody> 
        <tr>  
        <td>1</td>
        <td id="row1">

           
        </td>
        <td><input type="text" name="credential_name_1"  class='form-control' size="50" id="person"  required/></td>
        <td><input type="text" name="credential_aff_1" class='form-control'  size="50" id="person" required/></td>
        <td><!--<div class="deleteRow" id="0"><img src="icons/delete.png"/>Delete Row</div>--></td>
        </tr>          
        </tbody> 
    </table>      	

            <input type="hidden" name="credNums" id="credNums" value="1"/>

 <p style="padding-top: 20px;"> 
             		<div id="addperson"><img src="icons/plus.png"/>Add 1 Credential</div>
                   <!-- <div id="addMultiple"><img src="icons/multipleplus.png"/>Add Multiple Credentials</div>-->
             </p>
             
             	
        </div> 
               
             
      </div><!--panel-body-->
    </div><!--panel panel-default-->


<div style="width:75%">
        <div class="panel panel-default">
          <div class="panel-heading">Request Comments / Notes:</div>
          <div class="panel-body">
 
    <p>If you have any comments or notes you would like to add to this request, please note them here:</p>
    <textarea  class="form-control"  id="notes" name="notes"></textarea> 
           </div><!--panel-body-->
        </div><!--panel panel-default-->
	</div> <!--panel panel-default container-->   
    
</form>

    <div id="submitButtonDiv" style="display:none;">
<button type="submit" class="btn btn-primary" name="submitAllButtons" id="submitAllButtons" >Submit</button>
    </div>
<?php } ?>
<hr/>

  <p style="margin-top:50px;">Confused? Need help? Email <a href="mailto:rhie0012@umn.edu">Geoff Rhiel</a> in Gopher Athletics Event Management.</p>
       
<div style="border-top: 2px solid #761e2e; padding: 20px 0px; margin-top: 15px;">
<img src="https://www.athletics.umn.edu/images/m.gif" hspace="10" /> <a href="index.php">Back to Credential Request Home Page</a>

</div>

</div><!--END CONTAINER -->

<script type="text/javascript" src="/include/jquery/jquery1.11/jquery.mask.js"></script>
<script type="text/javascript"> 

$(function() {

    var sportid = "";
    var rowcount = 1;

    $('[name=contactPhone]').mask('(999) 999-9999');
    $('[name=contactPhone]').mask('(999) 999-9999');

    $("select#affiliation").on("change", function(){


        $( "select#affiliation option:selected").each(function(){

            affiliationSelected = $(this).attr("value");

            if($(this).attr("value")=="999")
            {
                affiliationSelected = $(this).attr("value");
                $("#otherAffiliationRow").show();
                $('#otherAffiliation').prop('required',true);
            }
            else {
                $("#otherAffiliationRow").hide();
                $('#otherAffiliation').prop('required',false);


                $(".employeeType").show();

            }


        });
    });

    $('select[name=sport]').change(function () {
		if ($(this).val() != 0) { 
			sportid = $(this).val();
			$('#gamecontainer').load('ajax/load_games.php?sport='+sportid, function () {

				$('input.gameCheckbox').click(function() { 
					var calendar_id = $(this).val();
					if ($(this).is(':checked')) {
						$('#checkbox_'+calendar_id).css("background-color","rgba(252,186,61,1)");
						
					} else { 
							
						$('#checkbox_'+calendar_id).css("background-color","rgba(252,186,61,.3)");
					}
														
				});
												
				var str = $('#gamecontainer').text();
				var test = str.indexOf("No games found for this sport. Please select a new sport.");
				if (test != -1) { 
					$('#credentialsRequest').hide();
					
					
				} else { 
					$('#credentialsRequest').show();
                    $('#formsubmit').show();
                    row1();
					
				}
							

			}); 


			
			
		} else { 
			$('#gamecontainer').hide();
		//	$('#credentialsRequest').hide();
			$('#formsubmit').hide();
		}
		
		

		
	});


    function row1()
    {
        row = "";
        if(sportid == 138)
        {
            row += "<select name='credential_type_"+rowcount+"' class='form-control' id='credential0' >"+
                "<option value='2' id='0'>Photo</option>"+
                "<option value='3' id='0'>Marching Band</option>"+
                "<option value='4' id='0'>Football Family</option>"+
                "<option value='5' id='0'>Special Guest</option>"+
                "<option value='6' id='0'>Premium Guest</option>"+
                "<option value='7' id='0'>DQ Club Guest</option>"+
                "<option value='8' id='0'>Game Services</option>"+
                "<option value='9' id='0'>Vendor/Contractor</option>"+
                "<option value='10' id='0'>Event Production</option>"+
                "<option value='11' id='0'>Field VIP</option>"+
                "<option value='12' id='0'>Recruit</option>"+
                "<option value='13' id='0'>Pregame Guest</option>"+
                "<option value='14' id='0'>Other</option>"+
                "</select>";
        }
        else {


            row += "<select name='credential_type_"+rowcount+"' class='form-control' id='credential0' >"+
                "<option value='15'>All Access</option>"+
                "<option value='16'>Promotions</option>"+
                "<option value='17'>Television</option>"+
                "<option value='18'>Game Services</option></select> ";
        }
        rowcount++;
        $('td#row1').append(row);
    }


    $(document).on('click', '.gameCheckbox', function(){
        $('#submitButtonDiv').show();
    });

    $(document).on('click', '.well', function(){
        $('#credentialDetails').show();
    });
$(document).on('click', '#addperson', function(){

		  var row = "<tr><td>"+parseInt(rowcount) +"</td><td>";

        if(sportid == 138)
        {
            row += "<select name='credential_type_"+rowcount+"' class='form-control' id='credential0' >"+
				"<option value='2' id='0'>Photo</option>"+
				"<option value='3' id='0'>Marching Band</option>"+
				"<option value='4' id='0'>Football Family</option>"+  
				"<option value='5' id='0'>Special Guest</option>"+
				"<option value='6' id='0'>Premium Guest</option>"+
				"<option value='7' id='0'>DQ Club Guest</option>"+
				"<option value='8' id='0'>Game Services</option>"+
				"<option value='9' id='0'>Vendor/Contractor</option>"+
				"<option value='10' id='0'>Event Production</option>"+
				"<option value='11' id='0'>Field VIP</option>"+
				"<option value='12' id='0'>Recruit</option>"+
				"<option value='13' id='0'>Pregame Guest</option>"+
				"<option value='14' id='0'>Other</option>"+
				"</select>";
        }
        else {


            row += "<select name='credential_type_"+rowcount+"' class='form-control' id='credential0' >"+
				"<option value='15'>All Access</option>"+
				"<option value='16'>Promotions</option>"+
				"<option value='17'>Television</option>"+
				"<option value='18'>Game Services</option></select> ";
        }
            row += "</td>"+
				"<td><input type='text' name='credential_name_"+rowcount+"'  class='form-control' size='25' id='person'  /></td>"+
				"<td><input type='text' name='credential_aff_"+rowcount+"' class='form-control'  size='25' id='person'/></td>"+
				"<td><!--<div class='deleteRow' id=''><img src='icons/delete.png'/>Delete Row</div>--></td> </tr>";

        $("#credNums").val(rowcount) ;
        //keep track of our row count
			rowcount++; 
			

												
			$('#table tbody').append(row);

				
		
	});	

	
});
    

			

</script>



</body>
</html>
<?php
$page->db = NULL;
?>