<?php 
include($_SERVER['DOCUMENT_ROOT'] . "/include/db_connect.php");

if (isset($_GET["sport"]) && is_numeric($_GET["sport"])) { 
	$sport = array();
	$sport["module_id"] = "%".$_GET["sport"]."%"; 
	//Search the credentials_single_game_types table for the credential types for this sport
	$sth = $db->prepare("SELECT id, type FROM credentials_single_game_types WHERE sport='All' OR sport LIKE :module_id ORDER BY type");
	$er = $sth->execute($sport);
	if ($er != false) { 
		$select_active = "<select name='row[1][credential_type]' class='lastrow'>";
		$select_hidden = "<select name='hidcredtype' class='lastrow'>";
		while ($type = $sth->fetch(PDO::FETCH_ASSOC)) { 
			$select_active .= "<option value='".$type["id"]."'>".$type["type"]."</option>";
			$select_hidden .= "<option value='".$type["id"]."'>".$type["type"]."</option>";
		}
		$select_active .= "</select>";
		$select_hidden .= "</select>";
	}
	?> 
    <h2>Credential details</h2>
    <hr/>
    <p>Add the names of each person for whom you are requesting a credential. <strong>Tip:</strong> If your cursor is in the last row in this list, pressing the "Enter" or "Tab" key will add a new row.</p>
    <p><table cellpadding="5" cellspacing="1" style="background-color:#FFFFFF;" id="fields">
        <thead>
        <tr>
        <td class="cellLabel">Type</td>
        <td class="cellLabel">Name</td>
        <td class="cellLabel">Affiliation/Department</td>        
        </tr>
        </thead> 
        <tbody>
        <tr style="background-color:#FFFFFF;" id="row1" class="grid">
        <td><select name='row[1][credential_type]' class='lastrow' id="type">
        		<option value="1">Media</option>
        		<option value="2">Photo</option>
        		<option value="3">Marching Band</option>                                 
        		<option value="4">Football Family</option>  
        		<option value="5">Team VIP</option>                  
        		<option value="6">Premium Guest</option>  
        		<option value="7">DQ Club Guest</option>  
        		<option value="8">Game Services</option>  
        		<option value="9">Vendor/Contractor</option>  
        		<option value="10">Event Production</option>   
        		<option value="11">Field VIP</option>  
        		<option value="12">Recruit</option>  
        		<option value="13">Pregame Guest</option>                 
        		<option value="14">Other</option>                                                                                                                                                   
            </select>  
            </td>
        <td><input type="text" name="row[1][credential_name]" size="25" id="person" class="lastrow" /></td>
        <td><input type="text" name="row[1][credential_aff]" size="25" id="person" class="lastfield lastrow" /></td>        
        </tr> 
        <tr style="background-color:#FFFFFF; display:none;" id="homerow">
        <td><select name='hidcredtype' class='lastrow' id="type">
        		<option value="1">Media</option>
        		<option value="2">Photo</option>
        		<option value="3">Marching Band</option>                                 
        		<option value="4">Football Family</option>  
        		<option value="5">Team VIP</option>                  
        		<option value="6">Premium Guest</option>  
        		<option value="7">DQ Club Guest</option>  
        		<option value="8">Game Services</option>   
        		<option value="9">Vendor/Contractor</option>  
        		<option value="10">Event Production</option>   
        		<option value="11">Field VIP</option>  
        		<option value="12">Recruit</option>  
        		<option value="13">Pregame Guest</option>                 
        		<option value="14">Other</option>                                                                                                                                                   
            </select></td>
        <td><input type="text" name="hidcredname" size="25" id="person" class="lastrow" /></td>
        <td><input type="text" name="hidcredaff" size="25" id="person" class="lastfield lastrow" /></td>        
        </tr>
        </tbody>
    </table></p> 
    <p><strong>To add another person:</strong> Place your cursor is in the last row in this list, pressing the "Enter" or "Tab" key will add a new row.</p>
    <div id="massUpload">Mass Upload</div>
    <h2>Request Comments / Notes:</h2>
    <hr/> 
    <p>If you have any comments or notes you would like to add to this request, please note them here:</p>
    <textarea id="notes" name="notes"></textarea>
    <hr/>
    <?php 
} else { 
	?>
    <p>Error retrieving person list.</p>
  <?php } ?> 
  

  <?php  
