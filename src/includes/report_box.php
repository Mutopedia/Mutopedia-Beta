<div id="report-box" class="popup-box">
	<div class="close-box"></div>

	<div class="box-title">
		<h2>Report : <?php echo User::getUserUsername($argPage);?></h2>
	</div>

	<div class="box-content">
		<ul>
			<li>
				<p>Please, give us the exact reason of the report of <?php echo User::getUserUsername($argPage);?> in the fields below :</p>
			</li>
			<li>
				<textarea id="report_message" placeholder="Reason of the report ..."></textarea>
			</li>
			<li>
				<p><i>Report from <?php echo User::getUsername();?></i></p>
			</li>
			<li>
				<div class="button" onClick="Engine.sendReport('<?php echo $argPage;?>');"><p>Send report</p></div>
			</li>
		</ul>
	</div>
</div>
