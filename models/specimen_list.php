<div class="li" value=<?php echo $mutantNameCode; ?>>
	<div class="mutant-name-container">
		<p><?php echo $mutantName; ?></p>
	</div>
	<div class="mutant-icon-dna-container">
		<img class="icon-dna" src="<?php echo $mutantIconDNA_0;?>"/>
<?php
	if(!empty($mutantIconDNA_1))
	{
?>
		<img class="icon-dna" src="<?php echo $mutantIconDNA_1;?>"/>
<?php
	}
?>
	</div>
</div>