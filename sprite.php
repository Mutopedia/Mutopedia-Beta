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

    $specimenCharacterImage = imagecreatefrompng($filename);

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
      $keyNodeAngle = $compositeNode->getElementsByTagName("Key")->item(0)->getAttribute('angle');

      $specimenArray[$imageCount]['keyX'] = $keyNodeX;
      $specimenArray[$imageCount]['keyY'] = $keyNodeY;
      $specimenArray[$imageCount]['keyAngle'] = $keyNodeAngle;

      $dataArray['reply'] .= " | Key Frame0 X= ".$keyNodeX;
      $dataArray['reply'] .= " | Key Frame0 Y= ".$keyNodeY;
      $dataArray['reply'] .= " | Key Frame0 Angle= ".$keyNodeAngle;

      $dataArray['reply'] .= '</br>';

      $image_p = imagecreatetruecolor($specimenArray[$imageCount]['width'], $specimenArray[$imageCount]['height']);
      $alpha_channel = imagecolorallocatealpha($image_p, 0, 0, 0, 127);
      imagecolortransparent($image_p, $alpha_channel);
      imagefill($image_p, 0, 0, $alpha_channel);
      imagesavealpha($image_p, true);

      imagecopyresampled($image_p, $specimenCharacterImage, 0, 0, $specimenArray[$imageCount]['srcX'], $specimenArray[$imageCount]['srcY'], $specimenArray[$imageCount]['width'], $specimenArray[$imageCount]['height'], $specimenArray[$imageCount]['width'], $specimenArray[$imageCount]['height']);
      /*$image_p = imagerotate($image_p, 30, $alpha_channel);*/
      ob_start();
      imagepng($image_p);
      $imageSample = ob_get_contents();
      ob_end_clean();

      $dataArray['reply'] .= '<img src="data:image/png;base64,'.base64_encode($imageSample).'" /><br/>';

      $imageCount++;
    }

    $countSpecimenImage = 0;
    $specimenResult = imagecreatetruecolor(250, 400);
    $alpha_channel = imagecolorallocatealpha($specimenResult, 0, 0, 0, 127);
    imagecolortransparent($specimenResult, $alpha_channel);
    imagefill($specimenResult, 0, 0, $alpha_channel);
    imagesavealpha($specimenResult, true);

    while($countSpecimenImage < count($specimenArray)){
      $image_p = imagecreatetruecolor($specimenArray[$countSpecimenImage]['width'], $specimenArray[$countSpecimenImage]['height']);
      $alpha_channel = imagecolorallocatealpha($image_p, 0, 0, 0, 127);
      imagecolortransparent($image_p, $alpha_channel);
      imagefill($image_p, 0, 0, $alpha_channel);

      imagecopy($image_p, $specimenCharacterImage, 0, 0, $specimenArray[$countSpecimenImage]['srcX'], $specimenArray[$countSpecimenImage]['srcY'], $specimenArray[$countSpecimenImage]['width'], $specimenArray[$countSpecimenImage]['height']);

      if(!empty($specimenArray[$countSpecimenImage]['keyAngle'])){
        $image_p = imagerotate($image_p, -$specimenArray[$countSpecimenImage]['keyAngle'], $alpha_channel);
      }

      imagecopy($specimenResult, $image_p, $specimenArray[$countSpecimenImage]['dstX'], $specimenArray[$countSpecimenImage]['dstY'], 0, 0, imagesx($image_p), imagesy($image_p));

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
