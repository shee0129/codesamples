<?php 
include($_SERVER['DOCUMENT_ROOT'] . "/include/db_connect.php");

if (isset($_GET["sport"]) && is_numeric($_GET["sport"])) {
	$sport = array();
	$sport["module_id"] = $_GET["sport"]; 
	//Get the date of the next July 1st. This way, we can only return events up until the end of the current season.
	$cutoff = strtotime("7/1 next year");
	
	//Check if there are events for the given period of time. 
	$sth = $db->prepare("SELECT COUNT(id) AS num_events FROM calendar WHERE attributes LIKE '%contest%' AND attributes LIKE '%global%' AND attributes LIKE '%home%' AND event NOT LIKE '%NCAA%' AND event_startdate > ".time()." AND event_startdate < $cutoff AND module=:module_id");
	$sth->execute($sport);
	$count = $sth->fetch(PDO::FETCH_ASSOC);
	if ($count["num_events"] > 0) { 
		$sth = $db->prepare("SELECT id, event, event_startdate FROM calendar WHERE attributes LIKE '%contest%' AND attributes LIKE '%global%' AND attributes LIKE '%home%' AND event NOT LIKE '%NCAA%' AND event_startdate > ".time()." AND event_startdate < $cutoff AND module=:module_id ORDER BY event_startdate");
		$er = $sth->execute($sport);
		if ($er === false) { 
			?>
			<p>No games found for this sport. Please select a new sport.</p>
			<?php 
		} else { 
			?>
			<p><table border="0" cellpadding="0" cellspacing="0" width="100%" style="width:100%;">
			<?php
			$i = 1; 
			while ($game = $sth->fetch(PDO::FETCH_ASSOC)) {
				if ($i % 2 != 0) { 
					echo "<tr><td>"; 
				} else { 
					echo "<td>"; 
				}
				?>
				<p class="unselectedgame" id="graf<?php echo $game["id"]; ?>"><span style="float:right; margin:auto;"><input type="checkbox" name="game[<?php echo $game["id"]; ?>]" class="gamecheck" /></span><span style="font-weight:bold; font-size:14px;"><?php echo $game["event"]; ?></span>
				<br /><span style="font-size:10px;"><?php echo date("l, F j, Y", $game["event_startdate"]);?></span></p>
				<?php 
				if ($i % 2 != 0) { 
					echo "</td>";
				} else { 
					echo "</td></tr>";
				}
				
				$i++;
			}
			if ($i % 2 == 0) { 
				echo "<td>&nbsp;</td></tr>"; 
			}
			?>
			</table></p>
			<?php 
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

$db = NULL;
?>