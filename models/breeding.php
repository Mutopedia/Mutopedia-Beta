<?php
	$specimentList = Tool::getSpecimens();
?>

<div id="tool_container">
	<div id="back_tool">
		<div id="left_panel">
			<div id="input_container">
				<div class="select" value="Specimen_A_01">
					<div class="icon">
				 				
				 	</div>
				 	<div class="value">
				 		<h3>Robot</h3>
				 	</div>
				 	<div class="search">
				 		<input type="text" placeholder="Search a specimen">
				 	</div>
				  	<div class="ul">
				  		<?php echo $specimentList; ?>
				  	</div>
				 </div>
			</div>
		</div>

		<div id="right_panel">
			<div id="input_container">
				<div class="select" value="Specimen_A_01">
					<div class="icon">
				 				
				 	</div>
				 	<div class="value">
				 		<h3>Robot</h3>
				 	</div>
				 	<div class="search">
				 		<input type="text" placeholder="Search a specimen">
				 	</div>
				  	<div class="ul">
						<?php echo $specimentList; ?>
				  	</div>
				</div>
			</div>
		</div>

		<div id="odds_container">
			
		</div>

		<div id="play_button" onClick="startBreeding()">
			<h2>LANCER</h2>
		</div>

		<div id="">
			
		</div>

		<div id="breeding_center">
			
		</div>
	<div>
</div>