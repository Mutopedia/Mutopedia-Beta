<?php
if(Engine::getReleaseDate('portal')['result'] != false AND Engine::getReleaseDate('portal')['reply'] != null)
{
	header("Location: ".WEBROOT."portal");
}
?>