<?php
include($_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php");
$page = new Web_Page(191); 
?> 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>2017 Golden Goldys Awards Ballot</title>

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
	  /*background-color: #761e2e;*/
  }
  .container
  {
	  background-color:#ffffff;
	  
  }
  .jumbotron
  {
	  margin-bottom: 0px;
  }  
  html{font-size:10px;-webkit-tap-highlight-color:rgba(0,0,0,0)}body{font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:14px;line-height:1.42857143;color:#333;background-color:#fff}
body{margin:0}
  </style>
  </head>


  <body>
  

           
           
   

 
 	<div class="container">
    <img src="include/Golden-Goldys-17-header.jpg" width="100%"/>
    
    
    <!--  <div class="alert alert-danger" role="alert">
            
            
            Thank you all for your votes! The voting for Golden Goldys 2017 has been closed. <br/> Please make sure to <strong>Save the Date</strong> for the <strong>The Golden Goldys</strong>, Monday, May 2, 2017 at TCF Bank Stadium.
            </div> 
           <div style="text-align:center; margin-bottom: 15px;"><img src="http://grfx.cstv.com/schools/minn/graphics/daily-golden-2016.png"/></div>
           
           -->
           
	<?php
	
/*	$FTE_users = array('bgoetz','rmhandel',	'jyehlen', 'tmcginni',	'cjwerle', 'ryanx011',
						'ataylord',	'cart0194',	'bruet001', 'owens140',	'ellis004',	'owens140',
						'ellis004',	'alfx0001',	'allister',	'ander014',	'bingl001',	'burns265',
						'carl0907',	'davis194',	'frost017', 'hess0125',	'hmccutch',	'kreme010',
						'lucia004',	'marlene',	'merzb001',	'mrredman',	'niesz001',	'plase001',
						'robin002',	'rwpitino',	'skgolan', 'tlclaeys', 'wchen', 'young843',
						'lindq010',	'goon',	'seifr001',	'jdtweedy', 'doyle042',	'psrovnak',
						'wiley077',	'tabudke', 'rasm0222', 'holck', 'adzick', 'keiser',	'gisla002',	'owens018',
						'shee0129','vossx120','traen001','keiser','gwwright','romox001','meyer174','lagas001');
*/
	$FTE_users = array('shee0129','owens140','traen001','keiser','lagas001');

	$userTypeq = "SELECT user_type FROM users WHERE username = '".$page->user."'";
		
	$userTyper = $page->db->query($userTypeq);
	 $userType = $userTyper->fetch(PDO::FETCH_ASSOC);

		
//if($userType['user_type'] == 5 || in_array($page->user ,$FTE_users))	//student athletes only
//if(in_array($page->user ,$FTE_users))	//student athletes only
//{
	if(isset($_POST['submit']))
	{
            $categories = array();
            $categories_q = "SELECT * FROM goldys_categories ORDER BY id";
            $categories_r = $page->db->query($categories_q);
            $categories = $categories_r->fetchAll(PDO::FETCH_ASSOC);
			
			$count = 0;
			foreach($categories	as $c)
			{
				$vote_q = "INSERT INTO goldys_voting (user, timestamp, category_id, finalists_id)
							VALUES('".$page->user."',".time().",".$c['id'].",".$_POST["vote".$c['id']].")";
//				echo $vote_q ;
				$vote = $page->db->query($vote_q);				

				if($vote != false)
					$count++;
			}
			
			//echo "COUNT: " . $count;
			if($count == 10)
			{
			?>
            
            <div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
            
            Thank you for your vote! Please make sure to <strong>Save the Date</strong> for the <strong>The Golden Goldys</strong>, Monday, May 1, 2017 at TCF Bank Stadium in the DQ Club Room with doors opening at 5:45pm.
            </div>
           <!--<div style="text-align:center; margin-bottom: 15px;"><img src="http://grfx.cstv.com/schools/minn/graphics/daily-golden-2016.png"/>-->


           </div>
            
            
            <?php
			}
	}
	else
	{

            $checkusers = array();
            $checkusers_q = "SELECT * FROM goldys_voting WHERE user = '" . $page->user . "'";
            $checkusers_r = $page->db->query($checkusers_q);
            $checkusers = $checkusers_r->fetchAll(PDO::FETCH_ASSOC);
			
			if(count($checkusers) > 0)
			{
				
				?>
				 <div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
            
            Our records show that you have already voted in this year's Golden Goldys. If this is incorrect, please email the <a href="mailto:icaweb@umn.edu">Web Administrator at icaweb@umn.edu</a>.
            </div>
           
           
           
           
           <?php
			} else
	{

		
    ?>
    <style>
	thead {
background-color: rgba(140,25,25,.5);
border: #fff;

	}
	.table>thead>tr>th {
	
		border-radius: 5px;
		color: #333;
	}
	.row#head
	{
		background-color: rgba(140,25,25,.5);
		border: #fff;
		border-radius: 5px;
		color: #333;
		padding: 15px;
		margin-top: 15px;
		font-weight:700;
		
	}
	.row#finalists
	{
		padding: 10px;	
			
	}
	.row#finalists:hover
	{
		background-color: rgba(102,102,102,.2);	
		border-radius: 5px;
			
	}	
	.detailsLink
	{
		cursor:pointer;
	}
	</style>
    <script>
	function toggler(divId) {
		
	 $("#" + divId).toggle();
	}
	</script>
    
    <?php $logout_url = Web_Shibboleth::shib_logout_url(); ?>
    <p style="padding-top: 15px;">You are currently logged in as: <strong><?php echo $page->user; ?></strong>. Click here to <a href="<?php echo $logout_url;?>"><strong>Log Out</strong></a>.</p>
 
    
    
     	<form method="post" action="index.php">

          <?php
            $categories = array();
            $categories_q = "SELECT * FROM goldys_categories ORDER BY id";
            $categories_r = $page->db->query($categories_q);
            $categories = $categories_r->fetchAll(PDO::FETCH_ASSOC);	
		  
		  	foreach($categories as $c)
			{
		  ?>
            
            <div class="row" id="head">
                <div class="col-md-8"><?php echo $c['category'];?></div>
                <div class="col-md-4"></div>
            </div>
            
            
            <?php
				$finalists = array();
				$finalists_q = "SELECT * FROM goldys_finalists WHERE category_id = " .$c['id'] . " ORDER BY id";
				$finalists_r = $page->db->query($finalists_q);
				$finalists = $finalists_r->fetchAll(PDO::FETCH_ASSOC);	
			  
				foreach($finalists as $f)
				{


           			echo '<div class="row" id="finalists">';
						echo '<div class="col-md-3">';
							if($f['headshot'] != "")
							{
								echo "<img src='headshots/".$f['headshot']."' width='170px'>";
							}
						echo'</div>';
											
						echo '<div class="col-md-2">';
							echo "<label><input type='radio' name='vote".$c['id']."' value='".$f['id']."' required> ".$f['athlete_name']."	</label>";
						echo'</div>';
						
						echo '<div class="col-md-2">'.$f['sport'].'</div>';
						echo '<div class="col-md-1">';

							switch($f['year'])
							{
								case 1: echo "Freshman"; break;
								case 2: echo "Sophomore"; break;
								case 3: echo "Junior"; break;
								case 4: echo "Senior"; break;																
							}						
						
						echo '</div>';
						
					
						echo "<div class='col-md-4'>";
						echo "<a class='detailsLink' onclick='toggler(\"details".$f['id']."\");'>View Details</a>	";
					echo "<div id='details".$f['id']."' style='display:none;'>	";
					echo $f['highlights'];
					echo "</div>";
					echo "</div>	";

									
					echo '</div>';
					
				}
			
			
			 } ?>

			<hr/>
			<div style="padding-bottom: 50px;">
        		<button type="submit" name="submit" class="btn btn-primary btn-lg">Submit Ballot</button>
            </div>
        </form>
    
          <?php }
		  
	}
	/*}
	else
	{
		?>
         <div class="alert alert-danger" role="alert"style='margin-top: 15px'>
            <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
            
            Our records show that you are not a Student Athlete or a member of the voting committee. If you are a member of one of these two parties and would like to submit your vote, please email the <a href="mailto:icaweb@umn.edu">Web Administrator at icaweb@umn.edu</a>.
            </div>
          <!-- <div style="text-align:center; margin-bottom: 15px;"><img src="http://grfx.cstv.com/schools/minn/graphics/daily-golden-2016.png"/></div>-->
        
        
        <?php
		
	}*/
	?>
        
       </div>
    
    <footer class="footer" style="padding-bottom: 5px;">
      <div class="container">
      		<div class="row">
				<div class="col-md-4">
                	<div style="text-align: left;">
                           <!-- <img src="include/GoldenGoldysLogo.png" width="25%"/> -->
                    </div>
                </div>
                
  				<div class="col-md-4" style="text-align: center;">              
                            <?php
            if (!isset($_SERVER['REMOTE_USER']) || trim($_SERVER['REMOTE_USER']) == "") {
                $login_url = Web_Shibboleth::shib_login_and_redirect_url();
                $login_logout = "<a href=\"$login_url\"><strong>Log In</strong></a>";
            } else {
                $logout_url = Web_Shibboleth::shib_logout_url();
                $login_logout = "<a href=\"$logout_url\"><strong>Log Out</strong></a>";
            }
             
            if (isset($_SERVER['REMOTE_USER'])) {  
                if ($_SERVER['REMOTE_USER'] != "" && $_SERVER['REMOTE_USER'] != "guest") { ?>
                    
                        <?php echo $login_logout;  ?>
                  
                    <?php 
                } 
            } 
		
		?>
            </div>
        
				<div class="col-md-4">
                	<div style="text-align: right;">
                            <img src="include/MLogo.jpg" width="15%"/>             
                            <a href="admin.php">Admin Page</a> <br/>
                       
                    </div>
                </div>                

      </div>
    </footer>
    
    </body>
    </html> 