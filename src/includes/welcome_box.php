<div id="welcome-box" class="popup-box">
	<div class="close-box" onClick="closePopUp();"></div>

	<div class="box-title">
		<h2>Welcome on Mutopedia ALPHA</h2>
	</div>

	<div class="box-content">
		<ul>
			<li>
				<h3>Hey <a><?php if(isset($_COOKIE['username'])){echo $_COOKIE['username'];}?></a>, we are happy to see you on Mutopedia ALPHA !</h3>
			</li>
			<li>
				<p>By continuing your visit to this site, you accept the use of <b>Cookies</b>.</p>
			</li>
			<li>
				<div class="button" onClick="Interface.closePopUp('welcome-box');Engine.AcceptCookies();"><p>Thanks !</p></div>
			</li>
		</ul>
	</div>
</div>
