<?php
include($_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php");
$page = new Web_Page(191); 
$page->setPermissions(191);
?> 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>2016 Golden Goldys Awards: Results</title>

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
    <?php //print_r ($_POST); 
	
	?>
    <style>

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
	.row#winner
	{
		padding: 10px;	
		background-color: rgba(0,51,204,.2);			
			
	}		
	</style>
	
    <div class="jumbotron" style="background-color:#ffffff; text-align:center;">
      <div class="container">
        <img src="include/GoldenGoldysLogo.png" width="25%"/>
      </div>
    </div>
 
 	<div class="container">

    <div class="page-header">
      <h1>Voting Results</h1>
    </div>
  
    
    
    <?php
			$voteCount_q = "SELECT count(DISTINCT(v.user)) as count, user_type
							FROM goldys_voting v
							JOIN users u
							ON v.user = u.username
							GROUP BY user_type";
			$voteCount_r = $page->db->query($voteCount_q);
			$voteCount = $voteCount_r->fetchAll(PDO::FETCH_ASSOC);  
			
			$staffVotes = 0;
			$studentVotes = 0;
			$totalVotes = 0;
			foreach($voteCount as $vC)
			{
				if($vC['user_type'] != 5)
					$staffVotes += $vC['count'];
				else
					$studentVotes += $vC['count'];				
					
				$totalVotes += $vC['count'];
			}
    ?>
        <table width="25%">
        	<tr>
            	<td>Student Voters:</td>
            	<td><?php echo $studentVotes;?></td>
            </tr>  
        	<tr>
            	<td>Staff Voters:</td>
            	<td><?php echo $staffVotes;?></td>
            </tr>                  
        	<tr>
            	<td>Total Voters:</td>
            	<td><?php echo $totalVotes;?></td>
            </tr>
        </table>
    		
	<hr/>
  
    <h1><small>Current Winners</small></h1>
        <table width="45%" class="table">
        	<thead>
        	<tr>
            	<th>Category</th>
            	<th>Current Winner</th>
            	<th>Total Votes</th>          
            	<td>Staff Votes</td>                       
            	<td>Student Votes</td>                                       
            </tr>
        	</thead>
            <tbody>
	<?php
			$allWinners = array();
			$allWinners_q = "SELECT g.category, v.category_id, finalists_id, f.id, athlete_name, count(*) as count
							FROM goldys_voting v
							JOIN goldys_categories g
							ON v.category_id = g.id
							JOIN goldys_finalists f
							ON v.finalists_id = f.id
							GROUP BY v.category_id, finalists_id
							ORDER BY v.category_id, count(*) desc";
			$allWinners_r = $page->db->query($allWinners_q);
			$allWinners = $allWinners_r->fetchAll(PDO::FETCH_ASSOC);  
			
			$pastCategory = 0;
			
			foreach($allWinners as $aW)
			{
				if($pastCategory != $aW['category_id'])
				{
				
					echo "<tr>";
					echo "<td>". $aW['category'] . "</td>";
					echo "<td>". $aW['athlete_name'] . "</td>";
					echo "<td>". $aW['count'] . "</td>";
					
					$byGroupResults = array();
					$byGroupResults_q = '(SELECT "STAFF" as type, count(DISTINCT(v.user)) as count
											FROM goldys_voting v
											JOIN users u
											ON v.user = u.username
											WHERE user_type != 5
											AND v.finalists_id ='.$aW['id'].')
											UNION ALL
											(SELECT "STUDENTS" as type, count(DISTINCT(v.user)) as count
											FROM goldys_voting v
											JOIN users u
											ON v.user = u.username
											WHERE user_type = 5
											AND v.finalists_id ='.$aW['id'].')';
											
					$byGroupResults_r = $page->db->query($byGroupResults_q);
					$byGroupResults = $byGroupResults_r->fetchAll(PDO::FETCH_ASSOC);									

					$studentCount = 0;
					$staffCount = 0;
					
					foreach($byGroupResults as $bGR)
					{
						if($bGR['type'] == "STUDENTS")
							$studentCount = $bGR['count'];					
						if($bGR['type'] == "STAFF")
							$staffCount = $bGR['count'];	
					}


					echo "<td>". $staffCount . "</td>";
					echo "<td>". $studentCount . "</td>";


					echo "</tr>";
					$pastCategory = $aW['category_id'];
				}
				else
				{
					
					
				}
				
			}



	?>








            </tbody>
        </table>    

	
    
    <h1><small>By Categorie</small></h1>
    
    <?php 
	
            $categories = array();
            $categories_q = "SELECT * FROM goldys_categories ORDER BY id";
            $categories_r = $page->db->query($categories_q);
            $categories = $categories_r->fetchAll(PDO::FETCH_ASSOC);	
		  
		  	foreach($categories as $c)
			{
		  ?>
            
            <div class="row" id="head">
                <div class="col-md-6"><?php echo $c['category'];?></div>
                <div class="col-md-2">Total Votes</div>
                <div class="col-md-2">Staff Votes</div>     
                <div class="col-md-2">Student Votes</div>                            
            </div>
            
            
            <?php
				$finalists = array();
				$finalists_q = "SELECT f.id, f.athlete_name, f.sport, f.year, count(v.id) as count 
								FROM goldys_finalists f
								LEFT JOIN goldys_voting v
								ON f.id = v.finalists_id
								WHERE f.category_id = " .$c['id'] . " 
								GROUP BY f.id
								ORDER BY f.id";		
				$finalists_r = $page->db->query($finalists_q);
				$finalists = $finalists_r->fetchAll(PDO::FETCH_ASSOC);	

						$winner_q = "SELECT finalists_id, count(*) as count
									FROM goldys_voting
									WHERE category_id = " .$c['id'] . " 
									GROUP BY finalists_id
									ORDER BY count desc	
									LIMIT 0,1";
								//	echo $winner_q;
						$winner_r = $page->db->query($winner_q);
						$winner = $winner_r->fetch(PDO::FETCH_ASSOC);

			  
				foreach($finalists as $f)
				{

		
							
						
						if($winner['finalists_id'] == $f['id'])
						{
		           			echo '<div class="row" id="winner">';							
						}
						else
						{
		           			echo '<div class="row" id="finalists">';
						}
						
						
						echo '<div class="col-md-2">';
							echo $f['athlete_name'];
						echo'</div>';
						
						echo '<div class="col-md-2">'.$f['sport'].'</div>';
						echo '<div class="col-md-2">';

							switch($f['year'])
							{
								case 1: echo "Freshman"; break;
								case 2: echo "Sophomore"; break;
								case 3: echo "Junior"; break;
								case 4: echo "Senior"; break;																
							}						
						
						echo '</div>';
						
					
						echo "<div class='col-md-2'>".$f['count']."</div>	";


					$byGroupResults = array();
					$byGroupResults_q = '(SELECT "STAFF" as type, count(DISTINCT(v.user)) as count
											FROM goldys_voting v
											JOIN users u
											ON v.user = u.username
											WHERE user_type != 5
											AND v.finalists_id ='.$f['id'].')
											UNION ALL
											(SELECT "STUDENTS" as type, count(DISTINCT(v.user)) as count
											FROM goldys_voting v
											JOIN users u
											ON v.user = u.username
											WHERE user_type = 5
											AND v.finalists_id ='.$f['id'].')';
											
					$byGroupResults_r = $page->db->query($byGroupResults_q);
					$byGroupResults = $byGroupResults_r->fetchAll(PDO::FETCH_ASSOC);									

					$studentCount = 0;
					$staffCount = 0;
					
					foreach($byGroupResults as $bGR)
					{
						if($bGR['type'] == "STUDENTS")
							$studentCount = $bGR['count'];					
						if($bGR['type'] == "STAFF")
							$staffCount = $bGR['count'];	
					}

					echo "<div class='col-md-2'>".$staffCount."</div>	";
					echo "<div class='col-md-2'>".$studentCount."</div>	";
						

									
					echo '</div>';
					
				}
			
				echo "<hr/>";

			
			 } ?>
	
	
		




	
          
    </div>
     <footer class="footer" style="padding-bottom: 5px;">
      <div class="container">
      		<div class="row">
				<div class="col-md-6">
                	<div style="text-align: left;">
                            <img src="include/GoldenGoldysLogo.png" width="25%"/>
                    </div>
                </div>
				<div class="col-md-6">
                	<div style="text-align: right;">
                            <img src="include/MLogo.jpg" width="15%"/>              
                            <a href="index.php">Back to Ballot</a>
                    </div>
                </div>                

      </div>
    </footer>
    
    
    </body>
    </html> 