<div id="message_user-box" class="popup-box">
	<div class="close-box"></div>

	<div class="box-title">
		<h2>Message to <?php echo User::getUserUsername($argPage);?></h2>
	</div>

	<div class="box-content">
		<ul>
			<li>
				<p>Send a message to <?php echo User::getUserUsername($argPage);?></p>
			</li>
			<li>
				<textarea id="message_content" placeholder="Your message here"></textarea>
			</li>
			<li>
				<p><i>Message from <?php echo User::getUsername();?></i></p>
			</li>
			<li>
				<div class="button" onClick="Engine.sendUserMessage('<?php echo $argPage;?>');"><p>Send Message</p></div>
			</li>
		</ul>
	</div>
</div>
