<div class="user-container row" onclick="Interface.loadModel('profile', '<?php echo $getUserInfos['id'];?>')">
	<div class="user-picture">
		<img src="<?php echo $getUserInfos['fb_picture'];?>">
	</div>
	<div class="user-name">
		<h3><?php echo $getUserInfos['fb_firstname'].' '.$getUserInfos['fb_lastname'];?></h3>
	</div>
	<div class="mutant-tag">
		<h4><?php echo Tool::findSpecimenName($getUserInfos['user_mutant_namecode']);?></h4>
	</div>

	<div class="mutant-dna">
<?php
		if(isset($getUserInfos['user_mutant_namecode']) AND !empty($getUserInfos['user_mutant_namecode']))
		{
			if(isset($mutantIconDNA_0) AND !empty($mutantIconDNA_0))
			{
?>
				<img class="icon-dna" src="<?php echo $mutantIconDNA_0;?>" />
<?php
			}
			if(isset($mutantIconDNA_1) AND !empty($mutantIconDNA_1))
			{
?>
				<img class="icon-dna" src="<?php echo $mutantIconDNA_1;?>" />
<?php
			}
		}
?>
	</div>

	<div class="user-fame-level">
<?php
		if(isset($getUserInfos['fame_level']) AND !empty($getUserInfos['fame_level']))
		{
?>
			<h4><?php echo $getUserInfos['fame_level'];?></h4>
<?php
		}
?>
	</div>

	<div class="user-center-level">
<?php
	if(isset($getUserInfos['center_level']) AND !empty($getUserInfos['center_level']))
	{
?>
		<h4><?php echo $getUserInfos['center_level'];?></h4>
<?php
	}
?>
	</div>
</div>
