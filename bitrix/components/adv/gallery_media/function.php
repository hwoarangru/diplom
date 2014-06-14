<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if (!function_exists('ADV_ResizeImageGet')) {function ADV_ResizeImageGet($strFilePath, $arParams) {
	
	$strFilePath = $_SERVER['DOCUMENT_ROOT'] . $strFilePath;
	
	if (!file_exists($strFilePath))
	{
		return false;
	}

    $arParams['width'] = intval($arParams['width']);
    $arParams['height'] = intval($arParams['height']);

	$arCurSize = getimagesize($strFilePath);
	$arCurSize['width'] = $arCurSize[0];
	$arCurSize['height'] = $arCurSize[1];

    // Resizing if needed
    if($arCurSize['width'] > $arParams['width'] || $arCurSize['height'] > $arParams['height'])
    {

	    if($arCurSize[2]==2)
	    {
	    	$ext = "jpg";
	        $sourceImage = imagecreatefromjpeg($strFilePath);
	    }
	    elseif($arCurSize[2]==1)
	    {
	    	$ext = "gif";
	        $sourceImage = imagecreatefromgif($strFilePath);
	    }
	    elseif($arCurSize[2]==3)
	    {
	    	$ext = "png";
	        $sourceImage = imagecreatefrompng($strFilePath);
	    }
	     
		$width = Max($arCurSize['width'], $arCurSize['height']);
		$height = Min($arCurSize['width'], $arCurSize['height']);

		$iResizeCoeff = Max($arParams["width"] / $width, $arParams["height"] / $height);

		if ($iResizeCoeff > 0)
		{
			$arSourceSize["x"] = ((($arCurSize['width'] * $iResizeCoeff - $arParams["width"]) / 2) / $iResizeCoeff);
			$arSourceSize["y"] = ((($arCurSize['height'] * $iResizeCoeff - $arParams["height"]) / 2) / $iResizeCoeff);
			$arSourceSize["width"] = $arParams["width"] / $iResizeCoeff;
			$arSourceSize["height"] = $arParams["height"] / $iResizeCoeff;
		}
		
		$newImage = imagecreatetruecolor($arParams['width'], $arParams['height']);
		imagecopyresampled($newImage, $sourceImage,
							0, 0, $arSourceSize["x"], $arSourceSize["y"],
							$arParams["width"], $arParams["height"], $arSourceSize["width"], $arSourceSize["height"]);
							
	    $rand = md5(serialize(array($strFilePath, $arParams)));
	    $strFilePath = sprintf("%6\$s/upload/photo/%1\$s_%2\$s/%4\$s.%5\$s"
	    	, $arParams['width']
	    	, $arParams['height']
	    	, substr($rand, 0, 3)
	    	, substr($rand, 0, 8)
	    	, $ext
	    	, $_SERVER['DOCUMENT_ROOT']
	    );
	    CheckDirPath(dirname($strFilePath));
							
		if($arCurSize[2] == IMAGETYPE_JPEG)
		{
			if($arParams["compression"] > 0)
				if (!imagejpeg($newImage, $strFilePath, $arParams["compression"]))
					return false;
//				if (imagejpeg($newImage, $strFilePath, $arParams["compression"]))
//					die($strFilePath);
//				else 
//				{
//					var_dump($newImage);
//					var_dump($strFilePath);
//					die("XZ");
//				}
			else
				 if (!imagejpeg($newImage, $strFilePath))
				 	return false;
		}
		elseif($image_type == IMAGETYPE_GIF && function_exists("imagegif"))
		{
			imagegif($newImage, $strFilePath);
		}
		else
		{
			imagepng($newImage, $strFilePath);
		}
		
		imagedestroy($newImage);
		imagedestroy($sourceImage);
		
    }
    
    $strFilePath = str_replace($_SERVER['DOCUMENT_ROOT'], "", $strFilePath);

	return $strFilePath;
	
}}
?>