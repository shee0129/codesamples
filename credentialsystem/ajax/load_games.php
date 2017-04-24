<?php 
include($_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php");
$page = new Web_Page(189);



if (isset($_GET["sport"]) && is_numeric($_GET["sport"])) {
	
	$module_id = $_GET["sport"]; 
	//Get the date of the next July 1st. This way, we can only return events up until the end of the current season.
	$cutoff = strtotime("7/1 next year");
	
	//Check if there are events for the given period of time. 
	$sth = $page->db->prepare("SELECT COUNT(id) AS num_events FROM calendar WHERE attributes LIKE '%contest%' AND attributes LIKE '%global%' AND attributes LIKE '%home%' AND event NOT LIKE '%NCAA%' AND event_startdate > ".time()." AND event_startdate < $cutoff AND module=" . $module_id );
	$sth->execute($sport);
	$count = $sth->fetch(PDO::FETCH_ASSOC);
	if ($count["num_events"] > 0) {
		
		$games_q = "SELECT id, event, event_startdate FROM calendar WHERE attributes LIKE '%contest%' AND attributes LIKE '%global%' AND attributes LIKE '%home%' AND event NOT LIKE '%NCAA%' AND event_startdate > ".time()." AND event_startdate < $cutoff AND module=" . $module_id ." ORDER BY event_startdate";


		$games_r = $page->db->query($games_q);
		$games = $games_r->fetchAll(PDO::FETCH_ASSOC);
		if (count($games) == 0 ) { 
			?>
			<p>No games found for this sport. Please select a new sport.</p>
			<?php 
		} else 
		{ 
				
			foreach($games as $g){
					//id, event, date("l, F j, Y", $game["event_startdate"]
					?>
				<div class="well well-sm" id="checkbox_<?php echo $g["id"]; ?>">
				<div class="checkbox"><label>
					<div style="float: left; ">
						<strong><?php echo $g["event"]; ?></strong> <br/>
						<?php echo date("l, F j, Y", $g["event_startdate"]);?>
					</div>
					<div style="float: right; text-align: right; margin-top: 5px;">
						<input type="checkbox" class="gameCheckbox" value="<?php echo $g["id"]; ?>" id="<?php echo $g["id"]; ?>" name="games[]"/>
					</div>
				   </label>	</div>
				</div>
					<?php 
			}
		}
	     
		
		} else { 
			?>
			<p>No games found for this sport. Please select a new sport.</p>
			<?php 
		}
} else { 
	?>
    <p>Error retrieving games.</p>
    <?php 
}

$page->db = NULL;
?>