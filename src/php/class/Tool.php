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
		$specimenCount = 0;
		$dataArray[$specimenCount]['nameCode'] = array();
		$dataArray[$specimenCount]['name'] = array();

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
			   	$dataArray[$specimenCount]['nameCode'][$nameCode_CharPos] = $nameCode;
			   	$nameCode_CharPos++;

			   	$namePos++;

			   	$name = "";
			   	while($specimenList[$namePos] != "\n")
			   	{
			   		$name .= $specimenList[$namePos];
			   		$namePos++;
			   	}
			   	$dataArray[$specimenCount]['name'][$name_CharPos] = $name;
			   	$name_CharPos++;

			   	$specimenCount++;
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
		$result_pos = "";

		$countSpecimen = 0;
		while($countSpecimen < count($returnSpecimen))
		{
			$mutantNameCode = $returnSpecimen[$countSpecimen]['nameCode'][$countSpecimen];
			$mutantName = $returnSpecimen[$countSpecimen]['name'][$countSpecimen];

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
			while($countSpecimen < count($returnSpecimen))
			{
				$mutantNameCode = $returnSpecimen[$countSpecimen]['nameCode'][$countSpecimen];
				$mutantName = $returnSpecimen[$countSpecimen]['name'][$countSpecimen];

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

		$breedingLevel = 1;
		$ODD_final = 0;
		$isDoubleGene = false;

		$specimen_1 = $xmlDoc->getElementsByTagName("DynamicEntities")->item(0)->getElementsByTagName("EntityDescriptor");
		$specimen_1_Code = "";
		$specimen_1_ODD = "";
		$specimen_1_DNA = "";
		$specimen_1_TYPE = "";

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

				/*if($specimenTYPE_query = $xpath->query('//EntityDescriptor[@id="'.$specimen_1_Code.'"]/Tag[@key="type"]/@value')->item(0) !== false)
				{
					$specimen_1_TYPE = $specimenTYPE_query->value;
				}
				else
				{*/
					$specimen_1_TYPE = "NORMAL";
				/*}*/
			}
		}

		$specimen_2 = $xmlDoc->getElementsByTagName("DynamicEntities")->item(0)->getElementsByTagName("EntityDescriptor");
		$specimen_2_Code = "";
		$specimen_2_ODD = "";
		$specimen_2_DNA = "";
		$specimen_2_TYPE = "";

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

				if($specimenTYPE_query = $xpath->query('//EntityDescriptor[@id="'.$specimen_2_Code.'"]/Tag[@key="type"]/@value')->item(0))
				{
					$specimen_2_TYPE = $specimenTYPE_query->value;
				}
				else
				{
					$specimen_2_TYPE = "NORMAL";
				}
			}
		}

		$specimen_1_DNA_lenght = strlen($specimen_1_DNA);
		$specimen_2_DNA_lenght = strlen($specimen_2_DNA);

		$resultDNA = array();

		if($specimen_1_DNA_lenght == 2 AND $specimen_2_DNA_lenght == 2)
		{
			$resultDNA[0] = $specimen_1_DNA_split[0].$specimen_2_DNA_split[0]."_01";
			$resultDNA[1] = $specimen_1_DNA_split[0].$specimen_2_DNA_split[1]."_01";

			$resultDNA[2] = $specimen_1_DNA_split[1].$specimen_2_DNA_split[0]."_01";
			$resultDNA[3] = $specimen_1_DNA_split[1].$specimen_2_DNA_split[1]."_01";

			$resultDNA[4] = $specimen_2_DNA_split[0].$specimen_1_DNA_split[0]."_01";
			$resultDNA[5] = $specimen_2_DNA_split[0].$specimen_1_DNA_split[1]."_01";

			$resultDNA[6] = $specimen_2_DNA_split[1].$specimen_1_DNA_split[0]."_01";
			$resultDNA[7] = $specimen_2_DNA_split[1].$specimen_1_DNA_split[1]."_01";
		}
		else if($specimen_1_DNA_lenght == 1 AND $specimen_2_DNA_lenght == 2)
		{
			$resultDNA[0] = $specimen_2_DNA_split[0].$specimen_1_DNA_split[0]."_01";
			$resultDNA[1] = $specimen_2_DNA_split[1].$specimen_1_DNA_split[0]."_01";

			$resultDNA[2] = $specimen_1_DNA_split[0].$specimen_2_DNA_split[0]."_01";
			$resultDNA[3] = $specimen_1_DNA_split[0].$specimen_2_DNA_split[1]."_01";

			if(($specimen_1_DNA_split[0] == $specimen_2_DNA_split[0]) OR ($specimen_1_DNA_split[0] == $specimen_2_DNA_split[1]))
			{
				$resultDNA[4] = $specimen_1_DNA_split[0]."_01";
			}
		}
		else if($specimen_1_DNA_lenght == 2 AND $specimen_2_DNA_lenght == 1)
		{
			$resultDNA[0] = $specimen_1_DNA_split[0].$specimen_2_DNA_split[0]."_01";
			$resultDNA[1] = $specimen_1_DNA_split[1].$specimen_2_DNA_split[0]."_01";

			$resultDNA[2] = $specimen_2_DNA_split[0].$specimen_1_DNA_split[0]."_01";
			$resultDNA[3] = $specimen_2_DNA_split[0].$specimen_1_DNA_split[1]."_01";

			if(($specimen_2_DNA_split[0] == $specimen_1_DNA_split[0]) OR ($specimen_2_DNA_split[0] == $specimen_1_DNA_split[1]))
			{
				$resultDNA[4] = $specimen_2_DNA_split[0]."_01";
			}
		}
		else if($specimen_1_DNA_lenght == 1 AND $specimen_2_DNA_lenght == 1)
		{
			$resultDNA[0] = $specimen_1_DNA_split[0].$specimen_2_DNA_split[0]."_01";
			$resultDNA[1] = $specimen_2_DNA_split[0].$specimen_1_DNA_split[0]."_01";

			if(($specimen_1_DNA_split[0] == $specimen_2_DNA_split[0]))
			{
				$resultDNA[2] = $specimen_1_DNA_split[0]."_01";
				$resultDNA[3] = $specimen_2_DNA_split[0]."_01";
			}
		}

		$resultDNA = array_unique($resultDNA);

		$resultSpecimenODD = array();
		$resultSpecimenName = array();
		$resultSpecimenCount = 0;
		$total_ODD = 0;

		foreach($resultDNA as $key => $value)
		{
			$specimenODD_query = $xpath->query('//EntityDescriptor[@id="Specimen_'.$value.'"]/Tag[@key="odds"]/@value')->item(0);
			$specimenResult_ODD = $specimenODD_query->value;

			$specimenDNA_query = $xpath->query('//EntityDescriptor[@id="Specimen_'.$value.'"]/Tag[@key="dna"]/@value')->item(0);
			$specimenResult_DNA = $specimenDNA_query->value;

			if(($specimen_1_DNA_lenght == 1 AND $specimen_2_DNA_lenght == 2) OR ($specimen_1_DNA_lenght == 2 AND $specimen_2_DNA_lenght == 1) OR ($specimen_1_DNA_lenght == 2 AND $specimen_2_DNA_lenght == 2))
			{
				if(strlen($specimenResult_DNA) == 2)
				{
					$specimenResult_ODD = $specimenResult_ODD * 18;
				}
			}
			else if($specimen_1_DNA_lenght == 1 AND $specimen_2_DNA_lenght == 1)
			{
				if(strlen($specimenResult_DNA) == 2)
				{
					$specimenResult_ODD = $specimenResult_ODD * 4;
				}
			}

			$resultSpecimenODD[$resultSpecimenCount] = $specimenResult_ODD;
			$resultSpecimenName[$resultSpecimenCount] = self::findSpecimenName('Specimen_'.$value);
			$total_ODD = $total_ODD + $resultSpecimenODD[$resultSpecimenCount];

			$resultSpecimenCount++;
		}

		$resultCount = 0;
		while ($resultCount < $resultSpecimenCount)
		{
			$specimenName = $resultSpecimenName[$resultCount];
			$specimenODD = $resultSpecimenODD[$resultCount];
			$specimenPercent = round(($resultSpecimenODD[$resultCount] / $total_ODD) * 100, 1);

			ob_start();
			include('../../models/mutant_container.php');
			$dataArray['reply'] .= ob_get_contents();
			ob_end_clean();

			$resultCount++;
		}

		/*$dataArray['reply'] = $resultDNA;*/
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
			while($countSpecimen < count($returnSpecimen))
			{
				$mutantNameCode = $returnSpecimen[$countSpecimen]['nameCode'][$countSpecimen];
				$mutantName = $returnSpecimen[$countSpecimen]['name'][$countSpecimen];

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
