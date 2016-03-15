<div id="profile-box" class="popup-box">
	<div class="close-box"></div>

	<div class="box-title">
		<h2>Attention <?php echo User::getUsername();?> !</h2>
	</div>

	<div class="box-content">
		<ul>
			<li>
				<p>
					A little message to tell you that the profile system used on the site currently relies on the confidence of the players. If you spot a player profile with false information, report it using the button "Report Player", thank you for your help !<br/><br/>
					In future updates, the system will be directly connected to Kobojo server, the information of the players can not be changed and will be updated directly from the game.
				</p>
			</li>
			<li>
				<div class="button" onClick="Interface.closePopUp('profile-box');"><p>Okay</p></div>
			</li>
		</ul>
	</div>
</div>
