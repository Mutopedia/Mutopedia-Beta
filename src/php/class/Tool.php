<?php

class Tool
{
	public $newbdd;

	static $localisationTXTPath = 'http://s-beta.kobojo.com/mutants/gameconfig/localisation_en.txt';
	static $gamedefinitionsXMLPath = 'https://s-beta.kobojo.com/mutants/gameconfig/gamedefinitions.xml';
	static $bigDNAPNG = "http://s-ak.kobojo.com/mutants/assets/genes/";

	public function __construct()
	{
		if(!file_exists(self::$localisationTXTPath) OR !file_exists(self::$gamedefinitionsXMLPath))
		{
			return null;
		}
	}

	static function listSpecimen()
	{
		$dataArray['nameCode'] = array();
		$dataArray['name'] = array();
		$dataArray['specimenCount'] = "";

		$specimenList = file_get_contents(self::$localisationTXTPath);

		$searchfor = "Specimen_";
		$char_pos = 0;

		$nameCode_CharPos = 0;
		$name_CharPos = 0;

		while(($char_pos = strpos($specimenList, $searchfor, $char_pos)) !== false)
		{
			$namePos = $char_pos;

			$underscore_counter = 0;
			$underscore_char_pos = $char_pos;

			while($specimenList[$underscore_char_pos] != ";")
			{
				if($specimenList[$underscore_char_pos] == "_")
				{
					$underscore_counter++;
				}
				$underscore_char_pos++;
			}

			if($underscore_counter == 2)
			{
				$nameCode = "";
				while($specimenList[$namePos] != ";")
				{
 					$nameCode .= $specimenList[$namePos];
			   		$namePos++;
			   	}
			   	$dataArray['nameCode'][$nameCode_CharPos] = $nameCode;
			   	$nameCode_CharPos++;

			   	$namePos++;

			   	$name = "";
			   	while($specimenList[$namePos] != "\n")
			   	{
			   		$name .= $specimenList[$namePos];
			   		$namePos++;
			   	}
			   	$dataArray['name'][$name_CharPos] = $name;
			   	$name_CharPos++;

			   	$dataArray['specimenCount']++;
			}

			$char_pos++;
		}

		return $dataArray;
	}

	/*static function listSpecimen()
	{
		$dataArray['nameCode'] = array();
		$dataArray['name'] = array();
		$dataArray['specimenCount'] = "";

		$xmlDoc = new DOMDocument();
		$xmlDoc->load(self::$gamedefinitionsXMLPath);

		$specimen = $xmlDoc->getElementsByTagName("DynamicEntities")->item(0)->getElementsByTagName("EntityDescriptor");
		$specimenList = file_get_contents(self::$localisationTXTPath);

		$specimenCount = 0;

		foreach($specimen as $specimen)
		{
			if(strpos($specimen->getAttribute('id'), 'Specimen_') !== false)
			{
				$char_pos = 0;

				while(($char_pos = strpos($specimenList, $specimen->getAttribute('id'), $char_pos)) !== false)
				{
					$nameCode = "";
					$semiColonPos = $char_pos;
					while($specimenList[$semiColonPos] != ";")
					{
						$nameCode .= $specimenList[$semiColonPos];
						$semiColonPos++;
					}

					if($nameCode == $specimen->getAttribute('id'))
					{
						$name = "";
						$namePos = $semiColonPos + 1;
						while($specimenList[$namePos] != "\n")
						{
							$name .= $specimenList[$namePos];
							$namePos++;
						}

						$dataArray['nameCode'][$specimenCount] = $specimen->getAttribute('id');
						$dataArray['name'][$specimenCount] = $name;
						$specimenCount++;
					}

					$char_pos++;
				}
			}
		}

		$dataArray['specimenCount'] = $specimenCount;

		return $dataArray;
	}*/

