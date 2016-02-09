<div id="admin-container">
<?php
	if(User::isLogged() AND User::isAdmin())
	{
?>
		<div class="title-container">
			<h1>Admin Panel</h1>
		</div>

		<div id="report-panel">
			<div class="title-container">
				<img class="title-icon" src="src/img/default/report_icon.png"/><h2>Report Panel</h2>
			</div>
			<div id="report-result-container">
				<?php echo Engine::getReports()['reply'];?>
			</div>
		</div>
<?php
	}
	else
	{
?>
		<h1>Sorry, you're not an Admin !</h1>
<?php
	}
?>
</div>
