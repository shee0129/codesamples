<?php
include($_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php");
$page = new Web_Page(199); 
$title = "Daily Gopher Admin Page";
$page->setPermissions(199);
//$page->printHeader();
include($_SERVER['DOCUMENT_ROOT'] . "/gopherdaily/includes/header.php");    


?>
<style>
#postLink
{
	color: #761E2E;
	font-weight:700;
	text-decoration:none; 
}
.editPostSubTitle
{
	font-size: 24px;
	font-weight: 700;
	color: #000000;
	text-align:left;
	padding-bottom: 15px;
	padding-left: 10px;
}
</style>
<div class="addPostTitle">Admin Page</div>

    <div class="editorContainer" id="editorContainer">
 
            
<?php   
		

if(isset($_POST["submit"]))
{
	
		
	if(!empty($_FILES['imagefile']) && $_FILES['imagefile']['error'] == 0 && $_FILES['imagefile']['size'] != 0) 
	{
		$photo_uploaded = true;
		
	
		
		if(is_uploaded_file($_FILES['imagefile']['tmp_name'])) {	
		
			if (!copy ($_FILES['imagefile']['tmp_name'],"../files/" .stripslashes($_FILES['imagefile']['name']))) { 
				echo "<h3>There was a problem uploading the file to the server - please contact ".$page->webmaster."</h3>";		
				
				$page->modification_date = filemtime($_SERVER['SCRIPT_FILENAME']);
				
				$page->db = NULL;
				die();
			}
		
			echo "<h3>File upload completed.</h3>";
		
		
		
			$execute = array();
			$filesid = ""; 
			$insertquery = $page->db->prepare("INSERT INTO files SET module='199',
			active='1',
			name='".$_FILES['imagefile']['name']."', 
			size='".$_FILES['imagefile']['size']."', 
			type='".$_FILES['imagefile']['type']."', 
			timestamp=" . time() . ", 
			user='".$page->user."'");
		
			if (!$insertresult = $insertquery->execute($execute)) { 
				echo "<h3>There was a problem inserting the record into the database. Please contact ".$page->webmaster.".</h3>";
			
			
			} else {
				//echo "<h3>Media was successfully inserted into the database.</h3>";
				$maxid = array();
				$maxid_q = "SELECT max(id) as id FROM files";
				$maxid_r = $page->db->query($maxid_q);
				$maxid = $maxid_r->fetch(PDO::FETCH_ASSOC);	
				$filesid = $maxid['id'];
			}
		}
	}
	else{
		$filesid = $_POST["relatedfiles_id"];
	}
	
						/*###Handle Link (if submitted) ###*/
				 	if(isset($_POST["mediaLink"]))
					{
						if (strpos($_POST["mediaLink"],'youtu') !== false) 
						{		//youtube video 
							$mediaLink = $_POST["mediaLink"];
							//echo("<br/>mediaLink3 " . $mediaLink);
							$slash = strrchr($mediaLink, "/");
							//echo("<br/>SLASH " . $slash);
							$mediaLink = substr($mediaLink, 16);		//http://www.youtube.com/embed/XGSy3_Czz8k
							//echo("<br/>mediaLink2 " . $mediaLink);
							//$mediaLink = $mediaLink;
							
							
						}else 
						{ 	//vimeo video
							$mediaLink = $_POST["mediaLink"];
						}
					}
	
	
	//###################################### SELECT HAS BEEN CLICKED ##################################################/
	switch ($_POST["submit"])
	{

		case "Cancel":
			unset($_POST["id"]);
			break;
		case "Delete Post":
			$del_loc = $page->db->query("UPDATE mainpage_posts SET published = '-1' WHERE id=". $_POST["id"]);
			$del_res = $del_loc->fetch(PDO::FETCH_ASSOC);
/*
$tags_array = array();
							$tags_array = explode(",", $_POST['tags']);
							//echo "Tags count: " . count($tags_array);
							foreach ($tags_array as $key => $value) {
								
									$query = "UPDATE  mainpage_tags SET count = count - 1
												WHERE tag_title like  \"". $value."\"";
									$insert = $page->db->query($query); 	
							}*/

			if (!$del_loc) {
				echo "<h3>There was a problem deleting the post from the database. Please contact ".$page->webmaster.".</h3>";
			} else {
				echo "<h3>The post was successfully deleted from the database.</h3>";
				echo "<h3><a href='admin.php'>Back to Admin Page</a></h3>";
			}

			unset($_POST["id"]);
			break;	
		case "Save":
				
				$query = "UPDATE mainpage_posts
							SET title = \"".$_POST["title"]."\",
							subtitle = \"".$_POST["subtitle"]."\",
							content = \"".str_replace('"', "'", $_POST["editor1"])."\",
							tags = \"".$_POST["tags"]."\",
							user = \"".$_POST["user"]."\",
							relatedfiles_id = \"".$filesid."\",
							media_link = \"".$mediaLink."\"						
							WHERE id = " .$_POST["id"]	;	
								
				$insert = $page->db->query($query); 
				
				if ($insert != false) { 
					echo ("You post has now been <b>saved</b>. <br/>");
				}
				else
				{
					echo ("<br/><i>There was an issue posting. Please contact ".$page->webmaster.".</i>");
				}
		
			break;
		case "Save & Unpublish":


				$query = "UPDATE mainpage_posts
							SET title = \"".$_POST["title"]."\",
							subtitle = \"".$_POST["subtitle"]."\",
							content = \"".str_replace('"', "'", $_POST["editor1"])."\",
							tags = \"".$_POST["tags"]."\",							
							user = \"".$_POST["user"]."\",
							relatedfiles_id = \"".$filesid."\",
							media_link = \"".$mediaLink."\",	
							published = '0'
							WHERE id = " .$_POST["id"]	;								
				
				$insert = $page->db->query($query); 
				
				if ($insert != false) { 
					echo ("You post has now been <b>saved</b> and <b>unpublished</b>. Please go to <a href='admin.php'>Admin</a> page.<br/>");
				}
				else
				{
					echo ("<br/><i>There was an issue posting. Please contact ".$page->webmaster.".</i>");
				}
		
			break;	
		case "Save & Publish":

				$query = "UPDATE mainpage_posts
							SET title = \"".$_POST["title"]."\",
							subtitle = \"".$_POST["subtitle"]."\",
							content = \"".str_replace('"', "'", $_POST["editor1"])."\",
							tags = \"".$_POST["tags"]."\",
							timestamp = \"".time()."\",
							user = \"".$_POST["user"]."\",
							relatedfiles_id = \"".$filesid."\",
							media_link = \"".$mediaLink."\",	
							published = '1'
							WHERE id = " .$_POST["id"]	;		

				$insert = $page->db->query($query); 
				
				if ($insert != false) { 
					echo ("<br/><i>Post has been published. See the post <a href='http://www.athletics.umn.edu/gopherdaily'>here</a>. Or you can go to the <a href='admin.php'>Admin</a> page.</i><br/>");
				}
				else
				{
					echo ("<br/><i>There was an issue posting. Please contact ".$page->webmaster.".</i>");
				}
		
			break;		
	
		
	}
}
	
if(isset($_GET["id"]))
{ 
	//###################################### VIEW / EDIT SELECTED POST ##################################################/
	echo ("<a id='postLink' href='admin.php'>Back to Admin Page</a>
		<br/>
		<hr/>
			<div class=\"editPostSubTitle\">Edit Post</div>");
	
	$id = $_GET["id"];
	
	$edit_posts = array();
	$edit_posts_q = "SELECT mp.*, f.name as filename
						FROM mainpage_posts mp
						LEFT JOIN files f
						ON mp.relatedfiles_id = f.id
						WHERE mp.id = " . $id;
	$edit_posts_r = $page->db->query($edit_posts_q);
	$edit_posts = $edit_posts_r->fetchAll(PDO::FETCH_ASSOC);	
	
	foreach($edit_posts as $ep)
	{
 
?>


             
 <form name="form1" id="form1" method="post" enctype="multipart/form-data">
 <table cellpadding="2">
  

						<tr><td><div class="inputTitle">Post Title:</div></td><td><input type="text" value="<?php echo $ep['title']; ?>" id="title" name="title" size="45"/>           </td></tr>
						<tr><td><div class="inputTitle">Post Sub Title:</div></td><td><input type="text" value="<?php echo $ep['subtitle']; ?>" id="subtitle" name="subtitle" size="45"/>            </td></tr>
						<tr><td><div class="inputTitle">Author:</div> </td><td><input type="text" value="<?php  echo Web_Data::get_fullname($ep['user'],$page->db); ?>" id="user" name="user"/>                     </td></tr>
					</table>  
                    <div style="padding: 20px 0px;"  >
                   	<table cellpadding="2">                   
						<tr><td><div class="inputTitle">Top Media:</div> </td><td>Attachment: </td><td><input type="file" name="imagefile"></td></tr>       
                        <?php
							if ( $ep['filename'] != "")
							{
								echo ("<tr><td></td><td>Current attachment:</td><td>". $ep['filename'] . "</td></tr>");
							}
						
						?>
						<tr><td style="text-align:right;"><span style="font-size: 12px; font-style: italic;">1 media file/link allowed. </span></td>
                        	<td>Link:</td><td> <?php 
										//$media_link = $ep['media_link'] . "--";
										if($ep['media_link'] == "")
											$media_link ="";
										else
											$media_link = "http://youtu.be/".$ep['media_link']; 
													
									
									?><input type="text" id="mediaLink" name="mediaLink" size="35" value="<?php echo $media_link;?>"> <span style="font-size: 12px; font-style: italic; text-align:right;">Youtube videos ONLY </span></td></tr>                                       
					</table>
					</div>
					
					
					
					 <textarea name="editor1" id="editor1" rows="10" cols="80"><?php echo $ep['content']; ?>                </textarea>
				<script>
					// Replace the <textarea id="editor1"> with a CKEditor
					// instance, using default configuration.
					CKEDITOR.replace( 'editor1' );
				</script>
	
					<table cellpadding="2">
						<tr><td>Tags:</td><td><input type="text" id="tags" name="tags" value="<?php echo $ep['tags']; ?>"/>           </td></tr>
						<tr><td></td><td><i>Separate tags with commas</i></td></tr>
					</table> 
 					<input type="hidden" value="<?php echo $ep['relatedfiles_id']; ?>" name="relatedfiles_id" />                   
					<input type="hidden" value="<?php echo $ep['id']; ?>" name="id" />
                    <div style="padding: 20px 0px; text-align: center;"  >
                          <?php if($ep['published'] == 0) 
						  {					  
						  ?>
					<input type="submit" value="Save"id="submit" name="submit"/>	
                    <input type="submit" value="Save & Publish" id="submit" name="submit"/>
                     <?php } else if($ep['published'] == 1) 
						  {					  
						  ?>
                          		<input type="submit" value="Save & Unpublish" id="submit" name="submit"/>	
								<input type="submit" value="Save" id="submit" name="submit"/>	
                     <?php } 			  
						  ?>
					<input type="submit" value="Delete Post" id="submit" name="submit"/>                              
    				</div>
                    </form>
    
    
    <?php
		
	}
}	 
	else 
	{
		//###################################### MAIN POST PAGE SETUP ##################################################/
		if(isset($_GET["posts"]))
		{
			if($_GET["posts"] == "published")
				$post_where = "WHERE published = 1";
			else if($_GET["posts"] == "unpublished")
				$post_where = "WHERE published = 0";				
			else if($_GET["posts"] == "trash")
				$post_where = "WHERE published = -1";						
		}
		else
		{
			$post_where = "WHERE published >= 0";	
		}
		
		$post_counts = array(); 
		$post_counts_query = "SELECT count(*) as allSum,
									sum(case when published = 1 then 1 else 0 end) publishedSum,
									sum(case when published = 0 then 1 else 0 end) unpublishedSum,
									sum(case when published = -1 then 1 else 0 end) trash
								FROM mainpage_posts";
		$post_counts_r = $page->db->query($post_counts_query);
		$post_counts = $post_counts_r->fetch(PDO::FETCH_ASSOC);										
		

	
	
	?>
    
    <div style="padding: 10px 0px;">

    	<?php
			if(isset($_GET["posts"]))
			{
					?>
				 <a href="admin.php"> All</a> (<?php echo $post_counts['allSum']; ?>)|		
                  	<?php		
			}
			else
			{
            	?>
				 <strong> All</strong> (<?php echo $post_counts['allSum']; ?>)|
                  	<?php
			}
			if(isset($_GET["posts"]) && $_GET["posts"] == "published")
			{
					?>
            	     <strong>Published</strong>  (<?php echo $post_counts['publishedSum']; ?>)   | 
                  	<?php		
			}
			else
			{
            	?>
			     <a href="admin.php?posts=published"> Published</a>   (<?php echo $post_counts['publishedSum']; ?>)   | 	
                  	<?php
			}			
			if(isset($_GET["posts"]) && $_GET["posts"] == "unpublished")
			{
					?>
            	     <strong>Unpublished</strong>  (<?php echo $post_counts['unpublishedSum']; ?>)   | 
                  	<?php		
			}
			else
			{
            	?>
			     <a href="admin.php?posts=unpublished"> Unpublished</a>   (<?php echo $post_counts['unpublishedSum']; ?>)   | 
                  	<?php
			}		
			if(isset($_GET["posts"]) && $_GET["posts"] == "trash")
			{
					?>
            	     <strong>Trash</strong>  (<?php echo $post_counts['trash']; ?>)   
                  	<?php		
			}
			else
			{
            	?>
			     <a href="admin.php?posts=trash"> Trash</a>   (<?php echo $post_counts['trash']; ?>)   
                  	<?php
			}						
		
		?>
    
     </div>
    <table cellpadding="2" style="width:100%;" id="adminTable" frame="box">
    <thead>
    <tr style="background-color:#761E2E; font-weight:bold; color:#FCBA3D;">
        <th align="Left", width="45%">Title</th>
        <th align="center">Author</th>
        <th align="center">Tags</th>        
        <th align="center"><i class="icon-comment"></i></th>
        <th align="center">Date</th>
    </tr>
    </thead> 
    <tbody> 
    
    <?php
	$posts = array();
	$posts_q = "SELECT p.id, title, content, p.timestamp, p.tags, p.user, count(c.id) as comments, p.published
				FROM mainpage_posts p
				LEFT JOIN mainpage_comments c
				ON p.id = c.post_id				
				$post_where
				GROUP by p.id
				ORDER BY p.timestamp desc";
	$posts_r = $page->db->query($posts_q);
	$posts = $posts_r->fetchAll(PDO::FETCH_ASSOC);		
	
	$bg_color1 = "#FFFFFF";
	$bg_color2 = "#FFFFCC";
	
	$count = 0;
	
	foreach ($posts as $p)
	{
			if(($count%2) == 1)
			{			
				echo ("<tr style='height:50px; background-color: " .$bg_color1.";'>");
			}
			else
			{
				echo ("<tr style='height:50px; background-color: " .$bg_color2.";'>");				
			}
			
			echo("<td><a id='postLink' href='admin.php?id=" . $p['id'] . "'>");
			
				if($p['title'] != "")
				{		echo( $p['title'] . "</a></td>");
				}
				else		
				{
					$content = "";
					$content = str_replace("<p>", "", $p['content']);
					$content = str_replace("</p>", "", $content);					
					$content = substr($content, 0, 45);
					$content = "<i>Quote:</i> " .$content . "..." ;
					echo( $content . "</a></td>");
				}

			echo("<td>" . Web_Data::get_fullname($p['user'],$page->db) . "</td>");

			echo("<td align=\"center\">" . $p['tags'] . "</td>");
			
			echo("<td align=\"center\">" . $p['comments'] . "</td>");
			

			echo("<td align=\"center\">" . date("Y/m/d",$p["timestamp"]) . "
				<br/>");
				
				if($p['published'] == 1)
					echo ("Published");
				elseif($p['published'] == 0)
					echo ("Unpublished");					
				echo("</td>");						
			
			$count++;
			
			
		echo ("</tr>");	
	}
	
	
	
	}
	
	
	?>        	
        
       </tbody>
    </table>
    
    </div>
      
            
<script src="/include/jquery/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript" src="/include/jquery/jquery.tablesorter.js"></script>
<script type="text/javascript">

$(function(){

	$('#adminTable').tablesorter({
		sortList: [[4,1]] 
	});
	
	var bodyheight = $('#mainleft').height();
	var editorHeight = $('#editorContainer').height();
	
	if(editorHeight < bodyheight) 
		$('#editorContainer').height(bodyheight);

	
	
});
</script>  
       <?php        
  include($_SERVER['DOCUMENT_ROOT'] . "/gopherdaily/includes/footer.php");          
  ?>