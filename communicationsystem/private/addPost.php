<!----
+-------------------------------------------------------------------------------------+
 | File Name: addPost.php		                                                      |
 | Page name: The Gopher Daily Add Post							                      |
 | Author: Krista Sheely                                                              |
 | Written: 09/2015                                                                   |
 | Tables: mainpage_tags, mainpage_posts                         					  |
 | Description: Page that allows admin to add Posts. Images, video, and other files	  |
 |			can also be attached to the post both as a header and embeded within	  |
 | 			the post.																  |
 | Updates: 												                          |
 |  																                  |
 |														                              |
+-------------------------------------------------------------------------------------+
--->
<?php
include($_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php");
$page = new Web_Page(199);
$title = "Gopher Daily Add Post";
$page->setPermissions(199);
include($_SERVER['DOCUMENT_ROOT'] . "/gopherdaily/includes/header.php");
?>

  	<div class="addPostTitle">Add New Post</div>
            
            <div class="editorContainer" id="editorContainer">
 
				<?php 
           		 if (isset($_POST["submit"]))
				{ 
					if($_POST["submit"] == "Save")
					{
						$publish = 0;
						$message = "You post has now been <b>saved</b>. It is NOT have been published yet. If you would like to publish this post, please click 'Save & Publish' below or go to <a href='admin.php'>Admin</a> page.";
					}
					else if($_POST["submit"] == "Save & Publish")
					{
						$publish = 1;						
						$message = "<br/><i>Post has been published. See the post <a href='http://www.athletics.umn.edu/gopherdaily'>here</a>. Or you can go to the <a href='admin.php'>Admin</a> page.</i>";
						
											
					}
																
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
						$maxid = array();
						$maxid_q = "SELECT max(id) as id FROM files";
						$maxid_r = $page->db->query($maxid_q);
						$maxid = $maxid_r->fetch(PDO::FETCH_ASSOC);	 
						$filesid = $maxid['id'];
					}
					}

					/*###Handle Link (if submitted) ###*/
				 	if(isset($_POST["mediaLink"])) 
					{
						if (strpos($_POST["mediaLink"],'youtu') !== false) 
						{		//youtube video 
							$mediaLink = $_POST["mediaLink"];
							$slash = strrchr($mediaLink, "/");
							$mediaLink = substr($mediaLink, 16);
							
							
						}else 
						{ 	//vimeo video
							$mediaLink = $_POST["mediaLink"];
						}
					}
					
					
   		
					 
					$editor_data = str_replace('"', "'", $_POST["editor1"]);
				
					$query = "INSERT INTO mainpage_posts(title, subtitle, content, tags, timestamp, user, relatedfiles_id, media_link, published)
												VALUES(\"".$_POST["title"]."\",\"".$_POST["subtitle"]."\",\"".$editor_data."\",\"".$_POST["tags"]."\",".time().",\"".$_POST['user']."\",\"".$filesid."\",\"".$mediaLink."\",\"".$publish."\")";
												
												
					//echo ($query );
					$insert = $page->db->query($query); 
					
					
					mail("icaweb@umn.edu", 'Gopher Daily Post: ' . $_POST["title"], $_POST["title"]);
					
					if ($insert != false) { 
							
								if($_POST['tags'] != "") 
								{
									//handle tags
									$tags_array = array();
									$tags_array = explode(",", $_POST['tags']);
									foreach ($tags_array as $key => $value) {
										
										$value = trim($value); 
											
										$tag_search = array();
										$tag_query = "SELECT count(*) as count FROM mainpage_tags WHERE tag_title like  \"". $value . "\"";					
										$tag_r = $page->db->query($tag_query);
										$tag_search = $tag_r->fetch(PDO::FETCH_ASSOC);	
										
										if($tag_search['count'] == 0)
										{
											$query = "INSERT INTO mainpage_tags(tag_title)
														VALUES(\"". $value."\")";
											$insert = $page->db->query($query); 								
										}
										else
										{
											$query = "UPDATE  mainpage_tags SET count = count + 1
														WHERE tag_title like  \"". $value."\"";
											$insert = $page->db->query($query); 										
											
										}
								}
							}
							
							echo ($message);
							
							
						}
						else
						{
							echo ("<br/><i>There was an issue posting. Please contact ".$page->webmaster.".</i>");
						}
				}            
          		?>  
            <form name="form1" id="form1" method="post">  
                
                <table cellpadding="2">
                	<tr><td><div class="inputTitle">Select Post Type:</div></td><td>       
					

              
                    <select name="postType" id="postType" onchange="this.form.submit()">
                    <?php
                            if($_POST["postType"] == "post" || !isset($_POST["postType"]))		
                            {
                                echo ('<option value="post" name="post" selected>Post</option>
                                        <option value="quote" name="quote">Quote</option>');
                            }
                            else
                            {
                                echo ('<option value="post" name="post">Post</option>
                                        <option value="quote" name="quote" selected>Quote</option>');						
                            }
                    ?>
                     </select>
            		 </td></tr>
            	 </table>
             </form>
             <hr/>
                         <form name="main_form" id="main_form" method="post" enctype="multipart/form-data">       
			<?php
 			if($_POST["postType"] == "quote")
			{
				
				?>
                <table cellpadding="2">						
						<tr><td><div class="inputTitle">Author:</div> </td><td><input type="text" value="<?php  echo Web_Data::get_fullname($page->user,$page->db); ?>" id="user" name="user"/>                     </td></tr>		               
					</table>
                    
			<textarea name="editor1" id="editor1" rows="10" cols="80">                </textarea>
				<script>
					// Replace the <textarea id="editor1"> with a CKEditor
					// instance, using default configuration.
					CKEDITOR.replace( 'editor1',
						{ extraPlugins: 'filebrowser' } 
					
					);
				</script>
                    <div style="padding: 20px 0px; text-align: center;"  >
					<input type="submit" value="Save" id="submit" name="submit"/>	
                    <input type="submit" value="Save & Publish" id="submit" name="submit"/>
					<input type="submit" value="Delete Post" id="submit" name="submit"/>                    
					<input type="submit" value="Cancel" id="submit" name="submit"/>                    
    				</div>
    
            <?php
			} else	
			{			
				
				
				
				?>            
					
					<table cellpadding="2">
						<tr><td><div class="inputTitle">Post Title:</div></td><td><input type="text" placeholder="Enter Title Here" id="title" name="title" size="45"/>           </td></tr>
						<tr><td><div class="inputTitle">Post Sub Title:</div></td><td><input type="text" placeholder="Enter Sub Title Here (optional)" id="subtitle" name="subtitle" size="45"/>            </td></tr>
						<tr><td><div class="inputTitle">Author:</div> </td><td><input type="text" value="<?php  echo Web_Data::get_fullname($page->user,$page->db); ?>" id="user" name="user"/>                     </td></tr>
					</table>  
                    <div style="padding: 20px 0px;"  >
                   	<table cellpadding="2">                   
						<tr><td><div class="inputTitle">Top Media:</div> </td><td>Attachment: </td><td><input type="file" name="imagefile"></td></tr>       
						<tr><td style="text-align:right;"><span style="font-size: 12px; font-style: italic;">1 media file/link allowed. </span></td>
                        	<td>YouTube Video ID:</td><td> <input type="text" id="mediaLink" name="mediaLink" size="35"> <span style="font-size: 12px; font-style: italic; text-align:right;">Youtube videos ONLY </span></td></tr>                                       
					</table>
					</div>
					
					
					
					 <textarea name="editor1" id="editor1" rows="10" cols="80">                </textarea>
				<script>
					// Replace the <textarea id="editor1"> with a CKEditor
					// instance, using default configuration.
					CKEDITOR.replace( 'editor1' );
				</script>
	
					<table cellpadding="2">
						<tr><td>Tags:</td><td><input type="text" id="tags" name="tags"/>           </td></tr>
						<tr><td></td><td><i>Separate tags with commas</i></td></tr>
					</table> 
								
                    <div style="padding: 20px 0px; text-align: center;"  >
					<input type="submit" value="Save" id="submit" name="submit"/>	
                    <input type="submit" value="Save & Publish" id="submit" name="submit"/>
					<input type="submit" value="Delete Post" id="submit" name="submit"/>                    
					<input type="submit" value="Cancel" id="submit" name="submit"/>                    
    				</div>
    
				
            <?php 
			} 
			
			
			
			?>	</form>
			</div>
            
<script src="/include/jquery/jquery.js" type="text/javascript"></script>
<script src="/include/jquery/jquery.ui.js" type="text/javascript"></script>
<script src="/include/jquery/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">

$(function(){
			$('#main_form').validate({ 
				rules: { 
					title: "required",					
				}, 
				messages: { 
					title: "A Title is required for a post.",
					
				}
			})
	

	var bodyheight = $('#mainleft').height();
	$('#editorContainer').height(bodyheight);

	
	
});
</script>  
       <?php        
  include($_SERVER['DOCUMENT_ROOT'] . "/gopherdaily/includes/footer.php");          
  ?>