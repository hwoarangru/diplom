<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?

$arParams["CACHE_TIME"] = isset($arParams["CACHE_TIME"])?intval($arParams["CACHE_TIME"]):86400;
$arParams["FEATURE_SECTION"] = (array)($arParams["FEATURE_SECTION"]);
$arParams["FEATURE_IBLOCK"] = (array)($arParams["FEATURE_IBLOCK"]);
$arParams["FEATURE_CODE"] = trim($arParams["FEATURE_CODE"]);
$arParams["IBLOCK_PRESENTATION_CODE"] = trim($arParams["IBLOCK_PRESENTATION_CODE"]);

//print_r($arParams);

if (!CModule::IncludeModule("iblock"))
{
	return false;
}

$arResult['RANGE_SECTION'] = $arParams['RANGE_SECTION'];

$CACHE_ID = md5(serialize(array(
	$arParams
)));
$objPHPCache = new CPHPCache;

if($objPHPCache->StartDataCache($arParams["CACHE_TIME"], $CACHE_ID))
{
	
	/**
	 * По коду "фичи" получим саму "фичу"
	 */
	$arOrder = array("SORT" => "ASC", "NAME" => "ASC");
	$arFilter = array(
		  "IBLOCK_ID" => $arParams["FEATURE_IBLOCK"]['ID']
		, "CODE" => $arParams["FEATURE_CODE"]
		, "SECTION_ID" => $arParams["FEATURE_SECTION"]["ID"]
		, "ACTIVE" => "Y"
	);
	$rsIBlockElementList = CIBlockElement::GetList($arOrder, $arFilter);
	if ($rsIBlockElementList && $objIBlockElement = $rsIBlockElementList->GetNextElement()) 
	{
		$arIBlockElement = array
		(
			  'FIELDS' => $objIBlockElement->GetFields()
			, 'PROPS' => $objIBlockElement->GetProperties()
		);
		$arResult['FEATURE'] = $arIBlockElement;
	}
	else 
	{
		ShowError("Элемент не найден");
		$this->AbortResultCache();
		return false;
	}
	
	$arOrder = array("SORT" => "ASC", "NAME" => "ASC");
	$arFilter = array(
		  "IBLOCK_CODE" => $arParams['IBLOCK_PRESENTATION_CODE']
		, "PROPERTY_LINK_ELEMENT" => $arResult['FEATURE']['FIELDS']['ID']
		, "ACTIVE" => "Y"
	);
//	print_r($arFilter);
	$rsIBlockElementList = CIBlockElement::GetList($arOrder, $arFilter);
	if ($rsIBlockElementList && $objIBlockElement = $rsIBlockElementList->GetNextElement()) 
	{
		$arIBlockElement = array
		(
			  'FIELDS' => $objIBlockElement->GetFields()
			, 'PROPS' => $objIBlockElement->GetProperties()
		);
		$arResult['ELEMENT'] = $arIBlockElement;
	}
	else 
	{
		ShowError("Презентация не найдена");
		$this->AbortResultCache();
		return false;
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


$this->IncludeComponentTemplate();

$APPLICATION->SetPageProperty("pagetitle", $arResult['RANGE_SECTION']['NAME']." : ".$arResult['ELEMENT']['FIELDS']['NAME']);
$APPLICATION->SetPageProperty("WITHOUT_BOTTOM_MENU", true);



//new dBug($arParams);
//new dBug($arResult);
?>