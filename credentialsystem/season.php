<!----
+-------------------------------------------------------------------------------------+
 | File Name: season.php		                                                      |
 | Page name: Gopher Athletics Season Working Credentials                             |
 | Author: Krista Sheely                                                              |
 | Written: 05/2015                                                                   |
 | Tables: credential_request_2016, credential_details_2016,                          |
 | 		credential_status_log_2016                                                    |
 | Description: Request page for users to request season credentials. 				  |
 | 		Credentials are divided by their location, and users then select markings     |
 |        and zones where applicable.                                                 |  
 |        After submitting, users and admins will receive an email with copy of 	  | 	
 |        request.														 		      |
 | Updates: 												                          |
 |  	05/2016, K. Sheely : Updated to 2016 requirements | added Bootstrap           |
 |														                              |
+-------------------------------------------------------------------------------------+
--->
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
    <title>Gopher Athletics Season Working Credentials</title>

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
    
    <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">
  <script src="js/dropzone.js"></script>





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

<div class="page-header">
  
  <h1><img src="https://www.athletics.umn.edu/images/m.gif" hspace="10" /> Season Working Credentials</h1>
</div>


<?php
if(isset($_POST['credNums']) && $_POST['credNums'] > 0)
{
	//********INSERT STATEMENT MAIN REQUEST ********************/				
	$insertquery = ('INSERT INTO credential_request_2016 
					SET requester_name="'.$_POST['contactName'].'", 
				  requester_phone="'.$_POST['contactPhone'].'", 
				  reqester_email="'.$_POST['contactEmail'].'", 
				  requester_aff_id="'.$_POST['affiliation'].'", 
				  requester_aff_name="'.$_POST['otherAffiliation'].'",
				  notes="'.$_POST['notes'].'", 	
				  status_id="1", 
				  req_type="SEASON", 			  	  				  
				  timestamp="'.time() . '"');
	$insertquery_results = $page->db->query($insertquery);
	$request_id = $page->db->lastInsertId();		


	//********INSERT STATUS ********************/				
	$statusinsert = ("INSERT INTO credential_status_log_2016 SET
				  user = 'requester',
				  request_id = '".$request_id."',
				  timestamp=" . time() . ", 
				  status_id='1'");
	$statusinsert_results = $page->db->query($statusinsert);
	

	for($i = 1; $i <= $_POST['credNums']; $i++)
	{
        if($_POST['credName_'.$i] != "")
        {
		$markings = "";
		$zones = "";
				
		$markings = implode("|",$_POST['markings'.$i]);
		$zones = implode("|",$_POST['zones'.$i]);
				
		$insertcredentials = ('INSERT INTO credential_details_2016 
						SET request_id="'.$request_id.'",
					  name="'.$_POST['credName_'.$i].'", 
					  title="'.$_POST['credPosition_'.$i].'", 
					  emp_type="'.$_POST['employeeType_'.$i].'", 
					  cred_loc="'.$_POST['employeeLocation_'.$i].'",
					  markings="'.$markings.'", 	
					  zones="'.$zones.'"');
		$insertcredentials_results = $page->db->query($insertcredentials);
        }
	}

    $files = array();
    $files_id = "";

    $filesTitle = array();
    $headshots = "";

    //********HANDLE HEADSHOT FILES ********************/
    // Loop $_FILES to execute all files
    foreach ($_FILES['images']['name'] as $f => $name) {

        if($_FILES['images']['tmp_name'][$f] != "")
        {
            if (!copy ($_FILES['images']['tmp_name'][$f],"headshots/" .stripslashes($name))) {
                echo "<h3>There was a problem uploading the file to the server - please contact ".$page->webmaster."</h3>";

                $page->modification_date = filemtime($_SERVER['SCRIPT_FILENAME']);

                $page->db = NULL;
                die();
            }
            //echo "<h3>File upload completed.</h3>";

            $execute = array();
            $filesid = "";
            $insertquery = $page->db->prepare("INSERT INTO files SET module='161',
						  active='1',
						  name='".stripslashes($name)."', 
						  size='".$_FILES['images']['size'][$f]."', 
						  type='".$_FILES['images']['type'][$f]."', 
						  label='headshot', 
						  timestamp=" . time() . ", 
						  user='photoRequest'");

            if (!$insertresult = $insertquery->execute($execute)) {
                echo "<h3>There was a problem inserting the record into the database. Please contact ".$page->webmaster.".</h3>";


            } else {
                $filesid = $page->db->lastInsertId();

                $insertHeadshots = ('INSERT INTO credential_headshots_2016 
						SET request_id="'.$request_id.'",
					  file_id='.$filesid);
               // echo "<br/>".$insertHeadshots;
                $insertHeadshots_r = $page->db->query($insertHeadshots);
            }
        }
        $files_id = implode(",", $files);
        $headshots = implode(",", $filesTitle);
    }
	
	//echo "SENDING EMAIL";
	include "emails/email_season.php";
	
	echo "<p>Thank you for submitting your credential request. Your request will be addressed within the next 2-3 business days. If you have any questions please contact the Event Management office.</p>";
	
} else {

?>

 <form action="season.php" method="post" id="form1"  enctype="multipart/form-data">
	<div id="contactPanel" style="width:50%;">
        <div class="panel panel-default">
          <div class="panel-heading">Your Contact Information</div>
          <div class="panel-body">
          
           
            
            <div class="form-group row">
                <label for="contactName" class="col-sm-4 form-control-label">Name:</label>
                <div class="col-sm-8">
                <input type="text" class="form-control" name="contactName" id="contactName" placeholder="John Doe" required>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="contactPhone" class="col-sm-4 form-control-label">Phone:</label>
                <div class="col-sm-8">
                  <input type="text"  class="form-control" name="contactPhone" id="contactPhone" placeholder="(555)555-5555"   required>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="contactEmail" class="col-sm-4 form-control-label">Email:</label>
                <div class="col-sm-8">
                  <input type="email" class="form-control" id="contactEmail" name="contactEmail" placeholder="john_doe@example.com"   required>
                </div>
            </div>
            
            <div class="form-group row">
            <label for="contactAffiliation" class="col-sm-4 form-control-label">Affiliation:</label>
                <div class="col-sm-8">
                    <select name="affiliation" class="form-control" id="affiliation"  required>
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

    <div id="seeLastYear" style="width:48%; margin-left: 2%; display:none; float: left;">
        <div class="alert alert-warning" role="alert">
          <a href="" id="seeLastYearLink" target="_blank" class="alert-link">Did you submit a credential last year? See it now!</a>
        </div>
        
    </div>

	<div style="clear: both;"></div>
    
	<div style="width:100%; float: left;">
        <div class="panel panel-default">
          <div class="panel-heading">Credential Details</div>
          <div class="panel-body">
          	<p>Add the names of each person for whom you are requesting a credential.</p>
            <p>Don't know what TCF Zones to select? <a href="2015_Credential_Zones_Map.pdf" target="_blank">Click here</a> to read detailed descriptions of each TCF Zone.</p>
            <p>Examples of this year's Credentials can be found <a href="2017_credential_layout.pdf" target="_blank">here</a>.</p>
 
            <table class="table" id="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Position</th>
                  <th>Credential Location</th>    
                  <th></th>
                  <th></th>        
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td><input type="text" class="form-control" name="credName_1" required></td>
                  <td><input type="text" class="form-control" name="credPosition_1" required></td>
                  <td><select class="location" name='employeeLocation_1' id="location1" required>
        	<option value="">Select Location</option>
            <option value="1">All Facilities</option>
            <option value="2">TCF Bank Stadium</option>
            <option value="3">Williams Arena / Sports Pavilion</option>    
            <option value="4">Mariucci Arena / Ridder Arena</option>    
           <!-- <option value="5">Outdoor (ELR, JSC, Siebert)</option>-->
            </select></td>      
            <td>      <dl class="dropdown" id="markings1" style="display:none;">              
                <dt>
                    <div class="dropdownLink" id="markings1">
                    <span class="hidamarkings1">Select TCF Marking(s)</span>    
                    <p class="multiSel" id="multiSelmarkings1"></p>  
                     </div>
                </dt>
                
                <dd> 
                    <div class="multiSelect" id="markings1">
                        <ul id="selectmarkings1">
                            <li> <input type='checkbox' name='markings1[]' class='markings' id='markings0' value='F' /> Field Access (F)</li>
                            <li> <input type='checkbox' name='markings1[]' class='markings'  id='markings0' value='P' /> <div id="labelP_Markings0">Pregame/Postgame Field Access (P)</div> </li>
                            <li> <input type='checkbox' name='markings1[]' class='markings'  id='markings0' value='E' /> <div id="labelE_Markings0">Escort Privileges (E)</div></li>
                        </ul>
                    </div>
                </dd>            
            </dl></td>
            <td> <dl class="dropdown" id="zones1" style="display:none;">  
          
            <dt>
            <div class="dropdownLink" id="zones1">
              <span class="hidazones1">Select TCF Zone(s)</span>    
              <p class="multiSel" id="multiSelzones1"></p>  
            </div>
            </dt>
          
            <dd> 
                <div class="multiSelect" id="zones1">
                    <ul id="selectzones1">
                        <li> <input type='checkbox' name='zones1[]' class='zone' value='0' /> Zone 0: Home team locker room </li>
                        <li> <input type='checkbox' name='zones1[]' class='zone' value='1' /> Zone 1: Field</li>
                        <li> <input type='checkbox' name='zones1[]' class='zone' value='2' /> Zone 2: Home team bench, recruiting room</li>
                        <li> <input type='checkbox' name='zones1[]' class='zone' value='3' /> Zone 3: DQ Club Room</li>
                        <li> <input type='checkbox' name='zones1[]' class='zone' value='4' /> Zone 4: Premium Areas (excluding DQ Club)</li>
                        <li> <input type='checkbox' name='zones1[]' class='zone' value='5' /> Zone 5: Visiting team bench, visiting team locker room</li>
                        <li> <input type='checkbox' name='zones1[]' class='zone' value='6' /> Zone 6: 600 level (non-premium areas), interview rooms</li>
                        <li> <input type='checkbox' name='zones1[]' class='zone' value='7' /> Zone 7: Service level working areas </li>
                        <li> <input type='checkbox' name='zones1[]' class='zone' value='8' /> Zone 8: Marching band areas </li>
                    </ul>
                </div>
            </dd>
        
        </dl>  </td>
                </tr>
              </tbody>
			</table>          
          
            <input type="hidden" name="credNums" id="credNums" value="1"/>
            
      
            
             <p style="padding-top: 20px;"> 
             		<div id="addperson"><img src="icons/plus.png"/>Add 1 Credential</div>
                    <div id="addMultiple"><img src="icons/multipleplus.png"/>Add Multiple Credentials</div>
             </p>
             
             
          </div><!--panel-body-->
        </div><!--panel panel-default-->
	</div> <!--panel panel-default container-->

	<div style="clear: both;"></div>

	<div style="width:75%">
        <div class="panel panel-default">
          <div class="panel-heading">Request Comments / Notes:</div>
          <div class="panel-body">
 
  
    <p>If you have any comments or notes you would like to add to this request, please note them here:</p>
    
      <p id="zonesExp" style="display:none; font-weight:bold;">Please explain here why specific TCF Zones were selected. </p>
    <textarea  class="form-control"  id="notes" name="notes"></textarea>
           </div><!--panel-body-->
        </div><!--panel panel-default-->
	</div> <!--panel panel-default container-->
     <div id="fileNames"></div>



<div style="width:75%">
        <div class="panel panel-default">
          <div class="panel-heading">Headshots:</div>
          <div class="panel-body">
 
    <p>If any of the above requested credentials' headshot are not in the system (have not been requested before) AND are not full-time employees at Gopher Athletics, please upload their headshot below. </p>
    <p><strong>Headshot format: Image should be at least 150 DPI and at least 2" wide by 3" tall. It should not exceed 6 MB.</strong></p>
    <p><strong>Label each file as: <span style="font-family:'Courier New';">Last Name, First Name – Department </span></strong></p>
    
              <input type="file" id="images" name="images[]"  multiple="multiple" />
              <p><strong>Hint: To select more than 1 image, use CTRL or SHIFT when selecting images. </strong></p>


          </div><!--panel-body-->
        </div><!--panel panel-default-->
	</div> <!--panel panel-default container-->   
    
<button type="submit" class="btn btn-primary" name="submitAllButtons" id="submitAllButtons">Submit</button>

    </form>
<?php } ?>

<hr/>

  <p style="margin-top:50px;">Confused? Need help? Email <a href="mailto:rhie0012@umn.edu">Geoff Rhiel</a> in Gopher Athletics Event Management.</p>
       
<div style="border-top: 2px solid #761e2e; padding: 20px 0px; margin-top: 15px;">
<img src="https://www.athletics.umn.edu/images/m.gif" hspace="10" /> <a href="index.php">Back to Credential Request Home Page</a>

</div>

</div><!---CONTAINER-->

<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" src="/include/jquery/jquery1.11/jquery.mask.js"></script>
<script type="text/javascript">


    $(document).on('change', 'select.location', function(){
  
			var id =  $(this).attr("id");
				id = id.substring(8, id.length);					
				//	alert(id);
	   $( "select.location#location"+id+" option:selected").each(function(){ 
				//alert($(this).attr("value"));
               if($(this).attr("value")=="1" || $(this).attr("value")=="2"){
					$("#markings" + id).show();
					$("#zones" + id).show();
					$("#zonesExp").show();
					$("#notes").prop('required',true);
					//alert("NOTES REQUIRED");
                }  
				else {
					$("#markings" + id).hide(); 
					$("#zones" + id).hide();
				//	$("#zonesExp").hide();	
				//	$("#notes").prop('required',false);				
                } 
			
			
          }); 
    });

    Dropzone.autoDiscover = false;


$(function() {


    $(document).on('click', '#submitAllButtons', function(){
        if($('#notes').prop('required')){
            if($('#notes').val() == ""){
                alert("Please fill out the following: 'Request Comments' - please include explanation for TCF Zones selected.");
            }
        }
        else if($('#contactName').val() == ""){
            alert("Please fill out the following: 'Name'");
        }
        else if($('#contactPhone').val() == ""){
            alert("Please fill out the following: 'Phone'");
        }
        else if($('#contactEmail').val() == ""){
            alert("Please fill out the following: 'Email'");
        }
        else if($('#affiliation').val() == ""){
            alert("Please fill out the following: 'Affiliation'");
        }
        else {

            $("#form1").submit();
        }
    });

	$('[name=contactPhone]').mask('(999) 999-9999');
	
	$('#contactName').change(function() {
    
	
		var name = $('#contactName').val();
		
		$.ajax({
			  type : 'GET',
			  url : 'ajax/checkSeasonName.php',
			  dataType : 'html',
			  data: {
				  contactName : $('#contactName').val()
			  },
			  success : function(data){			
					   
					  if(data > 0)
					  {
						 // alert(data);
						  $('#seeLastYear').show();
						  $('#submitcredID').val(data) ;								  
						  $("#seeLastYearLink").attr("href", "https://www.athletics.umn.edu/credentials/lookUp.php?name=" + $('#contactName').val());
						  	$("#contactPanel").css("float", "left");	
					  }		
					 else
					  {
						 $('#seeLastYear').hide();	 						  
					  }

			  }
		});			  
	});

	$('#contactPhone').change(function() {
    
		
		$.ajax({
			  type : 'GET',
			  url : 'ajax/checkSeasonName.php',
			  dataType : 'html',
			  data: {
				  contactPhone : $('#contactPhone').val()
				  //affiliation : $('#searchAffiliation').val(),
				  //status : $('#searchStatus').val(),
			  },
			  success : function(data){			
					   
					  if(data > 0)
					  {
						 // alert(data);
						  $('#seeLastYear').show();
						  $('#submitcredID').val(data) ;								  
						  $("#seeLastYearLink").attr("href", "https://www.athletics.umn.edu/credentials/lookUp.php?phone=" + $('#contactPhone').val());
						  	$("#contactPanel").css("float", "left");	
					  }		
					 else
					  {
						 $('#seeLastYear').hide();	 						  
					  }

			  }
		});			  
	});

	$('#contactEmail').change(function() {
    
		
		$.ajax({
			  type : 'GET',
			  url : 'ajax/checkSeasonName.php',
			  dataType : 'html',
			  data: {
				  contactEmail : $('#contactEmail').val()
				  //affiliation : $('#searchAffiliation').val(),
				  //status : $('#searchStatus').val(),
			  },
			  success : function(data){			
					   
					  if(data > 0)
					  {
						 // alert(data);
						  $('#seeLastYear').show();
						  $('#submitcredID').val(data) ;								  
						  $("#seeLastYearLink").attr("href", "https://www.athletics.umn.edu/credentials/lookUp.php?email=" + $('#contactEmail').val());
						  	$("#contactPanel").css("float", "left");	
					  }		
					 else
					  {
						 $('#seeLastYear').hide();	 						  
					  }

			  }
		});			  
	});	

	$('[name=phone]').mask('(999) 999-9999');
		
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

var rowcount = 2;  

$(document).on('click', '#addperson', function(){
   

		var row = "<tr><th scope='row'>"+parseInt(rowcount)+"</th><td><input type='text' class='form-control' name='credName_"+rowcount+"'></td>"+
			"<td><input type='text' class='form-control' name='credPosition_"+rowcount+"'></td>"+
			"<td><select class='location' name='employeeLocation_"+rowcount+"' id='location"+rowcount+"' required>"+
			"<option value=''>Select Location</option>"+
			"<option value='1'>All Facilities</option>"+
			"<option value='2'>TCF Bank Stadium</option>"+
			"<option value='3'>Williams Arena / Sports Pavilion</option>    "+
			"<option value='4'>Mariucci Arena / Ridder Arena</option>        "+
			"<option value='5'>Outdoor (ELR, JSC, Siebert)</option>"+
			"</select></td>      "+
			"<td><dl class='dropdown' id='markings"+rowcount+"' style='display:none;'>              "+
			"<dt><div class='dropdownLink' id='markings"+rowcount+"'>"+
			"<span class='hidamarkings"+rowcount+"'>Select TCF Marking(s)</span>  "+  
			"<p class='multiSel' id='multiSelmarkings"+rowcount+"'></p></div></dt><dd> "+
			"<div class='multiSelect' id='markings"+rowcount+"'><ul id='selectmarkings"+rowcount+"'>"+
			"<li> <input type='checkbox' name='markings"+rowcount+"[]' class='markings' id='markings"+rowcount+"' value='F' /> Field Access (F)</li>"+
			"<li> <input type='checkbox' name='markings"+rowcount+"[]' class='markings'  id='markings"+rowcount+"' value='P' /> <div id='labelP_Markings0'>Pregame/Postgame Field Access (P)</div> </li>"+
			"<li> <input type='checkbox' name='markings"+rowcount+"[]' class='markings'  id='markings"+rowcount+"' value='E' /> <div id='labelE_Markings0'>Escort Privileges (E)</div></li>"+
			"</ul></div></dd></dl></td><td> <dl class='dropdown' id='zones"+rowcount+"' style='display:none;'>  <dt>"+
			"<div class='dropdownLink' id='zones"+rowcount+"'><span class='hidazones0'>Select TCF Zone(s)</span><p class='multiSel' id='multiSelzones0'></p>  "+
			"</div></dt><dd> "+
			"<div class='multiSelect' id='zones"+rowcount+"'><ul id='selectzones"+rowcount+"'>"+
			"<li> <input type='checkbox' name='zones"+rowcount+"[]' class='zone' value='0' /> Zone 0: Home team locker Room </li>"+
			"<li> <input type='checkbox' name='zones"+rowcount+"[]' class='zone' value='1' /> Zone 1: Field</li>"+
			"<li> <input type='checkbox' name='zones"+rowcount+"[]' class='zone' value='2' /> Zone 2: Home team bench, recruiting room</li>"+
			"<li> <input type='checkbox' name='zones"+rowcount+"[]' class='zone' value='3' /> Zone 3: DQ Club Room</li>"+
			"<li> <input type='checkbox' name='zones"+rowcount+"[]' class='zone' value='4' /> Zone 4: Premium Areas (excluding DQ Club)</li>"+
			"<li> <input type='checkbox' name='zones"+rowcount+"[]' class='zone' value='5' /> Zone 5: Visiting team bench, visiting team locker room</li>"+
			"<li> <input type='checkbox' name='zones"+rowcount+"[]' class='zone' value='6' /> Zone 6: 600 level (non-premium areas), interview rooms</li>"+
			"<li> <input type='checkbox' name='zones"+rowcount+"[]' class='zone' value='7' /> Zone 7: Service level working areas </li>"+
			"<li> <input type='checkbox' name='zones"+rowcount+"[]' class='zone' value='8' /> Zone 8: Marching band areas </li>"+
			"</ul></div></dd></dl>  </td></tr>";
					   
					//keep track of our row count
					rowcount++; 
				$("#credNums").val(rowcount);						
												
			$('#table tbody').append(row);

				
		
	});	



$('#addMultiple').click(function() { 
		var numRows = window.prompt("Enter Number of Rows to Add:", "");

		var insideHTML = "";
		
		
		for(var i = 0; i<numRows; i++)
		{
	
		var row = "<tr><th scope='row'>"+parseInt(rowcount)+"</th><td><input type='text' class='form-control' name='credName_"+rowcount+"'></td>"+
			"<td><input type='text' class='form-control' name='credPosition_"+rowcount+"'></td>"+
			"<td><select class='location' name='employeeLocation_"+rowcount+"' id='location"+rowcount+"' required>"+
			"<option value=''>Select Location</option>"+
			"<option value='1'>All Facilities</option>"+
			"<option value='2'>TCF Bank Stadium</option>"+
			"<option value='3'>Williams Arena / Sports Pavilion</option>    "+
			"<option value='4'>Mariucci Arena / Ridder Arena</option>        "+
			"<option value='5'>Outdoor (ELR, JSC, Siebert)</option>"+
			"</select></td>      "+
			"<td><dl class='dropdown' id='markings"+rowcount+"' style='display:none;'>              "+
			"<dt><div class='dropdownLink' id='markings"+rowcount+"'>"+
			"<span class='hidamarkings"+rowcount+"'>Select TCF Marking(s)</span>  "+  
			"<p class='multiSel' id='multiSelmarkings"+rowcount+"'></p></div></dt><dd> "+
			"<div class='multiSelect' id='markings"+rowcount+"'><ul id='selectmarkings"+rowcount+"'>"+
			"<li> <input type='checkbox' name='markings"+rowcount+"[]' class='markings' id='markings"+rowcount+"' value='F' /> Field Access (F)</li>"+
			"<li> <input type='checkbox' name='markings"+rowcount+"[]' class='markings'  id='markings"+rowcount+"' value='P' /> <div id='labelP_Markings0'>Pregame/Postgame Field Access (P)</div> </li>"+
			"<li> <input type='checkbox' name='markings"+rowcount+"[]' class='markings'  id='markings"+rowcount+"' value='E' /> <div id='labelE_Markings0'>Escort Privileges (E)</div></li>"+
			"</ul></div></dd></dl></td><td> <dl class='dropdown' id='zones"+rowcount+"' style='display:none;'>  <dt>"+
			"<div class='dropdownLink' id='zones"+rowcount+"'><span class='hidazones0'>Select TCF Zone(s)</span><p class='multiSel' id='multiSelzones0'></p>  "+
			"</div></dt><dd> "+
			"<div class='multiSelect' id='zones"+rowcount+"'><ul id='selectzones"+rowcount+"'>"+
			"<li> <input type='checkbox' name='zones"+rowcount+"[]' class='zone' value='0' /> Zone 0: Home team locker Room </li>"+
			"<li> <input type='checkbox' name='zones"+rowcount+"[]' class='zone' value='1' /> Zone 1: Field</li>"+
			"<li> <input type='checkbox' name='zones"+rowcount+"[]' class='zone' value='2' /> Zone 2: Home team bench, recruiting room</li>"+
			"<li> <input type='checkbox' name='zones"+rowcount+"[]' class='zone' value='3' /> Zone 3: DQ Club Room</li>"+
			"<li> <input type='checkbox' name='zones"+rowcount+"[]' class='zone' value='4' /> Zone 4: Premium Areas (excluding DQ Club)</li>"+
			"<li> <input type='checkbox' name='zones"+rowcount+"[]' class='zone' value='5' /> Zone 5: Visiting team bench, visiting team locker room</li>"+
			"<li> <input type='checkbox' name='zones"+rowcount+"[]' class='zone' value='6' /> Zone 6: 600 level (non-premium areas), interview rooms</li>"+
			"<li> <input type='checkbox' name='zones"+rowcount+"[]' class='zone' value='7' /> Zone 7: Service level working areas </li>"+
			"<li> <input type='checkbox' name='zones"+rowcount+"[]' class='zone' value='8' /> Zone 8: Marching band areas </li>"+
			"</ul></div></dd></dl>  </td></tr>";

					insideHTML += row;
					
					$("#credNums").val(rowcount);		
					
					//keep track of our row count
					rowcount++;
					
										
			}							
										
		$('#table tbody').append(insideHTML);




		
	
	});	
	
});
    

			

</script>


</body>
</html>
<?php
$page->db = NULL;
?>