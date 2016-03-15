<div id="messenger-container">
<?php
	if(User::isLogged())
	{
?>
		<div class="title-container">
			<h1>Messenger</h1>
		</div>

		<div id="users-messages-panel">
				<?php echo User::getMessagesUsers()['error'];?>
				<?php echo User::getMessagesUsers()['reply'];?>
		</div>
<?php
	}
	else
	{
?>
		<h1>Sorry, you're not Logged !</h1>
<?php
	}
?>
</div>
