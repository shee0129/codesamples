<!DOCTYPE html>
<html> 
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
        <link href="/include/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
        <link href="/gopherdaily/style.css" rel="stylesheet" />     

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-50275315-1', 'auto');
  ga('send', 'pageview');

</script>

		<script src="/libraries/ckeditor/ckeditor.js"></script>             
</head>



<body>
<?php
/*  
$menuLoc = "main";

function setMenuLoc($currentMenuLoc) {
		if (trim($currentMenuLoc) != "") { 
			$menuLoc = $currentMenuLoc;
		}
}*/
?>
<?php
if(isset($_GET["id"]))
{ 
			$id = $_GET["id"];
}

?> 

<div class="container">
    	<!-- LEFT MAIN COLUMN - MENUS -->
    	<div class="mainleft" id="mainleft">
        	<div class="logo"><a href="/gopherdaily/index.php"><img src="/gopherdaily/files/logo.png" /></a></div>
       
            <div class="mainPages">
            	
            	<?php  
					if($menuLoc == "main")
					{
						echo ('<div class="pageTitle"><a href="/gopherdaily/index.php" style="color: #FCBA3D;" id="1">Home</a></div>');
					}
					else
					{ 
						echo ('<div class="pageTitle"><a href="/gopherdaily/index.php" >Home</a></div>');						
					} 			
