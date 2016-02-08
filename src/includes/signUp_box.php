<div id="signUp-box" class="popup-box">
	<div class="close-box" onClick="closePopUp();"></div>

	<div class="box-title">
		<h2>SignUp</h2>
	</div>

	<div class="box-content">
		<form id="signUp-form">
			<ul>
				<li><input id="email-input" name="email" type="email" placeholder="Email"></li>
				<span class="info-form-input"><span class="left-arrow"></span><p></p></span>
			</ul>
			<ul>
				<li><input id="username-input" name="username" type="text" placeholder="Username"></li>
				<span class="info-form-input"><span class="left-arrow"></span><p></p></span>
			</ul>
			<ul>
				<li><input id="password-input" name="password" type="password" placeholder="Password"></li>
				<span class="info-form-input"><span class="left-arrow"></span><p></p></span>
			</ul>
			<ul class="submit-container">
				<div onClick="regUser()" class="button">
					<p>Create account</p>
				</div>
			</ul>
		</form>

		<div class="message-container">
			<h2>Success !</h2>
			<p></p>
		</div>
		<div class="error-container">
			<h2>Error ...</h2>
			<p></p>
		</div>
	</div>
</div>