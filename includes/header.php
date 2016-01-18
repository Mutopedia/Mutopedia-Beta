<header>
	<nav id="top-bar">
		<ul id="left-ul">
			<li id="top-icon"><a href="<?php echo WEBROOT;?>"><img src="img/default/icon.png"/></a></li>
			<div id="top-bar-left-separator"></div>
			<li id="title-message"><p>Welcome on <a href="<?php echo WEBROOT;?>">Mutopedia</a> :<i> The World of Mutants Genetics Gladiators</i></p></li>
		</ul>
		<ul id="right-ul">
			<div id="top-bar-right-separator"></div>
			<div class="loading">
				<img src="<?php echo IMG;?>default/loading.gif">
			</div>
			<li id="fb-status" onClick="loadModel('profile', '<?php echo User::getUserLink();?>')">
				<h3></h3>
			</li>
			<li id="fb-profile-picture" onClick="loadModel('profile', '<?php echo User::getUserLink();?>')">
				<img src=""/>
			</li>
		</ul>
	</nav>

	<div id="news-bar">
		<p><a>Offre anticipée Platine :</a> <i>Ce pack contient 2 Étoiles d'Or et une Étoile Platine Offerte. Prépare toi pour la sortie des mutants Platine ! Offre unique limitée à 1000 exemplaires !</i></p>
	</div>

	<nav id="menu-nav">
		<ul>
			<li name="home" class="unactive" onClick="loadModel('home')"><h3>HOME</h3></li>
			<li name="search" class="unactive" onClick="loadModel('search')"><h3>SEARCH</h3></li>
			<li name="breeding" class="unactive" onClick="loadModel('breeding')"><h3>BREEDING</h3></li>
			<li name="profile" class="unactive" onClick="loadModel('profile', '<?php echo User::getUserLink();?>')"><h3>PROFILE</h3></li>
			<li class="unactive"><h3>FAN'ART</h3></li>
			<li class="unactive"><h3>FORUM</h3></li>
			<li class="unactive"><h3>CONTACT</h3></li>
			<li class="unactive"><h3>LINKS</h3></li>
		</ul>
	</nav>
</header>