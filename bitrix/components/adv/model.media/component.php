<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?

include $_SERVER['DOCUMENT_ROOT'] . $this->GetPath() . "/function.php";

$arParams["CACHE_TIME"] = isset($arParams["CACHE_TIME"])?intval($arParams["CACHE_TIME"]):86400;
$arParams['MODEL_ID'] = intval($arParams['MODEL_ID']);
$arParams["PRESENTATION_CODE"] = trim($arParams["PRESENTATION_CODE"]);
$arParams["IBLOCK_FEATURE_TYPE"] = trim($arParams["IBLOCK_FEATURE_TYPE"]);
$arParams["IBLOCK_PRESENTATION_CODE"] = trim($arParams["IBLOCK_PRESENTATION_CODE"]);
$arParams["IBLOCK_MODEL_CODE"] = trim($arParams["IBLOCK_MODEL_CODE"]);
$arParams["IBLOCK_PHOTO_CODE"] = trim($arParams["IBLOCK_PHOTO_CODE"]);
$arParams["IBLOCK_VIDEO_CODE"] = trim($arParams["IBLOCK_VIDEO_CODE"]);

//$arParams['WP_SIZE'] = array(
//	  array(800, 600)
//	, array(1024, 768)
//	, array(1200, 600)
//	, array(1920, 1200)
//);

if (!CModule::IncludeModule("iblock"))
{
	return false;
}

//new dBug($arParams, false, false);
//new dBug($arResult);

$arResult['RANGE_SECTION'] = $arParams['RANGE_SECTION'];

$CACHE_ID = md5(serialize(array(
	$arParams,
	"media" //соль
)));
$objPHPCache = new CPHPCache;

