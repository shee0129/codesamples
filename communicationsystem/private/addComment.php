<?php
include($_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php");
$page = new Web_Page(199);
$title = "Daily Gopher Add Comment";
$page->setPermissions(0,2); 
//$page->printHeader(); 
include($_SERVER['DOCUMENT_ROOT'] . "/gopherdaily/includes/header.php");    

 
?> 

        
            <div class="editorContainer" id="editorContainer"> 
    
				<?php
           		 if (isset($_POST["submit"]))
				{ 
					$comment = str_replace('"', "'", $_POST["editor1"]);
					
					$query = "INSERT INTO mainpage_comments(comment, user, timestamp, post_id)
					VALUES('".$comment."','".$_POST["user"]."','".time()."','".$_POST['id']."')";
					
					$insert = $page->db->query($query);
					
					if ($insert == false) { 
						echo ("<br/><i>Problem posting comment - please contact <a href='mailto:icaweb@umn.edu'>icaweb@umn.edu</a>.</i>");
					}					
				
				
				}            
          		?> 
                
                
                <?php
			$posts_r = $page->db->query("SELECT mp.id postId,  title, subtitle, content, tags, mp.timestamp, mp.user, mp.media_link, f.id as fileId,f.name,f.type 
										FROM `mainpage_posts` mp
										LEFT JOIN files f
										ON mp.relatedfiles_id = f.id
										WHERE mp.id = '". $id ."'");
			$posts = $posts_r->fetch(PDO::FETCH_ASSOC);					
			
/** FIND OUT WHAT TYPE MEDIA IS INCLUDED, HANDLE ACCORDINGLY **/
					$slash = strrpos($posts['type'], '/');
				
					$type = substr($posts['type'], 0, $slash);
		
					
					echo ('<div class="post"><div class="topMedia" id="'. $posts['fileId'] .'">');
					
					if($type == "image")
					{
						echo ('<img src="/gopherdaily/files/'.$posts['name'].'" />');
					}
					else if($type == "video")
					{
						echo ('<video width="100%" controls>
							  <source src="/gopherdaily/files/'.$posts['name'].'" type="'.$posts['type'].'">
							  Your browser does not support the video tag.
								</video>');
					}
		
						echo ("</div>");
					?>
						<div class="title"><?php echo $posts['title']; ?> </div>
						<div class="subTitle"><?php echo $posts['subtitle']; ?> </div>
						<div class="subInfo"> <?php echo date("F j, Y",$posts["timestamp"]); ?> <span style="padding-left:10px; padding-right: 10px;">/</span> <?php echo Web_Data::get_fullname($posts['user'],$page->db);?>  </div>
						<div class="tags">Tags: <?php echo $posts['tags']; ?></div>
						 
						<div class="content">
							<?php echo $posts['content']; ?>

						</div> <!--content-->
                                           <?php
					  $comments = array();
					  $comments_r = $page->db->query("SELECT *
					  								FROM mainpage_comments
													WHERE post_id = " . $posts['postId']);
								
					  $comments = $comments_r->fetchAll(PDO::FETCH_ASSOC);		?>  

                      	
                        <div class="comments">
                        	<div class="commentNum" id="<?php echo $posts['postId']; ?>">  <i class="icon-comment"></i>  <?php echo count($comments); ?> Comment(s)  </div> 
                            	<span style="padding-left:10px; padding-right: 10px; float: left;">/</span>
                          	<div class="commentAdd" id="<?php echo $posts['postId']; ?>">  Add Comment </div>
                            <div style="clear:both"></div>  
                             
					<?php
						  if(count($comments) > 0)
						  {
							  echo ('<div class="commentsContentContainer" style="display:block;" id="container_' . $p['postId'] .'"> ');
							  foreach($comments as $c) 
							  {
								  echo ('<div class="commentsInfo"><div class="commentAuthor">'.Web_Data::get_fullname($c['user'],$page->db).' </div> 
																	<div class="commentsContent">'.$c['comment'].'</div>
																	<div class="commentDate">'.date("F j g:ia",$c['timestamp']).'</div>
											<div style="clear:both"></div>      															
										</div>');
							  }
							
						  }
					?>                         
                      			<div class="commentsInfo"> <div class="commentAuthor" >  <?php echo Web_Data::get_fullname($page->user,$page->db); ?> </div>
                                <br/><br/>
                                <style>
								#cke_editor1 {							
								
								
										
								
								}
								</style>
                                <form method="post">
						 <textarea name="editor1" cols="10" rows="3"  id="editor1" > Enter comment here...</textarea>
									<script>
                                        // Replace the <textarea id="editor1"> with a CKEditor
                                        // instance, using default configuration.
                                        //CKEDITOR.replace( 'editor1' );
										 CKEDITOR.replace( 'editor1', {
											toolbar: [	],
											removePlugins: 'elementspath',
											height: '50px'
										});		
                                    </script>


									<br/>
                                    
                                    <input type="submit" value="Post Comment Now" name="submit" />
                                    <input type="hidden" value="<?php echo $page->user; ?>" name="user"/>
                                    <input type="hidden" value="<?php echo $id; ?>" name="id"/>                                    
                                </form>                                  
                            <?php   echo ('</div> <!--commentsContentContainer--> '); ?>
                        </div> <!--comments--> 
					</div> <!--post-->        
				
     
			</div>
       
<script type="text/javascript" src="/include/jquery/jquery.js"></script> 
<script type="text/javascript" src="/include/jquery/jquery.ui.js"></script>
<script type="text/javascript">

$(function() { 		

	var bodyheight = $('#mainleft').height();
	$('#editorContainer').height(bodyheight);

	
	
});
</script>            
            
             <?php        
  include($_SERVER['DOCUMENT_ROOT'] . "/gopherdaily/includes/footer.php");          
  ?>     	