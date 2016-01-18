<?php

class Breeding extends Tool
{
	var $localisationTXTPath;
	$localisationTXTPath = "http://s-beta.kobojo.com/mutants/gameconfig/localisation_fr.txt";

	public function __construct()
	{
		getSpecimens();
	}

	private function getSpecimens()
	{
		$homepage = file_get_contents($localisationTXTPath);
		echo $homepage;
	}
}

?>