	static function getSpecimens()
	{
		$returnSpecimen = array();
		$returnSpecimen = self::listSpecimen();

		$countSpecimen = 0;
		while($countSpecimen < $returnSpecimen['specimenCount'])
		{
			$mutantNameCode = $returnSpecimen['nameCode'][$countSpecimen];
			$mutantName = $returnSpecimen['name'][$countSpecimen];

			ob_start();
			include('../../models/specimen_list.php');
			$result_pos .= ob_get_contents();
			ob_end_clean();
			$countSpecimen++;
		}

		return $result_pos;
	}

	static function searchSpecimen($specimenName)
	{
		$returnSpecimen = array();
		$returnSpecimen = self::listSpecimen();

		if(isset($specimenName) && !empty($specimenName))
		{
			$countSpecimen = 0;
			while($countSpecimen < $returnSpecimen['specimenCount'])
			{
				$mutantNameCode = $returnSpecimen['nameCode'][$countSpecimen];
				$mutantName = $returnSpecimen['name'][$countSpecimen];

				if(strpos(strtolower($mutantName), strtolower($specimenName)) !== false)
				{
					ob_start();
					include('../../models/specimen_list.php');
					$dataArray['reply'] .= ob_get_contents();
					ob_end_clean();
				}
				$countSpecimen++;
			}

			$dataArray['result'] = true;
			$dataArray['error'] = null;
		}
		else
		{
			$dataArray['reply'] = self::getSpecimens();
			$dataArray['result'] = true;
			$dataArray['error'] = "specimenName is empty or invalid";
		}

		return $dataArray;
	}