/*					if($menuLoc == "staff")
					{
						echo ('<div class="pageTitle" style="border: none;" ><a href="https://www.athletics.umn.edu/gopherdaily/index.php?id=482" style="color: #FCBA3D;" id="1">Staff Birthday Request</a></div>');
					}
					else
					{*/
						echo ('<div class="pageTitle" style="border: none;"><a href="https://www.athletics.umn.edu/gopherdaily/index.php?id=482" >Staff Birthday Request</a></div>');						
					//}						
					if($menuLoc == "vv")
					{
						echo ('<div class="pageTitle" style="border: none;" ><a href="/gopherdaily/visionandvalues.php" style="color: #FCBA3D;" id="1">Vision and Values</a></div>');
					}
					else
					{
						echo ('<div class="pageTitle" style="border: none;"><a href="/gopherdaily/visionandvalues.php" >Vision and Values</a></div>');						
					}		
					echo ('<div class="pageTitle" style="border: none;"><a href="https://www.athletics.umn.edu/ticketoffice/private/staffticketrequests/" target="_blank">Staff Comp Tickets</a> <img src="files/new_banner.png" height="16px" style="padding-right: 15px;" align="right" /></div>');	
					echo ('<div class="pageTitle" style="border: none;"><a href="https://www.athletics.umn.edu/gopherdaily/index.php?id=368" target="_blank">Important Dates</a> <img src="files/new_banner.png" height="16px" style="padding-right: 15px;" align="right" /></div>');										
					echo ('<div class="pageTitle" style="border: none;"><a href="http://grfx.cstv.com/photos/schools/minn/genrel/auto_pdf/2015-16/misc_non_event/Staff_Directory_0116.pdf" target="_blank">Staff Directory</a></div>');
				
				?>

			</div>

               
            
            <div class="navContainer">
                <div class="navTitle">Recent Posts</div>      
                <?php
				$recent = array();
				$recent_r = $page->db->query("SELECT id, title FROM mainpage_posts
												WHERE title != ''
											 	AND published = 1
												order by timestamp desc
												limit 4");
				$recent = $recent_r->fetchAll(PDO::FETCH_ASSOC);	

				$count = 1;
				foreach($recent as $r)
				{
					if($count == 4)
					{
						echo '<div class="navSubTitle" style="border: none;"><a href="/gopherdaily/index.php?id='.$r['id']. '">'.$r['title'].'</a></div>';						
					}
					else
					{
						echo '<div class="navSubTitle"><a href="/gopherdaily/index.php?id='.$r['id']. '">'.$r['title'].'</a></div>';	
					}
					
					$count++;
				}
				
				
				
				?>       
			</div>
            
            <div class="navHorizBar">       </div>      

            <div class="navContainer">            
                <div class="navTitle">Tags</div>       
						<style>
							.tagsNav
							{
								background:  #320d14;
								float: left;
								padding: 5px;
							
								margin: 5px;
									text-transform: none;
										font-weight: 400;
										border: 1px solid #5b1722;
										/*border-top: 1px solid #761e2e;
										border-bottom: 1px solid #761e2e;	*/
										border-radius:5px;									
								
							}
							.tagsNav a
							{
							text-decoration: none;
								color: #fff;
							}							
						</style>
							<?php
 				$tags_array = array();							
				$tags_r = $page->db->query("SELECT id, tag_title FROM mainpage_tags");
				$tags_array = $tags_r->fetchAll(PDO::FETCH_ASSOC);								
							
							
                              /*  $tags_array1 = array();
                                $tags_query = "SELECT tags FROM mainpage_posts";
                            
                                $tags_result = $page->db->query("SELECT tags FROM mainpage_posts");
                            
                                while($tag = $tags_result->fetch(PDO::FETCH_ASSOC))
                                {
                                    if($tag['tags'] != "")
                                    {
                                        $newTag = $tag['tags'];
                                        $newTagAr = explode(",", $newTag);
                                        
                                        foreach($newTagAr as $nTA)
                                        {
                                            $insert = ltrim($nTA);
                                            //$insert = strip_tags($insert);
                                            $insert = strtolower($insert);
                                            if(!in_array($insert, $tags_array1))
                                                array_push($tags_array1, $insert);		
                                        }
                                        
                                            
                            
                                    }
                                }
                                sort($tags_array1,SORT_STRING);*/
                                foreach ($tags_array as $ta)
								{
									echo ("<div class='tagsNav'><a href='/gopherdaily/index.php?tag=". $ta['id'] . "'>" . $ta['tag_title'] . "</a></div>");
								}
                            
                            ?>
                                      <div style="clear:both"></div>                                                            
			</div> 
            
            <div class="navHorizBar">       </div>      
 
             <div class="navContainer">            
                <div class="navTitle">Links</div>      
                    <div class="navSubTitle"><a href="http://myu.umn.edu" target="_blank">MyU</a> <img src="files/new_banner.png" height="16px" align="right" /></div>
                    <div class="navSubTitle"><a href="http://www.athletics.umn.edu" target="_blank">Athletics Intranet Page</a></div>                        
                    <div class="navSubTitle"><a href="http://www.gophersports.com" target="_blank">Gophersports.com</a></div>
                    <div class="navSubTitle"><a href="http://www.Mygophersports.com" target="_blank">Mygophersports.com</a></div>
                    <div class="navSubTitle"><a href="http://www.Goldengopherfund.com" target="_blank">Goldengopherfund.com</a></div>
                    <div class="navSubTitle" style="border: none;"><a href="http://www.nothingshortofgreatness.com" target="_blank">Nothingshortofgreatness.com</a></div>                       
			</div> 

            <div class="navHorizBar">       </div>    
             
              <div class="navContainer">           
                <div class="navTitle">About This Page</div>            
                    <div class="navSubTitle" style="border: none;">This page is a primary resource for sharing content that reinforces the Vision and Values of Gopher Athletics. We will regularly share stories from within our department that exemplify our Vision and Values, as well as articles, quotes and various tidbits from around the entire University and beyond. We welcome your thoughts and comments on any of the site's content. Be sure to check back often for updates.</div>                   
            </div> 
            <div class="navHorizBar">       </div>                  
  
               <div class="navContainer">          
                <div class="navTitle">Admin Options <i class="icon-lock"></i></div>             
                    <div class="navSubTitle" style="border: none;"><a href="https://www.athletics.umn.edu/gopherdaily/private/admin.php">Main Admin Page </a>  </div>                                           
                    <div class="navSubTitle" style="border: none;"><a href="https://www.athletics.umn.edu/gopherdaily/private/addPost.php">Add New Post </a>  </div>
			</div> 
 
            <div class="navHorizBar">       </div>         
        
        </div>


<script type="text/javascript" src="/include/jquery/jquery.js"></script> 
<script type="text/javascript" src="/include/jquery/jquery.ui.js"></script>
<script type="text/javascript">

$(function() { 	
	$(".pageTitle").hover(function(){
		$(this).animate({"padding-left": "40px"});
		$(this).children("a").css('color', '#FCBA3D');
	}, function() {
		$(this).animate({"padding-left": "25px"});
		if($(this).children("a").attr("id") != 1)
		{
			$(this).children("a").css('color', '#FFFFFF');		
		}
	});
	
	$(".navSubTitle").hover(function(){
		$(this).children("a").css('text-decoration', 'underline');
	}, function() {
		$(this).children("a").css('text-decoration', 'none');
	});	
});

</script>
        
    	<!-- RIGHT MAIN COLUMN - POSTS-->        
    	<div class="mainRight" id="mainRight">   