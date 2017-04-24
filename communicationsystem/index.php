<?php 
//include($_SERVER['DOCUMENT_ROOT'] . "/include/db_connect.php");
//include($_SERVER['DOCUMENT_ROOT'] . "/credential/mail/htmlMimeMail5.php");
include($_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php");
$page = new Web_Page(199);   
$title = "The Gopher Daily";  
$menuLoc = "main"; 
include($_SERVER['DOCUMENT_ROOT'] . "/gopherdaily/includes/header.php");         
?>         


<div id="postContainer">

<?php

if(isset($_GET["categorie"]))
{
	$categorie = $_GET["categorie"]; 
}
if(isset($_GET["id"])) 
{ 
	$id = $_GET["id"];
}
if(isset($_GET["max"]))
{
	$max = $_GET["max"];	
}
else
{
	$max = 0;
}
if(isset($_GET["tag"]))
{ 
	$tag_r = $page->db->query("SELECT tag_title FROM mainpage_tags WHERE id = ".$_GET["tag"] );
	$tag_search = $tag_r->fetch(PDO::FETCH_ASSOC);
	$tag_set = $tag_search['tag_title'];
}

       
      	if (isset($categorie))
        {
			//################################ VIEW POSTS BASED ON CATEGORIE ########################################/
			$categorie = $_GET["categorie"];
            echo ('<div class="addPostTitle">' . $categorie . '</div>');
			
			$posts_r = $page->db->query("SELECT mp.id postId, title, subtitle, content, tags, mp.timestamp, mp.user, mp.media_link, f.id as fileId,f.name,f.type 
										FROM `mainpage_posts` mp
										LEFT JOIN files f
										ON mp.relatedfiles_id = f.id
										WHERE tags like '%". $categorie ."%'
										AND published = 1
										ORDER BY mp.timestamp desc");
			$posts = $posts_r->fetchAll(PDO::FETCH_ASSOC);					
						
        } else if (isset($id))
		{
			//################################ VIEW SELECTED POST ########################################/
			$posts_r = $page->db->query("SELECT mp.id postId,  title, subtitle, content, tags, mp.timestamp, mp.user, mp.media_link, f.id as fileId,f.name,f.type 
										FROM `mainpage_posts` mp
										LEFT JOIN files f
										ON mp.relatedfiles_id = f.id
										WHERE mp.id like '%". $id ."%'");
			$posts = $posts_r->fetchAll(PDO::FETCH_ASSOC);				
			
		} else if (isset($tag_set))
		{
			//################################ VIEW POSTS BASED ON TAG ########################################/
			$posts_r = $page->db->query("SELECT mp.id postId,  title, subtitle, content, tags, mp.timestamp, mp.user, mp.media_link, f.id as fileId,f.name,f.type 
										FROM `mainpage_posts` mp
										LEFT JOIN files f
										ON mp.relatedfiles_id = f.id
										WHERE mp.tags like \"%". $tag_set ."%\"
										AND published = 1
										ORDER BY mp.timestamp desc");
			$posts = $posts_r->fetchAll(PDO::FETCH_ASSOC);				
			
			echo ("<div class='pageHeader'>");
			echo ("<div class='extraHeader'>TAG</div>");
			echo ("<div class='subextraHeader'>".$tag_set."</div>");			
			echo ("</div>");
			
		} else
		{	
        	//################################ VIEW ALL POSTS ########################################/
			$posts_r = $page->db->query("SELECT mp.id postId, title, subtitle, content, tags, mp.timestamp, mp.user, mp.media_link, f.id as fileId,f.name,f.type 
										FROM `mainpage_posts` mp
										LEFT JOIN files f
										ON mp.relatedfiles_id = f.id
										WHERE published = 1
										ORDER BY mp.timestamp desc
										LIMIT $max, 5");
			$posts = $posts_r->fetchAll(PDO::FETCH_ASSOC);			
		}
		if(count($posts) == 0)
		{
			echo "<div style='padding: 10px;'><h3>Currently there are no posts to show! Please check back soon for a post to be up. </h3></div>";
		}
			$prevPost = "";
			
			foreach($posts as $p)
			{
				if($p['title'] == "")	//quote
				{
					$curPost = "quote";
				}
				else
				{
					$curPost = "post";
				}
				if($prevPost == "post" && $curPost == "post")
				{
					?>
					<style>
					.horLine
					{
						width: 100%;
						height: 3px;
						background-color: #CCC;
						margin-bottom: 40px;
					}
					</style>
					<div class="horLine"></div>
					<?php
				}
				
				if($curPost == "quote")
				{
					?>
						<div class="quote">
							<div class="quoteDate"><?php echo date("F j, Y",$p["timestamp"]); ?> </div>
							<div class="quoteContent"><?php echo $p['content']; ?></div>
							<div class="quoteAuthor"><?php echo Web_Data::get_fullname($p['user'],$page->db);?> </div>
						</div> <!--  quote-->
				
				<?php
				}
				else
				{

									
					/** FIND OUT WHAT TYPE MEDIA IS INCLUDED, HANDLE ACCORDINGLY **/
					$slash = strrpos($p['type'], '/');
				
					$type = substr($p['type'], 0, $slash);
		
					
					echo ('<div class="post"><div class="topMedia" id="'. $p['fileId'] .'">');
					
					if($type == "image")
					{
						echo ('<img src="/gopherdaily/files/'.$p['name'].'" />');
					} 
					else if($type == "video") 
					{
						echo ('<video width="100%" controls>
							  <source src="/gopherdaily/files/'.$p['name'].'" type="'.$p['type'].'">
							  Your browser does not support the video tag.
								</video>');
					}
					else if($p['media_link'] !== "")
					{
						
						echo ('<div class="videoWrapper"><iframe width="560" height="349" src="https://www.youtube.com/embed/'. $p['media_link'] .'" frameborder="0" allowfullscreen></iframe></div>');
						
					}	
					/*else
					{
						echo ('no top media ' . $p[' media_link'] ." --" . strpos($p['media_link'], "https://www.youtube.com/embed"));
					}*/
					echo ("</div>");
					?>
						<div class="title"><a href="index.php?id=<?php echo $p['postId']; ?>"><?php echo $p['title']; ?></a></div>
						<div class="subTitle"><?php echo $p['subtitle']; ?> </div>
						<div class="subInfo"> <?php echo date("F j, Y",$p["timestamp"]); ?> <span style="padding-left:10px; padding-right: 10px;">/</span> <?php echo Web_Data::get_fullname($p['user'],$page->db);?>  </div>
						<div class="tags">Tags: 
							<?php 
							$tags_array = array();
							$tags_array = explode(",", $p['tags']);
							
							//echo "Tags count: " . count($tags_array);
							foreach ($tags_array as $key => $value) {
								
								$value = trim($value); 
								$tag_r = $page->db->query("SELECT id FROM mainpage_tags WHERE tag_title like \"".$value."\"" );
											
								$tag_search = $tag_r->fetch(PDO::FETCH_ASSOC);
								
								if($key < (count($tags_array)-1))
									echo ( "<a href='index.php?tag=".$tag_search ['id'] . "'>" . $value . "</a>,");
								else
									echo ( "<a href='index.php?tag=".$tag_search ['id']  . "'>" . $value . "</a>");						
							}
							
							
							
							
							?></div>
						 
						<div class="content">
							<?php echo $p['content']; ?>

						</div> <!--content-->
                                           <?php
					  $comments = array();
					  $comments_r = $page->db->query("SELECT *
					  								FROM mainpage_comments
													WHERE post_id = " . $p['postId']);
								
					  $comments = $comments_r->fetchAll(PDO::FETCH_ASSOC);		?>  

                      	
                        <div class="comments">
                        	<div class="commentNum" id="<?php echo $p['postId']; ?>">  <i class="icon-comment"></i>  <?php echo count($comments); ?> Comment(s)  </div> 
                            	<span style="padding-left:10px; padding-right: 10px; float: left;">/</span>
                          	<div class="commentAdd" id="<?php echo $p['postId']; ?>">  <a href="https://www.athletics.umn.edu/gopherdaily/private/addComment.php?id=<?php echo $p['postId']; ?>">Add Comment</a> </div>
                            <div style="clear:both"></div>  
                             
					<?php
						  if(count($comments) > 0)
						  {
							  echo ('<div class="commentsContentContainer" style="display:none;" id="container_' . $p['postId'] .'"> ');
							  foreach($comments as $c) 
							  {
								  echo ('<div class="commentsInfo"><div class="commentAuthor">'.Web_Data::get_fullname($c['user'],$page->db).' </div> 
																	<div class="commentsContent">'.$c['comment'].'</div>
																	<div class="commentDate">'.date("F j g:ia",$c['timestamp']).'</div>
											<div style="clear:both"></div>      															
										</div>');
							  }
							  echo ('</div> <!--commentsContentContainer--> ');
						  }
					?>                         
                      
                                                                  
                            
                        </div> <!--comments--> 
					</div> <!--post-->        
					<?php
					
				}
				$prevPost = $curPost;

				
				
			}

	//*********************BUILD NAVIGATION**********************
	
	$count_r = $page->db->query("SELECT * FROM mainpage_posts mp WHERE published = 1");
	$count = $count_r->fetchAll(PDO::FETCH_ASSOC);	
	
	$post_count = count($count);
		
	$olderPage = $max + 5;
	$newerPage = $max - 5;
	/*
	 
	echo ("NUMBER OF POSTS " . $post_count);
	echo ("<br/>MAX " . $max);		
	echo ("<br/>OLDER PAGE " . $olderPage);	
	echo ("<br/>NEWER PAGE " . $newerPage . "<br/>");	 	*/
	
	echo ("<div class='olderPage'>");
	if(!isset($id))
	{
		if($olderPage < $post_count)
		{	
			echo ("<a href='index.php?max=" . $olderPage . "'> <i class='icon-double-angle-left'></i>  Older Posts</a>");
		}
		echo ("</div>");	
		
		echo ("<div class='newerPage'>");
		if($newerPage >= 0)
		{
			echo ("<a href='index.php?max=" . $newerPage . "'> Newer Posts <i class='icon-double-angle-right'></i></a>");
		}
	}
	else
	{
		echo ("<a href='index.php'> <i class='icon-double-angle-left'></i>  Back to Main Page</a>");
	}
	echo ("</div>");

			?>
            </div>
<style>
.zoomWindow
{
	z-index: 500;
	position: absolute;
	background-color: rgba(0,0,0,.5);
	width: 100%;
	height: 100%;


}
.zoomWindow img
{
	margin-left: 10%;
	margin-top: 10%;
	width: 50%;
}
</style>
<?php
        
      	if (isset($_POST['zoomId']))
        {
			
				echo ("<div class='zoomWindow'>");
				
				$zoom_r = $page->db->query("SELECT * FROM files f
										WHERE id =" . $_POST['zoomId']);
				$zoom = $zoom_r->fetch(PDO::FETCH_ASSOC);			
				
				echo ('<img src="files/'.$zoom['name'].'" /></div>');
				
				echo ("</div>");
		}
?>
	<form method="post" id="zoomForm">
    <input name="zoomId" type="hidden" value=""/>
    </form>
<script type="text/javascript" src="/include/jquery/jquery.js"></script> 
<script type="text/javascript" src="/include/jquery/jquery.ui.js"></script>
<script type="text/javascript">

$(function() { 		
/*
$('.topMedia').click(function(e) { 
		var mediaId = $(this).attr("id");
		
		$('input[name=zoomId]').val(mediaId);
		
		$('#zoomForm').submit();
	
	});
*/ 
		var bodyheight = $('#mainleft').height();
		var postheight = $('#postContainer').height();
	
		if(bodyheight > postheight)
		{
			$('#postContainer').height(bodyheight);
		}
	
	$('.commentNum').click(function(e) { 
		var id = $(this).attr('id');
	
//		$("#container_" + id).show();
		if(document.getElementById('container_' + id).style.display == "none")
		{
			document.getElementById('container_' + id).style.display = "block";
		}
		else
		{
			document.getElementById('container_' + id).style.display = "none";		
		}
	});
});
</script>
<?php        
	include($_SERVER['DOCUMENT_ROOT'] . "/gopherdaily/includes/footer.php");          
?>