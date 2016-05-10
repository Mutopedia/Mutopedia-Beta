<div class="user-container">
	<div class="user-id">
		<h3><?php echo $getUserInfos['id'];?>#</h3>
	</div>
	<div class="user-picture cursor-pointer" onclick="Interface.loadModel('profile', '<?php echo $getUserInfos['id'];?>')">
		<img src="<?php echo $getUserInfos['fb_picture'];?>">
	</div>
	<div class="user-name cursor-pointer" onclick="Interface.loadModel('profile', '<?php echo $getUserInfos['id'];?>')">
		<h3><?php echo $getUserInfos['fb_firstname'].' '.$getUserInfos['fb_lastname'];?></h3>
	</div>
	<div class="user-email">
		<h3><?php echo $getUserInfos['email'];?></h3>
	</div>
	<div class="user-ip">
		<h3><?php echo $getUserInfos['user_ip'];?></h3>
	</div>
</div>
