<div id="admin-container">
<?php
	if(User::isLogged() AND User::isAdmin())
	{
?>
		<div class="title-container">
			<h1>Admin Panel</h1>
		</div>

		<div id="report-panel" class="panel">
			<div class="title-container">
				<img class="title-icon" src="src/img/default/report_icon.png"/><h2>Reports Panel</h2>
			</div>
			<div class="result-container">
				<?php echo Engine::getReports()['reply'];?>
			</div>
		</div>

		<div id="users-infos-panel" class="panel">
			<div class="title-container">
				<img class="title-icon" src="src/img/default/report_icon.png"/><h2>Users Infos Panel</h2>
			</div>
			<div class="result-container">
				<?php echo Engine::getUserInfos()['reply'];?>
			</div>
		</div>
<?php
	}
	else
	{
?>
		<h1>Sorry, you're not an Admin ! ;)</h1>
<?php
	}
?>
</div>
