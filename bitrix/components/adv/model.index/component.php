<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?
$arParams["CACHE_TIME"] = isset($arParams["CACHE_TIME"])?intval($arParams["CACHE_TIME"]):86400;
$arParams["IBLOCK_FEATURE_TYPE"] = trim($arParams['IBLOCK_FEATURE_TYPE']);
$arParams["IBLOCK_MODEL_CODE"] = trim($arParams['IBLOCK_MODEL_CODE']);
$arParams["MODEL_ID"] = intval($arParams["MODEL_ID"]);
$arParams["RANGE_CODE"] = trim($arParams["RANGE_CODE"]);
$arParams["FEATURE_IBLOCK"] = (array)($arParams["FEATURE_IBLOCK"]);
$arParams["RANGE_SECTION"] = (array)($arParams["RANGE_SECTION"]);

if (!CModule::IncludeModule("iblock"))
{
	return false;
}

$arResult['FEATURE_IBLOCK'] = $arParams['~FEATURE_IBLOCK'];
$arResult['RANGE_SECTION'] = $arParams['~RANGE_SECTION'];

$CACHE_ID = md5(serialize(array(
	$arParams,
	"index" //соль
)));
$objPHPCache = new CPHPCache;
if($objPHPCache->StartDataCache($arParams["CACHE_TIME"], $CACHE_ID))
{
	/**
	 * Получим саму модель
	 */
	/*$arOrder = array();
	$arFilter = array(
		  "ID" => $arParams['MODEL_ID']
		, "IBLOCK_CODE" => $arParams['IBLOCK_MODEL_CODE']
		, "IBLOCK_TYPE" => $arParams['IBLOCK_FEATURE_TYPE']
		, "ACTIVE" => "Y"
	);
	$arSelect = array('NAME', "PROPERTY_SHOW_BANNER_EFF");
	$rsIBlockElementList = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);

	if ($rsIBlockElementList && $arIBlockElement = $rsIBlockElementList->Fetch()) 
	{
		$arResult['MODEL'] = $arIBlockElement;
	}
	else 
	{
		ShowError("Не удалось получить модель");
		$this->AbortResultCache();
		return false;
	}*/
	
	
	// цвет текста
	$rsColorPropValue = CUserFieldEnum::GetList(
		array(), 
		array('ID' => $arParams['RANGE_SECTION']["UF_TITLE_COLOR"])
	);
	if ($rsColorPropValue && $arColorPropValue = $rsColorPropValue->Fetch())
	{
		$arColorPropValue['XML_ID'] = str_replace("#", "", $arColorPropValue['XML_ID']);
		$arResult["FEATURE_SECTION"]["UF_TOP_MARGIN"] = intval($arResult["FEATURE_SECTION"]["UF_TOP_MARGIN"]);
		$arResult["FEATURE_SECTION"]["UF_LEFT_MARGIN"] = intval($arResult["FEATURE_SECTION"]["UF_LEFT_MARGIN"]);
		$arResult['TITLE_COLOR'] = $arColorPropValue['XML_ID'];
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

if($arParams['DESCRIPTION'])
{
	$APPLICATION->SetPageProperty('description', $arParams['DESCRIPTION']);
}
if($arParams['KEYWORDS'])
{
	$APPLICATION->SetPageProperty('keywords', $arParams['KEYWORDS']);
}

$this->IncludeComponentTemplate();	
?>