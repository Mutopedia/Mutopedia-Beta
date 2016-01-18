<div id="portal-box" class="popup-box">
	<div class="close-box" onClick="closePopUp();"></div>

	<div class="box-title">
		<h2>Portal of Mutopedia</h2>
	</div>

	<div class="box-content">
		<ul>
			<li>
				<h3>Hey <a><?php if(isset($_COOKIE['username'])){echo $_COOKIE['username'];}?></a>, we are happy to see you on Mutopedia !</h3>
			</li>
			<li>
				<p>En poursuivant votre navigation sur ce site, vous acceptez l’utilisation des <b>Cookies</b>.<br/>Ils vous offrirons une meilleure expérience utilisateur.</p>
			</li>
			<li>
				<div class="button" onClick="closePopUp();AcceptCookies();"><p>Thanks !</p></div>
			</li>
		</ul>
	</div>
</div>