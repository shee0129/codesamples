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
<?php   //echo print_r($_POST); echo "<br/>".print_r($_FILES); ?>
<div class="page-header">
  
  <h1><img src="https://www.athletics.umn.edu/images/m.gif" hspace="10" /> Season Working Credentials - 2015 Requests</h1>
</div>


<?php
if(isset($_GET['name']) || isset($_GET['phone']) || isset($_GET['email']) )
{
	$lookUp = array();  
	$lookUp_q = "SELECT * FROM credentials_photo_request
				WHERE (name = '".$_GET['name']."' OR phone = '".$_GET['phone']."' OR email = '".$_GET['email']."')";
			//echo ($lookUp_q);
	$lookUp_r = $page->db->query($lookUp_q);
	$lookUp = $lookUp_r->fetchAll(PDO::FETCH_ASSOC);

	foreach($lookUp as $lU)
{
?>
	<div style="width:50%">
		<div class="panel panel-default">
			<div class="panel-heading">Your Contact Information</div>
			<div class="panel-body">


				<div class="form-group row">
					<label for="contactName" class="col-sm-4 form-control-label">Name:</label>
					<div class="col-sm-8">
						<?php echo $lU['name']; ?>
					</div>
				</div>

				<div class="form-group row">
					<label for="contactPhone" class="col-sm-4 form-control-label">Phone:</label>
					<div class="col-sm-8">
						<?php echo $lU['phone']; ?>
					</div>
				</div>

				<div class="form-group row">
					<label for="contactEmail" class="col-sm-4 form-control-label">Email:</label>
					<div class="col-sm-8">
						<?php echo $lU['email']; ?>
					</div>
				</div>

				<div class="form-group row">
					<label for="contactAffiliation" class="col-sm-4 form-control-label">Affiliation:</label>
					<div class="col-sm-8">
						<?php

						$affiliation_id = $lU['affiliation'];

						$affiliation_id = substr($affiliation_id, 0, 3);
						//echo $affiliation_id;
						if ($affiliation_id != 999) {
							$affiliation = array();
							$affiliation_q = "SELECT * FROM modules
									WHERE id = " . $affiliation_id;
							//echo ($affiliation_q);
							$affiliation_r = $page->db->query($affiliation_q);
							$affiliation = $affiliation_r->fetch(PDO::FETCH_ASSOC);

							echo $affiliation['name'];
							echo "</div></div> ";
						} else {
							$affiliation_nme = substr($lU['affiliation'], 4);
							echo "Non-Athletic Department</div></div> ";

							echo '<div class="form-group row">';
							echo '<label for="otherAffiliation" class="col-sm-4 form-control-label"></label>';
							echo '<div class="col-sm-8">';
							echo $affiliation_nme;

							echo '</div></div>  ';


						}


						?>
					</div><!--panel-body-->
				</div><!--panel panel-default-->
			</div> <!--panel panel-default container-->


			<div style="width:100%">
				<div class="panel panel-default">
					<div class="panel-heading">Credential Details</div>
					<div class="panel-body">


						<table class="table" id="table">
							<thead>
							<tr>
								<td class="cellLabel">Name</td>
								<td class="cellLabel">Employee Type</td>
								<td class="cellLabel">Location</td>
								<td class="cellLabel" id="zonesHead0">Markings(if applicable)</td>
								<td class="cellLabel" id="zonesHead0">Zones(if applicable)</td>
							</tr>
							</thead>
							<tbody>
							<?php

							$detailsLookUp = array();
							$detailsLookUp_q = "SELECT * FROM credentials_photo_details 
									WHERE request_id = " . $lU['id'];
							$detailsLookUp_r = $page->db->query($detailsLookUp_q);
							$detailsLookUp = $detailsLookUp_r->fetchAll(PDO::FETCH_ASSOC);

							foreach ($detailsLookUp as $dL) {
								echo "<tr>";

								switch ($dL['emp_type']) {
									case "1":
										$type = "Staff";
										break;
									case "2":
										$type = "Event";
										break;
									case "3":
										$type = "Media";
										break;
								}

								switch ($dL['location']) {
									case "1":
										$location = "All Facilities";
										break;
									case "2":
										$location = "TCF Bank Stadium";
										break;
									case "3":
										$location = "Williams Arena / Sports Pavillion";
										break;
									case "4":
										$location = "Mariucci Arena / Ridder Arena";
										break;
								}


								echo "<td>" . $dL['name'] . "</td>";
								echo "<td>" . $type . "</td>";
								echo "<td>" . $location . "</td>";
								echo "<td>" . $dL['markings'] . "</td>";
								echo "<td>" . $dL['zones'] . "</td>";

								echo "</tr>";
							}

							?>

							</tbody>
						</table>


					</div><!--panel-body-->
				</div><!--panel panel-default-->
			</div><!-- panel panel-default container-->


			<div style="width:75%">
				<div class="panel panel-default">
					<div class="panel-heading">Request Comments / Notes:</div>
					<div class="panel-body">

						<?php echo $lU['notes']; ?>
					</div><!--panel-body-->
				</div><!--panel panel-default-->
			</div><!-- panel panel-default container-->


			<div style="width:75%">
				<div class="panel panel-default">
					<div class="panel-heading">Headshots:</div>
					<div class="panel-body">


						<?php
						if ($lU['headshot_file_ids'] != "") {


							$headshots_q = "SELECT name
									FROM files
									WHERE id in (" . $lookUp['headshot_file_ids'] . ")";

							//echo $headshots_q;
							$headshots = array();
							$headshots_r = $page->db->query($headshots_q);
							$headshots = $headshots_r->fetchAll(PDO::FETCH_ASSOC);

							foreach ($headshots as $h) {
								echo('<a href="headshots/' . $h['name'] . '" target="_blank">' . $h['name'] . '</a><br/>');
							}


						}
						?>
					</div><!--panel-body-->
				</div><!--panel panel-default-->
			</div><!-- panel panel-default container-->

<hr/>
			<?php
			}
}
else
{
	echo "<h2>Please use a credential ID.</h2>";
}
?>
</div><!---CONTAINER-->



</body>
</html>
<?php
$page->db = NULL;
?>