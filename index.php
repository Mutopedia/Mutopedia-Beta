<?php
	session_start();

	require("src/includes/define_header.php");
	require("src/php/class/bdd.php");
	require("src/php/class/Engine.php");
	require("src/php/class/User.php");
	require("src/php/class/Tool.php");
	$MutopediaTool = new Tool();

	/*require(INCLUDES."release.php");*/

	if(isset($_GET['page']) AND !empty($_GET['page'])){
		$pageName = htmlentities($_GET['page']);
	}else {
		$pageName = "home";
	}

	if(isset($_GET['argPage']) AND !empty($_GET['argPage'])){
		$argPage = htmlentities($_GET['argPage']);
	}else {
		$argPage = null;
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include(INCLUDES.'head_default.php');?>
	</head>

	<body>
		<?php include_once(INCLUDES."analyticstracking.php") ?>

		<header>
			<div id="header-container">
				<?php include(MODELS.'header.php');?>
			</div>
		</header>

		<section id="ajax-loader">
			<div id="ajax-container">
				<script type="text/javascript">
					App.init();
					Interface.loadModel('<?php echo $pageName;?>', '<?php echo $argPage;?>');
				</script>
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
			include(INCLUDES.'logInToFb_box.php');
			include(INCLUDES.'welcome_box.php');
			include(INCLUDES.'profile_box.php');
		?>

		<div id="background-container"><!--onClick="closePopUp();closeBackground();"-->
		</div>
	</body>
</html>