//*************************************
// HIDDEN FORM LARGE LIST ENTRY
//*************************************
?>
<div id="largeListUpload" style="display:none;" title="Upload Person List">
 
    <form>
        <textarea id="listUpload" name="listUpload" rows="4" cols="50">Enter full names separated by commas or returns...</textarea>
        <div id="addNames" name="submit">Add Names</div>
    
    </form>

</div>

 <script type="text/javascript" src="/include/jquery/jquery.js"></script> 
<script type="text/javascript" src="/include/jquery/jquery.tablesorter.js"></script>
<script type="text/javascript" src="/include/jquery/jquery.ui.js"></script>
<script type="text/javascript" src="/include/jquery/jquery.validate.js"></script>
<script src="/include/jquery/jquery.maskedinput.js"></script>
<script type="text/javascript">
$(function(){

  
function createRow() 
{
		alert("createRow clicked!");
		var table = document.getElementById("fields");
  
		var row = table.insertRow(0);
		var x = document.getElementById("myTable").rows.length;
		
		var row = table.insertRow(x);
		var cell1 = row.insertCell(0);
var cell2 = row.insertCell(1);

  cell1.innerHTML = "NEW CELL1";
  cell2.innerHTML = "<input type='text' name='row["+ x + "][credential_name]' size='25'/>";
  
} 

	$('#massUpload').click(function() { 
		alert("HERE");
		$('#largeListUpload').dialog("open");
		$(".ui-dialog-content").css("height", "400px");
	});

	var count = 0;
	$('#largeListUpload').dialog({
		autoOpen: false,
		height: 400,
		width: 500,
		modal: true,
		buttons: {
			Save: function() {

		
				count = count + 1;
	
			   var row = "<td><select name='row[1][credential_type]' class='lastrow' id='type'>"+
								"<option value='1'>Media</option>"+
								"<option value='2'>Photo</option>"+
								"<option value='3'>Marching Band</option>  "+                               
								"<option value='4'>Football Family</option> "+ 
								"<option value='5'>Team VIP</option>        "+          
								"<option value='6'>Premium Guest</option>  "+
								"<option value='7'>DQ Club Guest</option>  "+
								"<option value='8'>Game Services</option>  "+
								"<option value='9'>Vendor/Contractor</option> "+  
								"<option value='10'>Event Production</option> "+  
								"<option value='11'>Field VIP</option>  "+
								"<option value='12'>Recruit</option>  "+
								"<option value='13'>Pregame Guest</option>    "+             
								"<option value='14'>Other</option>      "+                                                                                                                                             
								"</select>  "+
								"</td>"+
								"<td><input type='text' name='row[1][credential_name]' size='25' id='person' class='lastrow' value='test'/></td>"+
								"<td><input type='text' name='row[1][credential_aff]' size='25' id='person' class='lastfield lastrow' /></td>   ";
				 	
				row = row.replace("row[1","row["+(count));
				row = row.replace("row[1","row["+(count));
				row = row.replace("row[1","row["+(count));
							
				//alert(row); 
								
				 $('#fields tbody').append(row);

 

				$(this).dialog("close");
				
				/*if ($('#newform').validate({
					rules: {
						new_key_type: "required",
						new_building: "required",
						new_slot: "required"
					},
					messages: { 
						new_key_type: "*Required.",
						new_building: "*Required.",
						new_slot: "*Required."
					}			
				}).form() === true) { 
					$(this).dialog("close");
					$('#newform').submit();
				} */
			},
			Cancel: function() {
				$(this).dialog("close");
			}
		}
	});
	});
<?php 

$db = NULL;
?>