<?php
	if(isset($argPage) AND !empty($argPage))
	{
?>
		<div id="profile-container">
			<div id="infos-container">
				<div class="user-picture">
					<img src="<?php echo User::getUserPicture($argPage);?>">
				</div>
				<div class="user-name">
					<h2><?php echo User::getUserUsername($argPage);?></h2>
				</div>
				<div id="user-tag-container">
					<p><?php echo $argPage;?></p>
				</div>

				<div id="facebook-infos-container">
<?php
				if(User::getFbPermission($argPage))
				{
?>
					<div class="button" onclick="openInNewTab('http://www.facebook.com/<?php echo User::getUserFbid($argPage);?>');">
						<img src="img/default/facebook_icon.png"/><p>Facebook Profile</p>
					</div>
<?php
				}
				if(User::isLogged() AND (User::getToken() == User::getUserToken($argPage)))
				{
?>
					<div id="fb-permission-container">
<?php
					if(User::getFbPermission($argPage))
					{
?>
						<input type="checkbox" name="fb-permission" checked="checked">
<?php 
					}
					else
					{
?>
						<input type="checkbox" name="fb-permission" >
<?php
					}
?>
						<p>Authorize Mutopedia to show my Facebook Profile</p>
					</div>
<?php
				}
?>
				</div>

				<ul id="user-info-container">
					<h2>Information <?php echo $argPage;?> :</h2>
<?php
					if(User::isLogged() AND (User::getToken() == User::getUserToken($argPage)))
					{
?>
						<div id="charter-acceptance-container">
<?php
						if(User::getCharterAcceptance($argPage))
						{
?>
							<input type="checkbox" name="fb-permission" checked="checked">
<?php 
						}
						else
						{
?>
							<input type="checkbox" name="fb-permission" >
<?php
						}
?>
							<p>I certify to have gave real informations and I accept the risk of being banned</p>
						</div>
<?php

						if(User::getCharterAcceptance($argPage))
						{
?>
							<div id="charter-acceptance-blocker" class="unactivate">
<?php
						}
						else
						{
?>
							<div id="charter-acceptance-blocker" class="activate">
<?php
						}
?>
								<h2>You must check the acceptance of the charter before edit your account !</h2>
							</div>
<?php
						}
?>
					<li id="user-mutant-container">
<?php
						if(User::isLogged() AND (User::getToken() == User::getUserToken($argPage)))
						{
?>
							<h3>Mutant :</h3>
							<div class="select" value="<?php echo User::getUserMutant($argPage);?>">
								<div class="icon">
						
								</div>
								<div class="value">
									<h3><?php echo Tool::findSpecimenName(User::getUserMutant($argPage));?></h3>
								</div>
								<div class="search">
									<input type="text" placeholder="Search a specimen">
								</div>
								<div class="ul">
									<?php echo Tool::getSpecimens();?>
								</div>
							</div>
<?php
						}
						else
						{
?>
							<h3>Mutant : <span class="mark">
							<?php 
								if(Tool::findSpecimenName(User::getUserMutant($argPage)) !== null)
								{
									echo Tool::findSpecimenName(User::getUserMutant($argPage));
								}
								else
								{
									echo "None selected mutant";
								}
							?>
							</span></h3>
<?php
						}
?>
					</li>

					<li id="center-level-container">
<?php
						if(User::isLogged() AND (User::getToken() == User::getUserToken($argPage)))
						{
?>
							<h3>Center Level : </h3><input type="number" value="<?php echo User::getUserCenterLevel($argPage);?>" name="center-level" min="0">
<?php
						}
						else
						{
?>
							<h3>Center Level : <span class="mark"><?php echo User::getUserCenterLevel($argPage);?></span></h3>
<?php
						}
?>
					</li>

					<li id="fame-level-container">
<?php
						if(User::isLogged() AND (User::getToken() == User::getUserToken($argPage)))
						{
?>
							<h3>Fame Level : </h3><input type="number" value="<?php echo User::getUserFameLevel($argPage);?>" name="fame-level" min="0">
<?php
						}
						else
						{
?>
							<h3>Fame Level : <span class="mark"><?php echo User::getUserFameLevel($argPage);?></span></h3>
<?php
						}
?>
					</li>
				</ul>
			</div>

<?php 
		if(User::isLogged() AND (User::getToken() == User::getUserToken($argPage)))
		{
?>
			<div id="profile-options">
				<div class="button" onClick="disconnectApp()">
					<h2>Log out</h2>
				</div>
			</div>
<?php
		}
?>
		</div>
<?php
	}
?>