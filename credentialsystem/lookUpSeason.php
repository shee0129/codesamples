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
    <title>Look Up Season Credential</title>

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



  </style>
</head>
<body>

<div class="container">
<?php echo print_r($_POST); echo "<br/>".print_r($_FILES); ?>
<div class="page-header">
  
  <h1><img src="https://www.athletics.umn.edu/images/m.gif" hspace="10" /> Season Working Credentials</h1>
</div>


<?php
if(isset($_POST['credID']) && $_POST['credID'] > 0)
{


?>
	<div style="width:50%">
        <div class="panel panel-default">
          <div class="panel-heading">Your Contact Information</div>
          <div class="panel-body">
          
           
            
            <div class="form-group row">
                <label for="contactName" class="col-sm-4 form-control-label">Name:</label>
                <div class="col-sm-8">
                <input type="text" class="form-control" name="contactName" placeholder="John Doe">
                </div>
            </div>
            
            <div class="form-group row">
                <label for="contactPhone" class="col-sm-4 form-control-label">Phone:</label>
                <div class="col-sm-8">
                  <input type="text"  class="form-control" name="contactPhone" placeholder="(555)555-5555">
                </div>
            </div>
            
            <div class="form-group row">
                <label for="contactEmail" class="col-sm-4 form-control-label">Email:</label>
                <div class="col-sm-8">
                  <input type="email" class="form-control" id="contactEmail" name="contactEmail" placeholder="john_doe@example.com">
                </div>
            </div>
            
            <div class="form-group row">
            <label for="contactAffiliation" class="col-sm-4 form-control-label">Affiliation:</label>
                <div class="col-sm-8">
                    <select name="affiliation" class="form-control" id="affiliation">
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

    <div style="width:50%">
        <div class="alert alert-warning" role="alert">
          <a href="#" class="alert-link">Did you submit a credential last year? See it now!</a>
        </div>
    </div>


	<div style="width:100%">
        <div class="panel panel-default">
          <div class="panel-heading">Credential Details</div>
          <div class="panel-body">
          	<p>Add the names of each person for whom you are requesting a credential.</p>		<p>Don't know what TCF Zones to select? <a href="2015_Credential_Zones_Map.pdf" target="_blank">Click here</a> to read detailed descriptions of each TCF Zone.</p>
              
 
            <table class="table" id="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Position</th>
                  <th>Employee Type</th>
                  <th>Credential Location</th>    
                  <th></th>
                  <th></th>        
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td><input type="text" class="form-control" name="credName_1"></td>
                  <td><input type="text" class="form-control" name="credPosition_1"></td>
                  <td><select name="employeeType_1" class="form-control" id="employeeType_1" required>
        	<option value="">Select Employee Type</option>
            <option value="1">Staff (Full time employees and full time interns)</option>
            <option value="2">Event (part time employee/students)</option>
       		</select> </td>
                  <td><select class="location" name='employeeLocation_1' id="location1" required>
        	<option value="">Select Location</option>
            <option value="1">All Facilities</option>
            <option value="2">TCF Bank Stadium</option>
            <option value="3">Williams Arena / Sports Pavilion</option>    
            <option value="4">Mariucci Arena / Ridder Arena</option>        
            </select></td>      
            <td>      <dl class="dropdown" id="markings1" style="display:none;">              
                <dt>
                    <div class="dropdownLink" id="markings1">
                    <span class="hidamarkings1">Select Marking(s)</span>    
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
              <span class="hidazones1">Select Zone(s)</span>    
              <p class="multiSel" id="multiSelzones1"></p>  
            </div>
            </dt>
          
            <dd> 
                <div class="multiSelect" id="zones1">
                    <ul id="selectzones1">
                        <li> <input type='checkbox' name='zones1[]' class='zone' value='0' /> Zone 0: Home team locker Room </li>
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


	<div style="width:75%">
        <div class="panel panel-default">
          <div class="panel-heading">Request Comments / Notes:</div>
          <div class="panel-body">
 
    <p>Indicate explanation for why Zones were selected. </p>
    <p>If you have any comments or notes you would like to add to this request, please note them here:</p>
    <textarea  class="form-control"  id="notes" name="notes"></textarea> 
           </div><!--panel-body-->
        </div><!--panel panel-default-->
	</div> <!--panel panel-default container-->   
  
<div id="fileNames"></div>

            </form>  

<div style="width:75%">
        <div class="panel panel-default">
          <div class="panel-heading">Headshots:</div>
          <div class="panel-body">
 
    <p>If any of the above requested credentials' headshot are not in the system (have not been requested before) AND are not full-time employees at Gopher Athletics, please upload their headshot below. </p>
    <p>Headshot format: Image should be at least 150 DPI and at least 2" wide by 3" tall. It should not exceed 6 MB.</p>
    <p>Label each file as: <span style="font-family:'Courier New';">Last Name, First Name – Department </span></p>
    
   <!-- <input type="file" class="form-control-file" id="headshot">
   
   <input type="file" class="form-control-file" id="headshot" name="headshots[]"  multiple="multiple">
<small class="text-muted">
Choose Files
Hint: To select more than 1 image, use CTRL or SHIFT when selecting images.
</small>-->

<!--<form action="/upload-target" class="dropzone"></form>-->
<!--
<form action="js/uploads.php" class="dropzone" id="dropzoneForm" method="post" enctype="multipart/form-data">
 <div class="fallback">
    <input name="file" type="file" multiple />
  </div>
</form>-->

<form action="js/uploads.php" class="dropzone" id="dropzoneForm" method="post" enctype="multipart/form-data">
 <div class="fallback">
    <input name="file" type="file" multiple />
  </div>
</form>


<hr/>

  <p style="margin-top:50px;">Confused? Need help? Email <a href="mailto:rhie0012@umn.edu">Geoff Rhiel</a> in Gopher Athletics Event Management.</p>
       
<div style="border-top: 2px solid #761e2e; padding: 20px 0px; margin-top: 15px;">
<img src="https://www.athletics.umn.edu/images/m.gif" hspace="10" /> <a href="index.php">Back to Credential Request Home Page</a>

</div>


<?php 

}

?>
</div><!---CONTAINER-->



</body>
</html>
<?php
$page->db = NULL;
?>