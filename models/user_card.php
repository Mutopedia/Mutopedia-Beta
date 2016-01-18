<div class="user-container row" onclick="loadModel('profile', '<?php echo $getUserInfos['userlink'];?>')">
	<div class="user-picture">
		<img src="<?php echo $getUserInfos['fb_picture'];?>">
	</div>
	<div class="user-name">
		<h3><?php echo $getUserInfos['fb_firstname'].' '.$getUserInfos['fb_lastname'];?></h3>
	</div>
	<div class="mutant-tag">
		<h4><?php echo Tool::findSpecimenName($getUserInfos['user_mutant_namecode']);?></h4>
	</div>
<?php
		if(isset($getUserInfos['user_mutant_namecode']) AND !empty($getUserInfos['user_mutant_namecode']))
		{
?>
			<div class="mutant-dna">
				<img class="icon-dna" src="<?php echo Tool::getIconDNA(Tool::getSpecimenDNA($getUserInfos['user_mutant_namecode'])[0]);?>" />
	<?php
			if(Tool::getSpecimenDNA($getUserInfos['user_mutant_namecode'])[1] !== null)
			{
	?>
				<img class="icon-dna" src="<?php echo Tool::getIconDNA(Tool::getSpecimenDNA($getUserInfos['user_mutant_namecode'])[1]);?>" />
	<?php
			}
	?>
			</div>
<?php
		}

		if(isset($getUserInfos['fame_level']) AND !empty($getUserInfos['fame_level']))
		{
?>
			<div class="user-fame-level">
				<h4><?php echo $getUserInfos['fame_level'];?></h4>
			</div>
<?php
		}

		if(isset($getUserInfos['center_level']) AND !empty($getUserInfos['center_level']))
		{
?>
			<div class="user-center-level">
				<h4><?php echo $getUserInfos['center_level'];?></h4>
			</div>
<?php
		}
?>
</div>
