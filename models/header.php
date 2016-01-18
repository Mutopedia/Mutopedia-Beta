<nav id="top-bar">
	<ul id="left-ul">
		<li id="top-icon"><a href=""><img src="img/default/icon.png"/></a></li>
		<div id="top-bar-left-separator"></div>
		<li id="title-message"><p>Welcome on <a href="">Mutopedia</a> :<i> The World of Mutants Genetics Gladiators</i></p></li>
	</ul>
	<ul id="right-ul">
		<div id="top-bar-right-separator"></div>
<?php 
		if(!User::isLogged())
		{
?>
			<div class="loading">
				<img src="img/default/loading.gif">
			</div>
<?php 
		}
		else
		{
?>
			<li id="fb-status" onClick="loadModel('profile', '<?php echo User::getUserLink();?>')">
				<h3><?php echo User::getUsername();?></h3>
			</li>
			<li id="fb-profile-picture" onClick="loadModel('profile', '<?php echo User::getUserLink();?>')">
				<img src="<?php echo User::getPicture();?>"/>
			</li>
<?php
		}
?>
	</ul>
</nav>

<div id="news-bar">
	<p><a>Mutopedia users :</a> <i>The site is in Beta, the updates are performed regularly and are not necessarily advertised if we think it is not necessary, so do not hesitate to return to the site from time to time!</i></p>
</div>

<nav id="menu-nav">
	<ul>
		<li name="home" class="unactive" onClick="loadModel('home')"><h3>HOME</h3></li>
		<li name="search" class="unactive" onClick="loadModel('search')"><h3>SEARCH</h3></li>
		<li name="breeding" class="unactive" onClick="loadModel('breeding')"><h3>BREEDING</h3></li>
<?php 
	if(User::isLogged())
	{
?>
		<li name="profile" class="unactive" onClick="loadModel('profile', '<?php echo User::getUserLink();?>')"><h3>PROFILE</h3></li>
<?php
	}
?>
		<li class="unactive"><h3>FAN'ART</h3></li>
		<li class="unactive"><h3>FORUM</h3></li>
		<li class="unactive"><h3>CONTACT</h3></li>
		<li class="unactive"><h3>LINKS</h3></li>
	</ul>
</nav>