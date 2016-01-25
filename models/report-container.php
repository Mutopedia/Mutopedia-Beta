<div class="report-container">
	<div class="user-report-container">
		<div class="report-infos-container">
			<h3><?php echo $getReportsInfos['id'];?># Reported on <?php echo date("d/m/Y - H:i", $getReportsInfos['date']);?></h3>
		</div>
		<div class="report-from-user" onclick="loadModel('profile', '<?php echo $getReportsInfos['reporting_from'];?>')">
			<div class="user-picture">
				<img src="<?php echo User::getUserPicture($getReportsInfos['reporting_from']);?>">
			</div>
			<h3><?php echo User::getUsername($getReportsInfos['reporting_from']);?></h3>
			<h3><?php echo '('.$getReportsInfos['reporting_from'].')';?></h3>
		</div>
		<div class="reported-user" onclick="loadModel('profile', '<?php echo $getReportsInfos['reported_player'];?>')">
			<div class="user-picture">
				<img src="<?php echo User::getUserPicture($getReportsInfos['reported_player']);?>">
			</div>
			<h3><?php echo User::getUserUsername($getReportsInfos['reported_player']);?></h3>
			<h3><?php echo '('.$getReportsInfos['reported_player'].')';?></h3>
		</div>
	</div>
	<div class="report-message">
		<h3>Message Report :</h3>
		<p><< <?php echo $getReportsInfos['report_message'];?> >></p>
	</div>
</div>