	static function startBreeding($specimenNameCode_1, $specimenNameCode_2)
	{
		$dataArray['reply'] = "";

		$xmlDoc = new DOMDocument();
		$xmlDoc->load(self::$gamedefinitionsXMLPath);

		$xpath = new DOMXpath($xmlDoc);

		$specimen_1 = $xmlDoc->getElementsByTagName("DynamicEntities")->item(0)->getElementsByTagName("EntityDescriptor");
		$specimen_1_Code = "";
		$specimen_1_ODD = "";
		$specimen_1_DNA = "";
		$specimen_1_GEN = "";

		foreach($specimen_1 as $specimen_1)
		{
			$valueId = $specimen_1->getAttribute('id');

			if(strpos($valueId, $specimenNameCode_1) !== false)
			{
				$specimen_1_Code = $valueId;

				$specimenODD_query = $xpath->query('//EntityDescriptor[@id="'.$specimen_1_Code.'"]/Tag[@key="odds"]/@value')->item(0);
				$specimen_1_ODD = $specimenODD_query->value;

				$specimenDNA_query = $xpath->query('//EntityDescriptor[@id="'.$specimen_1_Code.'"]/Tag[@key="dna"]/@value')->item(0);
				$specimen_1_DNA = $specimenDNA_query->value;
				$specimen_1_DNA_split = str_split($specimen_1_DNA);

				if($specimenGEN_query = $xpath->query('//EntityDescriptor[@id="'.$specimen_1_Code.'"]/Tag[@key="type"]/@value')->item(0) != false)
				{
					$specimen_1_GEN = $specimenGEN_query->value;
				}
				else
				{
					$specimen_1_GEN = "NORMAL";
				}
			}
		}

		$specimen_2 = $xmlDoc->getElementsByTagName("DynamicEntities")->item(0)->getElementsByTagName("EntityDescriptor");
		$specimen_2_Code = "";
		$specimen_2_ODD = "";
		$specimen_2_DNA = "";
		$specimen_2_GEN = "";

		foreach($specimen_2 as $specimen_2)
		{
			$valueId = $specimen_2->getAttribute('id');

			if(strpos($valueId, $specimenNameCode_2) !== false)
			{
				$specimen_2_Code = $valueId;

				$specimenODD_query = $xpath->query('//EntityDescriptor[@id="'.$specimen_2_Code.'"]/Tag[@key="odds"]/@value')->item(0);
				$specimen_2_ODD = $specimenODD_query->value;

				$specimenDNA_query = $xpath->query('//EntityDescriptor[@id="'.$specimen_2_Code.'"]/Tag[@key="dna"]/@value')->item(0);
				$specimen_2_DNA = $specimenDNA_query->value;
				$specimen_2_DNA_split = str_split($specimen_2_DNA);

				if($specimenGEN_query = $xpath->query('//EntityDescriptor[@id="'.$specimen_2_Code.'"]/Tag[@key="type"]/@value')->item(0))
				{
					$specimen_2_GEN = $specimenGEN_query->value;
				}
				else
				{
					$specimen_2_GEN = "NORMAL";
				}
			}
		}

		$ODDS = 80;

		$Specimen_1_DNACode = substr($specimen_1_Code, -2);
		$Specimen_2_DNACode = substr($specimen_2_Code, -2);

		$specimen_1_DNA_lenght = strlen($specimen_1_DNA);
		$specimen_2_DNA_lenght = strlen($specimen_2_DNA);

		$resultDNA = array();

		if($specimen_1_DNA_lenght == 2 AND $specimen_2_DNA_lenght == 2)
		{
			$resultDNA[0] = $specimen_1_DNA_split[0].$specimen_2_DNA_split[0]."_01";
			$resultDNA[1] = $specimen_1_DNA_split[0].$specimen_2_DNA_split[1]."_01";
			$resultDNA[2] = $specimen_2_DNA_split[1].$specimen_1_DNA_split[0]."_01";
			$resultDNA[3] = $specimen_2_DNA_split[1].$specimen_2_DNA_split[0]."_01";
			$resultDNA[4] = $specimen_2_DNA_split[0].$specimen_2_DNA_split[1]."_01";
		}
		else if($specimen_1_DNA_lenght == 1 AND $specimen_2_DNA_lenght == 2)
		{
			$resultDNA[0] = $specimen_1_DNA_split[0].$specimen_2_DNA_split[0]."_01";
			$resultDNA[1] = $specimen_1_DNA_split[0].$specimen_2_DNA_split[1]."_01";
			$resultDNA[2] = $specimen_2_DNA_split[1].$specimen_1_DNA_split[0]."_01";
			$resultDNA[3] = $specimen_2_DNA_split[1].$specimen_2_DNA_split[0]."_01";
			$resultDNA[4] = $specimen_2_DNA_split[0].$specimen_2_DNA_split[1]."_01";
		}
		else if($specimen_1_DNA_lenght == 2 AND $specimen_2_DNA_lenght == 1)
		{
			$resultDNA[0] = $specimen_2_DNA_split[0].$specimen_1_DNA_split[0]."_01";
			$resultDNA[1] = $specimen_2_DNA_split[0].$specimen_1_DNA_split[1]."_01";
			$resultDNA[2] = $specimen_1_DNA_split[1].$specimen_2_DNA_split[0]."_01";
			$resultDNA[3] = $specimen_1_DNA_split[1].$specimen_1_DNA_split[0]."_01";
			$resultDNA[4] = $specimen_1_DNA_split[0].$specimen_1_DNA_split[1]."_01";
		}
		else if($specimen_1_DNA_lenght == 1 AND $specimen_2_DNA_lenght == 1)
		{
			$resultDNA[0] = $specimen_1_DNA_split[0].$specimen_2_DNA_split[0]."_01";
			$resultDNA[1] = $specimen_2_DNA_split[0].$specimen_1_DNA_split[0]."_01";
		}

		$resultDNA = array_unique($resultDNA);

		foreach($resultDNA as $key => $value)
		{
			$specimenODD_query = $xpath->query('//EntityDescriptor[@id="Specimen_'.$value.'"]/Tag[@key="odds"]/@value')->item(0);
			$specimenResult_ODD = $specimenODD_query->value;
			$specimenName = self::findSpecimenName('Specimen_'.$value);

			ob_start();
			include('../../models/mutant_container.php');
			$dataArray['reply'] .= ob_get_contents();
			ob_end_clean();
		}



		/*if($specimen_1_DNA_lenght == 1 OR $specimen_2_DNA_lenght == 1)
		{
			if($specimen_2_GEN)
			{

			}
		}
		else
		{

		}*/

		/*$dataArray['reply'] = "Spec_1_Code: ".$specimen_1_Code."\nSpec_1_GEN: ".$specimen_1_GEN."\nSpec_1_ODD: ".$specimen_1_ODD."\nSpec_1_DNA: ".$specimen_1_DNA."\nSpec1_DNACode: ".$Specimen_1_DNACode."\n\nSpec_2_Code: ".$specimen_2_Code."\nSpec_2_GEN: ".$specimen_2_GEN."\nSpec_2_ODD: ".$specimen_2_ODD."\nSpec_2_DNA: ".$specimen_2_DNA."\nSpec2_DNACode: ".$Specimen_2_DNACode."\n\n\n\nRESULT :\n".$resultDNA[0]."\n".$resultDNA[1]."\n".$resultDNA[2]."\n".$resultDNA[3]."\n".$resultDNA[4];*/
		$dataArray['result'] = true;
		$dataArray['error'] = null;

		return $dataArray;
	}

