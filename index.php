<?php
	session_start();
	include('includes/define_header.php');
	require(PHP."class/bdd.php");
	require(PHP."class/Engine.php");
	require(PHP."class/User.php");

	/*require(INCLUDES."release.php");*/
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
				<?php
					if(isset($_GET['page']) AND !empty($_GET['page']))
					{
						$modelName = $_GET['page'];

						if(isset($_GET['argPage']) AND !empty($_GET['argPage']))
						{
							$argPage = $_GET['argPage'];
						}
						else
						{
							$argPage = 'null';
						}
				?>
						loadModel('<?php echo $modelName;?>', '<?php echo $argPage;?>');
				<?php
					}
					else
					{
				?>
						loadModel('home', null, false);
				<?php
					}
				?>
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
			include('includes/logInToFb_box.php');
			include('includes/welcome_box.php');
			include('includes/profile_box.php');
		?>

		<div id="background-container"><!--onClick="closePopUp();closeBackground();"-->
		</div>
	</body>
</html>
