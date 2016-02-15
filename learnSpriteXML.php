<?php

/*

	learnSpriteXML for Mutants Genetic
	v0.1 -> v1.5 by Urthawen

	-This script can read any XML File Sprite for any Mutants;
	-Need a connection to a DB (Or change this directly on the source code);

*/


	echo "//////////////////////////////////<br /><strong>LearnSpiteXML</strong><br />VERSION : 1.5<br/>//////////////////////////////////<br /><br />=============================================<br/>";

	//Include XML file with DOM
	$spriteXML = new DOMDocument();
	$spriteXML->load('specimen_A_01.xml');

	//Variables globals
	$numberComposites = 0; //Number of composites of the current sprite

	//Take ID of Mutant & Take name of his bitmap
	echo "<h3>Mutant Information</h3>";
	$idMutant= $spriteXML->documentElement->getAttributeNode('id')->nodeValue;
	$bitmapMutant= $spriteXML->documentElement->getAttributeNode('bitmap')->nodeValue;

	echo "<strong>Id_Mutant = </strong>".$idMutant."<br /><strong>Bitmap_Mutant = </strong>".$bitmapMutant."<br /><br />";

	//Check if bitmap exist
	echo "<h5>Checking Bitmap... ";
	if(file_exists("./".$bitmapMutant))
	{
		echo " File found.</h5>";
		//If the bitmap was find, load it. Bitch.
		//....Maybe later ! :-)
	}
	else
	{
		echo " Error : File not found.</h5>";
	}

	$compositeNode = $spriteXML->documentElement;
	//Affichage des fils de $test
	foreach($compositeNode->childNodes as $node)
	{
		if($node->nodeName=="Composite")
		{
			$numberComposites++;
		}
	}

	//Count nodes
	echo "<h5>Count composites... ".$numberComposites." composites found</h5>=============================================<br /><br />";


	// ALLER ON VA TRAVAILLER MY FRIEND

	$sprite = $spriteXML->documentElement;


	foreach($sprite->childNodes as $node)
	{
		if($node->nodeType == XML_ELEMENT_NODE && $node->tagName=="Composite")
		{
			echo $node->tagName;
			foreach($node->childNodes as $subNode)
			{
				if($subNode->nodeType == XML_ELEMENT_NODE)
				{
					if($subNode->tagName=="Key" && $subNode->getAttribute("frame")=="0")
					{
						$key_attribute_x = $subNode->getAttribute("x");
						$key_attribute_y = $subNode->getAttribute("y");
						$key_attribute_angle = 0;
						$key_attribute_scalex = 0;
						$key_attribute_scaley = 0;
						$key_attribute_alpha = 0;

						echo "--".$subNode->tagName;
						echo " with key_attribute_x = " .$key_attribute_x;
						echo " AND key_attribute_y = " .$key_attribute_y;

						if($subNode->hasAttribute("angle"))
						{
							$key_attribute_angle = $subNode->getAttribute("angle");
							echo " AND key_attribute_angle = " .$key_attribute_angle;
						}

						if($subNode->hasAttribute("scaleX"))
						{
							$key_attribute_scalex = $subNode->getAttribute("scaleX");
							echo " AND key_attribute_scalex = " .$key_attribute_scalex;
						}

						if($subNode->hasAttribute("scaleY"))
						{
							$key_attribute_scaley = $subNode->getAttribute("scaleY");
							echo " AND key_attribute_scaley = " .$key_attribute_scaley;
						}
						if($subNode->hasAttribute("alpha"))
						{
							$key_attribute_alpha = $subNode->getAttribute("alpha");
							echo " AND key_attribute_alpha = " .$key_attribute_alpha;
						}


					}
					echo "<br />";
					foreach($subNode->childNodes as $megaSubNode)
					{

						if($megaSubNode->nodeType == XML_ELEMENT_NODE)
						{
							echo "-----".$megaSubNode->tagName."<br />";
							if($megaSubNode->tagName=="Image")
							{
								$image_attribute_srcx = $megaSubNode->getAttribute("srcX");
								$image_attribute_srcy = $megaSubNode->getAttribute("srcY");
								$image_attribute_dstx = $megaSubNode->getAttribute("dstX");
								$image_attribute_dsty = $megaSubNode->getAttribute("dstY");
								$image_attribute_width = $megaSubNode->getAttribute("width");
								$image_attribute_height = $megaSubNode->getAttribute("height");
								$image_attribute_torsionA = 0;
								$image_attribute_torsionB = 0;
								$image_attribute_torsionC = 0;
								$image_attribute_torsionD = 0;

								echo "with array(".$image_attribute_srcx.",".
								$image_attribute_srcy.",".
								$image_attribute_dstx.",".
								$image_attribute_dsty.",".
								$image_attribute_width.",".
								$image_attribute_height;

								if($megaSubNode->hasAttribute("a"))
								{
									$image_attribute_torsionA = $megaSubNode->getAttribute("a");
									echo ",".$image_attribute_torsionA;
								}
								if($megaSubNode->hasAttribute("b"))
								{
									$image_attribute_torsionB = $megaSubNode->getAttribute("b");
									echo ",".$image_attribute_torsionB;
								}
								if($megaSubNode->hasAttribute("c"))
								{
									$image_attribute_torsionC = $megaSubNode->getAttribute("c");
									echo ",".$image_attribute_torsionC;
								}
								if($megaSubNode->hasAttribute("d"))
								{
									$image_attribute_torsionD = $megaSubNode->getAttribute("d");
									echo ",".$image_attribute_torsionD;

								}
								echo ")<br />";
							}
							if($megaSubNode->tagName=="Frame")
							{
								foreach($megaSubNode->childNodes as $ultraSubNode)
								{
									if($ultraSubNode->nodeType == XML_ELEMENT_NODE)
									{
									echo "---------".$ultraSubNode->tagName." ";
									$image_attribute_srcx = $ultraSubNode->getAttribute("srcX");
									$image_attribute_srcy = $ultraSubNode->getAttribute("srcY");
									$image_attribute_dstx = $ultraSubNode->getAttribute("dstX");
									$image_attribute_dsty = $ultraSubNode->getAttribute("dstY");
									$image_attribute_width = $ultraSubNode->getAttribute("width");
									$image_attribute_height = $ultraSubNode->getAttribute("height");
									$image_attribute_torsionA = 0;
									$image_attribute_torsionB = 0;
									$image_attribute_torsionC = 0;
									$image_attribute_torsionD = 0;

									echo "with array(".$image_attribute_srcx.",".
									$image_attribute_srcy.",".
									$image_attribute_dstx.",".
									$image_attribute_dsty.",".
									$image_attribute_width.",".
									$image_attribute_height;

									if($ultraSubNode->hasAttribute("a"))
									{
										$image_attribute_torsionA = $ultraSubNode->getAttribute("a");
										echo ",".$image_attribute_torsionA;
									}
									if($ultraSubNode->hasAttribute("b"))
									{
										$image_attribute_torsionB = $ultraSubNode->getAttribute("b");
										echo ",".$image_attribute_torsionB;
									}
									if($ultraSubNode->hasAttribute("c"))
									{
										$image_attribute_torsionC = $ultraSubNode->getAttribute("c");
										echo ",".$image_attribute_torsionC;
									}
									if($ultraSubNode->hasAttribute("d"))
									{
										$image_attribute_torsionD = $ultraSubNode->getAttribute("d");
										echo ",".$image_attribute_torsionD;

									}
									echo ")<br />";
									}
								}
							}
							if($megaSubNode->tagName=="Composite")
							{
								foreach($megaSubNode->childNodes as $ultraSubNode)
								{
									if($ultraSubNode->nodeType == XML_ELEMENT_NODE)
									{
										echo "---------".$ultraSubNode->tagName."<br />";
										if($ultraSubNode->tagName == "Sprite")
										{
											foreach($ultraSubNode->childNodes as $lastSubNode)
											{
												if($lastSubNode->nodeType == XML_ELEMENT_NODE)
												{
													echo "-------------".$lastSubNode->tagName." ";
													if($lastSubNode->tagName=="Image")
													{
														$image_attribute_srcx = $lastSubNode->getAttribute("srcX");
														$image_attribute_srcy = $lastSubNode->getAttribute("srcY");
														$image_attribute_dstx = $lastSubNode->getAttribute("dstX");
														$image_attribute_dsty = $lastSubNode->getAttribute("dstY");
														$image_attribute_width = $lastSubNode->getAttribute("width");
														$image_attribute_height = $lastSubNode->getAttribute("height");
														$image_attribute_torsionA = 0;
														$image_attribute_torsionB = 0;
														$image_attribute_torsionC = 0;
														$image_attribute_torsionD = 0;

														echo "with array(".$image_attribute_srcx.",".
														$image_attribute_srcy.",".
														$image_attribute_dstx.",".
														$image_attribute_dsty.",".
														$image_attribute_width.",".
														$image_attribute_height;

														if($lastSubNode->hasAttribute("a"))
														{
															$image_attribute_torsionA = $lastSubNode->getAttribute("a");
															echo ",".$image_attribute_torsionA;
														}
														if($lastSubNode->hasAttribute("b"))
														{
															$image_attribute_torsionB = $lastSubNode->getAttribute("b");
															echo ",".$image_attribute_torsionB;
														}
														if($lastSubNode->hasAttribute("c"))
														{
															$image_attribute_torsionC = $lastSubNode->getAttribute("c");
															echo ",".$image_attribute_torsionC;
														}
														if($lastSubNode->hasAttribute("d"))
														{
															$image_attribute_torsionD = $lastSubNode->getAttribute("d");
															echo ",".$image_attribute_torsionD;

														}
														echo ")<br />";
													}
													else if($lastSubNode->tagName=="Frame")
													{	echo "<br />";
														foreach($lastSubNode->childNodes as $lastSubNode_Frame)
														{
															if($lastSubNode_Frame->nodeType == XML_ELEMENT_NODE)
															{
																echo "-----------------".$lastSubNode_Frame->tagName."<br />";
																if($lastSubNode_Frame->tagName == "Image")
																{
																	$image_attribute_srcx = $lastSubNode_Frame->getAttribute("srcX");
																	$image_attribute_srcy = $lastSubNode_Frame->getAttribute("srcY");
																	$image_attribute_dstx = $lastSubNode_Frame->getAttribute("dstX");
																	$image_attribute_dsty = $lastSubNode_Frame->getAttribute("dstY");
																	$image_attribute_width = $lastSubNode_Frame->getAttribute("width");
																	$image_attribute_height = $lastSubNode_Frame->getAttribute("height");
																	$image_attribute_torsionA = 0;
																	$image_attribute_torsionB = 0;
																	$image_attribute_torsionC = 0;
																	$image_attribute_torsionD = 0;

																	echo "with array(".$image_attribute_srcx.",".
																	$image_attribute_srcy.",".
																	$image_attribute_dstx.",".
																	$image_attribute_dsty.",".
																	$image_attribute_width.",".
																	$image_attribute_height;

																	if($lastSubNode_Frame->hasAttribute("a"))
																	{
																		$image_attribute_torsionA = $lastSubNode_Frame->getAttribute("a");
																		echo ",".$image_attribute_torsionA;
																	}
																	if($lastSubNode_Frame->hasAttribute("b"))
																	{
																		$image_attribute_torsionB = $lastSubNode_Frame->getAttribute("b");
																		echo ",".$image_attribute_torsionB;
																	}
																	if($lastSubNode_Frame->hasAttribute("c"))
																	{
																		$image_attribute_torsionC = $lastSubNode_Frame->getAttribute("c");
																		echo ",".$image_attribute_torsionC;
																	}
																	if($lastSubNode_Frame->hasAttribute("d"))
																	{
																		$image_attribute_torsionD = $lastSubNode_Frame->getAttribute("d");
																		echo ",".$image_attribute_torsionD;

																	}
																	echo ")<br />";
																}
															}
														}
													}
												}

											}
										}
										else if($ultraSubNode->tagName == "Key" && $ultraSubNode->getAttribute("frame")=="0")
										{
											$key_attribute_x = $ultraSubNode->getAttribute("x");
											$key_attribute_y = $ultraSubNode->getAttribute("y");
											$key_attribute_angle = 0;
											$key_attribute_scalex = 0;
											$key_attribute_scaley = 0;
											$key_attribute_alpha = 0;

											echo " with key_attribute_x = " .$key_attribute_x;
											echo " AND key_attribute_y = " .$key_attribute_y;

											if($ultraSubNode->hasAttribute("angle"))
											{
												$key_attribute_angle = $ultraSubNode->getAttribute("angle");
												echo " AND key_attribute_angle = " .$key_attribute_angle;
											}

											if($ultraSubNode->hasAttribute("scaleX"))
											{
												$key_attribute_scalex = $ultraSubNode->getAttribute("scaleX");
												echo " AND key_attribute_scalex = " .$key_attribute_scalex;
											}

											if($ultraSubNode->hasAttribute("scaleY"))
											{
												$key_attribute_scaley = $ultraSubNode->getAttribute("scaleY");
												echo " AND key_attribute_scaley = " .$key_attribute_scaley;
											}
											if($ultraSubNode->hasAttribute("alpha"))
											{
												$key_attribute_alpha = $ultraSubNode->getAttribute("alpha");
												echo " AND key_attribute_alpha = " .$key_attribute_alpha;
											}
											echo "<br />";
										}

									}
								}
							}
						}
					}
				}
			}
		}
	}

	echo "=============================================<br/><br/><strong>LearnSpiteXML</strong> FINISH TO LEARN THIS XML FILE<br/><br/>=============================================";

?>