	static function findSpecimenName($nameCode)
	{
		$returnSpecimen = array();
		$returnSpecimen = self::listSpecimen();

		if(isset($nameCode) && !empty($nameCode))
		{
			$countSpecimen = 0;
			while($countSpecimen < $returnSpecimen['specimenCount'])
			{
				$mutantNameCode = $returnSpecimen['nameCode'][$countSpecimen];
				$mutantName = $returnSpecimen['name'][$countSpecimen];

				if(strpos(strtolower($mutantNameCode), strtolower($nameCode)) !== false)
				{
					return $mutantName;
				}
				$countSpecimen++;
			}
		}
	}

	static function findSpecimenNameCode($specimenName)
	{
		$returnSpecimen = array();
		$returnSpecimen = self::listSpecimen();

		$dataArray = array();

		$arrayId = 0;

		if(isset($specimenName) && !empty($specimenName))
		{
			$countSpecimen = 0;
			while($countSpecimen < $returnSpecimen['specimenCount'])
			{
				$mutantNameCode = $returnSpecimen['nameCode'][$countSpecimen];
				$mutantName = $returnSpecimen['name'][$countSpecimen];

				if(strpos(strtolower($mutantName), strtolower($specimenName)) !== false)
				{
					$dataArray[$arrayId] = $mutantNameCode;
					$arrayId++;
				}
				$countSpecimen++;
			}
		}

		return $dataArray;
	}

	static function getSpecimenDNA($nameCode)
	{
		$returnSpecimen = array();
		$returnSpecimen = self::listSpecimen();

		if(isset($nameCode) && !empty($nameCode))
		{
			$xmlDoc = new DOMDocument();
			$xmlDoc->load(self::$gamedefinitionsXMLPath);

			$xpath = new DOMXpath($xmlDoc);

			$specimenDNA_query = $xpath->query('//EntityDescriptor[@id="'.$nameCode.'"]/Tag[@key="dna"]/@value')->item(0);
			$specimen_DNA = $specimenDNA_query->value;
			$specimen_DNA_split = str_split($specimen_DNA);

			return $specimen_DNA_split;
		}
	}

	static function getIconDNA($DNA)
	{
		if(isset($DNA) && !empty($DNA))
		{
			switch ($DNA) {
				case "A":
					return self::$bigDNAPNG."big_a.png";
					break;
				case "B":
					return self::$bigDNAPNG."big_b.png";
					break;
				case "C":
					return self::$bigDNAPNG."big_c.png";
					break;
				case "D":
					return self::$bigDNAPNG."big_d.png";
					break;
				case "E":
					return self::$bigDNAPNG."big_e.png";
					break;
				case "F":
					return self::$bigDNAPNG."big_f.png";
					break;
			}
		}
	}
}

?>
