<?php
	session_start();
	include('includes/define_header.php');
	require(PHP."class/bdd.php");
	require(PHP."class/Engine.php");
?>

<!DOCTYPE html>
<html>
	<head>
		<script type="text/javascript">
			window.history.pushState({page: 'portal'}, 'portal', 'portal');
		</script>
		<?php include(INCLUDES.'head_default.php');?>
		<link rel="stylesheet" type="text/css" href="<?php echo CSS;?>portal_style.css">
		<link rel="stylesheet" media="screen and (max-width: 1600px)" type="text/css" href="<?php echo CSS;?>portal_1600_mini_style.css">
		<link rel="stylesheet" media="screen and (max-width: 1400px)" type="text/css" href="<?php echo CSS;?>portal_1400_mini_style.css">
		<link rel="stylesheet" media="screen and (max-width: 1200px)" type="text/css" href="<?php echo CSS;?>portal_1200_mini_style.css">
		<link rel="stylesheet" media="screen and (max-width: 1000px)" type="text/css" href="<?php echo CSS;?>portal_1000_mini_style.css">
	</head>

	<body>
		<?php include_once(INCLUDES."analyticstracking.php") ?>
		<?php include_once(INCLUDES."analyticstracking_2.php") ?>

		<section id="portal-container">
			<div id="video-container">
				<video autoplay loop poster="img/portal/portal_preview.jpg" id="bgvid">
					<source src="img/portal/portal_animation.mp4" type="video/mp4">
				</video>
				<audio autoplay loop>
					<source src="img/portal/portal_audio.mp3" type="audio/mpeg">
				</audio>
			</div>

			<div id="text-container">
				<div id="counter-container">
					<h5><span id="text-counter">TIME LEFT :</span> <span id="counter"><?php echo Engine::getReleaseDate('portal', 1234)['reply'];?></span></h5>
				</div>
				<div id="site-container">
					<h4>mutopedia.com</h4>
				</div>
				<div id="button-container" class="unactivate">
					<h1>ENTER</h1>
				</div>
			</div>

		</section>

		<footer>
			<span class="align-middle"></span>
			<div id="copyright-container">
				<h4>
					<i>Please, respect the work of the staff, who spent a lot of time to create picture, daily news, videos and others things for helping you.<br/>
					So we ask you, to not steal, if you want to share a picture, you must quote our web site or our facebook group.<br/><br/></i>

					<b>Copyright © <a>Mutopedia</a> (Torak & tymmesyde)</b>
				</h4>
			</div>
		</footer>

		<?php
			include('includes/sorry_box.php');
		?>
		<script type="text/javascript">
			showPopUp("sorry-box");
		</script>
	</body>
</html>
