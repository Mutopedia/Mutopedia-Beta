<?php
  $dataArray = array();
  $dataArray['reply'] = "";

  $spritesXMLPath = 'https://s-beta.kobojo.com/mutants/gameconfig/sprites.xml';
  $spritesSpecimen_A_01 = 'specimen_A_01.xml';
  $specimenCode = "Specimen_A_01";

  $xmlDoc = new DOMDocument();

  if(@$xmlDoc->load($spritesSpecimen_A_01) === false)
  {
    $dataArray['reply'] = null;
  }
  else
  {
    $xpath = new DOMXpath($xmlDoc);

    $specimenCode = lcfirst($specimenCode);

    $bitmapMutant = $xmlDoc->documentElement->getAttributeNode('bitmap')->nodeValue;

    $filename = 'http://s-ak.kobojo.com/mutants/assets/'.$bitmapMutant;
    list($width, $height, $type, $attr) = getimagesize($filename);

    $dataArray['reply'] .= 'Image bitmap of '.$specimenCode.'_stand : '.$bitmapMutant;

    $dataArray['reply'] .= 'Image from Composite :';

    $compositeNode = $xmlDoc->getElementsByTagName("Composite");

    $specimenArray = array();

    $imageCount = 0;
    foreach ($compositeNode as $compositeNode) {
      $dataArray['reply'] .= '</br/>#'.$imageCount.' > ';

      $imageNode = $compositeNode->getElementsByTagName("Sprite")->item(0)->getElementsByTagName("Image")->item(0);

      $specimenImage_srcX_value = $imageNode->getAttributeNode('srcX')->nodeValue;
      $specimenImage_srcY_value = $imageNode->getAttributeNode('srcY')->nodeValue;
      $specimenImage_dstX_value = $imageNode->getAttributeNode('dstX')->nodeValue;
      $specimenImage_dstY_value = $imageNode->getAttributeNode('dstY')->nodeValue;
      $specimenImage_width_value = $imageNode->getAttributeNode('width')->nodeValue;
      $specimenImage_height_value = $imageNode->getAttributeNode('height')->nodeValue;

      $specimenArray[$imageCount]['srcX'] = $specimenImage_srcX_value;
      $specimenArray[$imageCount]['srcY'] = $specimenImage_srcY_value;
      $specimenArray[$imageCount]['dstX'] = $specimenImage_dstX_value;
      $specimenArray[$imageCount]['dstY'] = $specimenImage_dstY_value;
      $specimenArray[$imageCount]['width'] = $specimenImage_width_value;
      $specimenArray[$imageCount]['height'] = $specimenImage_height_value;

      $dataArray['reply'] .= ' | srcX= '.$specimenImage_srcX_value;
      $dataArray['reply'] .= ' | srcY= '.$specimenImage_srcX_value;
      $dataArray['reply'] .= ' | dstX= '.$specimenImage_dstX_value;
      $dataArray['reply'] .= ' | dstY= '.$specimenImage_dstY_value;
      $dataArray['reply'] .= ' | width= '.$specimenImage_width_value;
      $dataArray['reply'] .= ' | height= '.$specimenImage_height_value;

      $keyNodeX = $compositeNode->getElementsByTagName('Key')->item(0)->getAttribute('x');
      $keyNodeY = $compositeNode->getElementsByTagName("Key")->item(0)->getAttribute('y');

      $specimenArray[$imageCount]['keyX'] = $keyNodeX;
      $specimenArray[$imageCount]['keyY'] = $keyNodeY;

      $dataArray['reply'] .= " | Key Frame0 X= ".$keyNodeX;
      $dataArray['reply'] .= " | Key Frame0 Y= ".$keyNodeY;

      $dataArray['reply'] .= '</br>';

      $imageCount++;
    }

    $countSpecimenImage = 18;
    $specimenResult = imagecreatetruecolor(600, 600);

    while($countSpecimenImage < count($specimenArray)){
      $image_p = imagecreatetruecolor($specimenArray[$countSpecimenImage]['width'], $specimenArray[$countSpecimenImage]['height']);
      $red = imagecolorallocate($specimenResult, 0, 0, 0);
      imagecolortransparent($image_p, $red);

      $image = imagecreatefrompng($filename);
      imagecopyresampled($image_p, $image, 0, 0, $specimenArray[$countSpecimenImage]['srcX'], $specimenArray[$countSpecimenImage]['srcY'], $specimenArray[$countSpecimenImage]['width'], $specimenArray[$countSpecimenImage]['height'], $specimenArray[$countSpecimenImage]['width'], $specimenArray[$countSpecimenImage]['height']);

      imagecopymerge($specimenResult, $image_p, -$specimenArray[$countSpecimenImage]['keyX'], -$specimenArray[$countSpecimenImage]['keyY'], 0, 0, $specimenArray[$countSpecimenImage]['width'], $specimenArray[$countSpecimenImage]['height'], 100);

      $countSpecimenImage++;
     }

    ob_start();
    imagepng($specimenResult);
    $imageSample = ob_get_contents();
    ob_end_clean();

    $dataArray['reply'] .= '<img src="data:image/png;base64,'.base64_encode($imageSample).'" /><br/>';

    echo $dataArray['reply'];
  }
?>
