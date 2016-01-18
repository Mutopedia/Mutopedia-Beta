<?php
	// GET URL SITE
	$siteProtocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),"https") === FALSE ? "http" : "https";
	$siteHost = $_SERVER['HTTP_HOST'];
	$siteUrl = $siteProtocol."://".$siteHost;
	define('URL', $siteUrl, true);

	// Define directory.
	if(strpos($_SERVER['SCRIPT_NAME'], 'index.php') !== false)
	{
		define('ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']), true);
		define('WEBROOT', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']), true);
	}
	else if(strpos($_SERVER['SCRIPT_NAME'], 'portal.php') !== false)
	{
		define('ROOT', str_replace('portal.php', '', $_SERVER['SCRIPT_FILENAME']), true);
		define('WEBROOT', str_replace('portal.php', '', $_SERVER['SCRIPT_NAME']), true);
	}
	else if(strpos($_SERVER['SCRIPT_NAME'], 'admin.php') !== false)
	{
		define('ROOT', str_replace('admin.php', '', $_SERVER['SCRIPT_FILENAME']), true);
		define('WEBROOT', str_replace('admin.php', '', $_SERVER['SCRIPT_NAME']), true);
	}
	else if(strpos($_SERVER['SCRIPT_NAME'], 'privacy.php') !== false)
	{
		define('ROOT', str_replace('privacy.php', '', $_SERVER['SCRIPT_FILENAME']), true);
		define('WEBROOT', str_replace('privacy.php', '', $_SERVER['SCRIPT_NAME']), true);
	}
	define('IMG', WEBROOT.'img/', true);
	define('JS', WEBROOT.'src/js/', true);
	define('PHP', ROOT.'src/php/', true);
	define('CSS', WEBROOT.'css/', true);
	define('INCLUDES', ROOT.'includes/', true);
	define('MODELS', ROOT.'models/', true);
	
	// Define social media url.
	define('TWITTER', 'https://www.twitter.com/mutopedia', true);
	define('FACEBOOK', 'https://www.facebook.com/mutopedia', true);
?>