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

$arResult['RANGE_SECTION'] = $arParams['~RANGE_SECTION'];


$CACHE_ID = md5(serialize(array(
	$arParams,
	"view360" //соль
)));
$objPHPCache = new CPHPCache;

if($objPHPCache->StartDataCache($arParams["CACHE_TIME"], $CACHE_ID))
{
	/**
	 * Получим эл-т ИБ "Обзор 360"
	 */
	$arOrder = array();
	$arFilter = array(
		  "IBLOCK_CODE" => $arParams["IBLOCK_VIEW360_CODE"]
		, "PROPERTY_MODEL_SECTION_ID" => $arParams["FEATURE_SECTION"]["ID"]
		, "ACTIVE" => "Y"
	);

	$rsIBlockElementList = CIBlockElement::GetList($arOrder, $arFilter,false,false,array("DETAIL_TEXT"));
	if ($rsIBlockElementList && $objIBlockElement = $rsIBlockElementList->GetNext())
	{
		$arIBlockElement = array
		(
			  'FIELDS' => $objIBlockElement//$objIBlockElement->GetFields()
			//, 'PROPS' => $objIBlockElement->GetProperties()
		);
		$arResult['ELEMENT'] = $arIBlockElement;
	}
	else 
	{
		ShowError("Элемент не найден");
		$this->AbortResultCache();
		return false;
	}
	$objPHPCache->EndDataCache(Array(
    	"arResult" => $arResult
    ));

	$this->IncludeComponentTemplate();
}
else
{
	$arVars = $objPHPCache->GetVars();
	$arResult = $arVars["arResult"];
}
$this->IncludeComponentTemplate();

$APPLICATION->SetTitle($arResult['RANGE_SECTION']['NAME'] . " : Обзор 360");
$APPLICATION->SetPageProperty("WITHOUT_BOTTOM_MENU", true);


//new dBug($arParams);
//new dBug($arResult);
?>