if($objPHPCache->StartDataCache($arParams["CACHE_TIME"], $CACHE_ID))
{
	
	/**
	 * Получим ИБ "Модели"
	 
	$arOrder = array();
	$arFilter = array("CODE" => $arParams['IBLOCK_MODEL_CODE'], 'TYPE' => $arParams["IBLOCK_FEATURE_TYPE"]);
	$rsIBlock = CIBlock::GetList($arOrder, $arFilter);
	if ($rsIBlock && $arIBlock = $rsIBlock->Fetch()) 
	{
		$arResult['IBLOCK_MODEL'] = $arIBlock;
	}
	else 
	{
		ShowError("Не удалось получить ИБ \"Модели\"");
		$this->AbortResultCache();
		return false;
	}*/
	
	/**
	 * Получим ИБ "Фотогалерея"
	 
	$arOrder = array();
	$arFilter = array("CODE" => $arParams['IBLOCK_PHOTO_CODE'], 'TYPE' => $arParams["IBLOCK_FEATURE_TYPE"]);
	$rsIBlock = CIBlock::GetList($arOrder, $arFilter);
	if ($rsIBlock && $arIBlock = $rsIBlock->Fetch()) 
	{
		$arResult['IBLOCK_PHOTO'] = $arIBlock;
	}
	else 
	{
		ShowError("Не удалось получить ИБ \"Фотогалерея\"");
		$this->AbortResultCache();
		return false;
	}*/
	
	/**
	 * Получим ИБ "Видео"
	 
	$arOrder = array();
	$arFilter = array("CODE" => $arParams['IBLOCK_VIDEO_CODE'], 'TYPE' => $arParams["IBLOCK_FEATURE_TYPE"]);
	$rsIBlock = CIBlock::GetList($arOrder, $arFilter);
	if ($rsIBlock && $arIBlock = $rsIBlock->Fetch()) 
	{
		$arResult['IBLOCK_VIDEO'] = $arIBlock;
	}
	else 
	{
		ShowError("Не удалось получить ИБ \"Видео\"");
		$this->AbortResultCache();
		return false;
	}*/
	
	/**
	 * Получим модель
	 */
	$arOrder = array("SORT" => "ASC", "NAME" => "ASC");
	$arFilter = array("ID" => $arParams['MODEL_ID'], 'IBLOCK_CODE' => $arParams['IBLOCK_MODEL_CODE']);//$arResult['IBLOCK_MODEL']['ID']);
	$rsIBlockElementList = CIBlockElement::GetList($arOrder, $arFilter);
	if ($rsIBlockElementList && $objIBlockElement = $rsIBlockElementList->GetNextElement()) 
	{
		$arIBlockElement = array
		(
			  'FIELDS' => $objIBlockElement->GetFields()
			, 'PROPS' => $objIBlockElement->GetProperties()
		);
		$arResult['MODEL'] = $arIBlockElement;
	}
	else
	{
		ShowError("Не удалось получить модель");
		$this->AbortResultCache();
		return false;
	}
	
	

	/**
	 * Получим фотографии
	 */
	if ($arResult['MODEL']['PROPS']['GALLERY']['VALUE'])
	{
		$resSec = CIBlockSection::GetList(array(),array("ID" => $arResult['MODEL']['PROPS']['GALLERY']['VALUE']),false,array("PICTURE"));
		while ($arSec = $resSec->GetNext()) {
			$arResult['MODEL']['PROPS']['GALLERY']['GALLERY_PIC'] = CFile::GetFileArray($arSec["PICTURE"]);
		}
		
		$arOrder = array("SORT" => "ASC", "NAME" => "ASC");
		$arFilter = array(
			  "IBLOCK_CODE" => $arParams["IBLOCK_PHOTO_CODE"]//$arResult['IBLOCK_PHOTO']['ID']
			, "SECTION_ID" => $arResult['MODEL']['PROPS']['GALLERY']['VALUE']
			, "ACTIVE" => "Y"
		);
		$rsIBlockElementList = CIBlockElement::GetList($arOrder, $arFilter);
		while ($rsIBlockElementList && $objIBlockElement = $rsIBlockElementList->GetNextElement()) 
		{
			$arIBlockElement = array
			(
				  'FIELDS' => $objIBlockElement->GetFields()
				, 'PROPS' => $objIBlockElement->GetProperties()
			);
			if ($arIBlockElement['FIELDS']['PREVIEW_PICTURE'] && $arIBlockElement['FIELDS']['DETAIL_PICTURE'])
			{
				$arIBlockElement['PREVIEW_PICTURE'] = CFile::GetFileArray($arIBlockElement['FIELDS']['PREVIEW_PICTURE']);
				$arIBlockElement['PREVIEW_PICTURE']['PATH'] = CFile::GetPath($arIBlockElement['FIELDS']['PREVIEW_PICTURE']);
				$arIBlockElement['PREVIEW_PICTURE']['RES'] =  ADV_ResizeImageGet($arIBlockElement['PREVIEW_PICTURE']['PATH'], array('width' => 110, 'height' => 62, 'compression' => 100));
				$arIBlockElement['DETAIL_PICTURE'] = CFile::GetFileArray($arIBlockElement['FIELDS']['DETAIL_PICTURE']);
//				$arIBlockElement['DETAIL_PICTURE']['PATH'] = ADV_ResizeImageGet(CFile::GetPath($arIBlockElement['FIELDS']['DETAIL_PICTURE']), array('width' => 612, 'height' => 356, 'compression' => 100));
				$r = CFile::ResizeImageGet($arIBlockElement['FIELDS']['DETAIL_PICTURE'], array('width' => 612, 'height' => 356), BX_RESIZE_IMAGE_EXACT);
				$arIBlockElement['DETAIL_PICTURE']['PATH'] = $r['src'];
				
				if ($arIBlockElement['PROPS']['WP_1600x1200']['VALUE'])
				{
					$arIBlockElement['WP_1600x1200']['PATH'] = CFile::GetPath($arIBlockElement['PROPS']['WP_1600x1200']['VALUE']);
				}
				
				if ($arIBlockElement['PROPS']['WP_1920x1200']['VALUE'])
				{
					$arIBlockElement['WP_1920x1200']['PATH'] = CFile::GetPath($arIBlockElement['PROPS']['WP_1920x1200']['VALUE']);
				}
	
				$arResult['PHOTO'][] = $arIBlockElement;
			}
		}
	}
	
	/**
	 * Получим видеофайлы
	 */
	$arOrder = array("SORT" => "ASC", "NAME" => "ASC");
	$arFilter = array(
		  "IBLOCK_CODE" => $arParams["IBLOCK_VIDEO_CODE"]
		, "PROPERTY_MODEL_ID" => $arParams['MODEL_ID']
		, "ACTIVE" => "Y"
	);
	$rsIBlockElementList = CIBlockElement::GetList($arOrder, $arFilter);
	while ($rsIBlockElementList && $objIBlockElement = $rsIBlockElementList->GetNextElement()) 
	{
		$arIBlockElement = array
		(
			  'FIELDS' => $objIBlockElement->GetFields()
			, 'PROPS' => $objIBlockElement->GetProperties()
		);
		
//		$arIBlockElement['PREVIEW_PICTURE'] = CFile::GetFileArray($arIBlockElement['FIELDS']['PREVIEW_PICTURE']);
		$arIBlockElement['PREVIEW_PICTURE']['PATH'] = ADV_ResizeImageGet(CFile::GetPath($arIBlockElement['FIELDS']['PREVIEW_PICTURE']), array('width' => 110, 'height' => 62, 'compression' => 100));
		
		$arIBlockElement['FILE']['FLV'] = CFile::GetFileArray($arIBlockElement['PROPS']['FILE_FLV_ID']['VALUE']);
		$arIBlockElement['FILE']['FLV']['PATH'] = CFile::GetPath($arIBlockElement['PROPS']['FILE_FLV_ID']['VALUE']);
		if ($arIBlockElement['PROPS']['FILE_WMV_ID']['VALUE'])
		{
			$arIBlockElement['FILE']['WMV'] = CFile::GetFileArray($arIBlockElement['PROPS']['FILE_WMV_ID']['VALUE']);
			$arIBlockElement['FILE']['WMV']['PATH'] = CFile::GetPath($arIBlockElement['PROPS']['FILE_WMV_ID']['VALUE']);
		}
		if ($arIBlockElement['PROPS']['FILE_IPOD_ID']['VALUE'])
		{
			$arIBlockElement['FILE']['IPOD'] = CFile::GetFileArray($arIBlockElement['PROPS']['FILE_IPOD_ID']['VALUE']);
			$arIBlockElement['FILE']['IPOD']['PATH'] = CFile::GetPath($arIBlockElement['PROPS']['FILE_IPOD_ID']['VALUE']);
		}
		if ($arIBlockElement['PROPS']['FILE_MOV_ID']['VALUE'])
		{
			$arIBlockElement['FILE']['MOV'] = CFile::GetFileArray($arIBlockElement['PROPS']['FILE_MOV_ID']['VALUE']);
			$arIBlockElement['FILE']['MOV']['PATH'] = CFile::GetPath($arIBlockElement['PROPS']['FILE_MOV_ID']['VALUE']);
		}

		$arResult['VIDEO'][] = $arIBlockElement;
	}
	$objPHPCache->EndDataCache(Array(
		"arResult" => $arResult
	));
}
else
{
	$arVars = $objPHPCache->GetVars();
	$arResult = $arVars["arResult"];
}


$ar = array();
if (count($arResult['PHOTO']))
{
	$ar[] = 'изображения';
}
if (count($arResult['VIDEO']))
{
	$ar[] = 'видео';
}
$str = implode(" и ", $ar);
$str = ToUpper($str[0]) . substr($str, 1);
	
$APPLICATION->SetTitle($arResult['MODEL']['FIELDS']['NAME'] . ': ' . $str);
	$this->IncludeComponentTemplate();
?>