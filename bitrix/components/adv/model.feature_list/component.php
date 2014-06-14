<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?
$arParams["CACHE_TIME"] = isset($arParams["CACHE_TIME"])?intval($arParams["CACHE_TIME"]):86400;
$arParams["MODEL_ID"] = intval($arParams["MODEL_ID"]);
$arParams["RANGE_CODE"] = trim($arParams["RANGE_CODE"]);
$arParams["SEF_FOLDER"] = trim($arParams["SEF_FOLDER"]);
$arParams["FEATURE_IBLOCK"] = (array)($arParams["FEATURE_IBLOCK"]);
$arParams["FEATURE_SECTION"] = (array)($arParams["FEATURE_SECTION"]);
$arParams["RANGE_SECTION"] = (array)($arParams["RANGE_SECTION"]);
$arParams["URL_TEMPLATES"] = (array)($arParams["URL_TEMPLATES"]);
//$arParams["IBLOCK_FEATURE_CODE"] = trim($arParams["IBLOCK_FEATURE_CODE"]);
$arParams["IBLOCK_VIEW360_CODE"] = trim($arParams["IBLOCK_VIEW360_CODE"]);
$arParams["IBLOCK_FEATURE_TYPE"] = trim($arParams["IBLOCK_FEATURE_TYPE"]);
if ($arParams["MODEL_ID"] <= 0)
{
	ShowError("Не указан ID модели");
	return false;
}


$model = $arParams["MODEL_ID"];
if(array_key_exists('CODE', $arParams) && $arParams['CODE'] != ''){
    $model = $arParams['CODE'];
}


if (!$arParams["FEATURE_IBLOCK"]["ID"])
{
	$res = CIBlockSection::GetByID($arParams["FEATURE_SECTION"]['ID']);
	$arSection = $res->Fetch();
	$arParams["FEATURE_IBLOCK"]["ID"] = $arSection["IBLOCK_ID"];
}

//if ($arParams["FEATURE_SECTION_ID"] <= 0)
//{
//	ShowError("Не указан ID раздела с параметрами");
//	return false;
//}

$arResult['RANGE_SECTION'] = $arParams['RANGE_SECTION'];
$arResult['FEATURE_SECTION'] = $arParams['FEATURE_SECTION'];

if (!CModule::IncludeModule("iblock"))
{
	return false;
}

$CACHE_ID = md5(serialize(array(
	$arParams,
	"feature_list" //соль
)));
$objPHPCache = new CPHPCache;
if($objPHPCache->StartDataCache($arParams["CACHE_TIME"], $CACHE_ID))
{

	/**
	 * Получим саму модель
	 */
	if($arParams["MODEL_NAME"])
	{
		$arResult['MODEL']['NAME'] = $arParams["MODEL_NAME"];
	}
	else
	{
		$arOrder = array();
		$arFilter = array(
		"ID" => $arParams['MODEL_ID']
		, "IBLOCK_CODE" => $arParams['IBLOCK_MODEL_CODE']
		, "IBLOCK_TYPE" => $arParams['IBLOCK_FEATURE_TYPE']
		, "ACTIVE" => "Y"
		);
		$arSelect = array('NAME');
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
		}
	}

	/**
	 * Получим список особенностей
	 */
	$arOrder = array("SORT" => "ASC", "NAME" => "ASC");
	$arFilter = array(
	"SECTION_ID" => $arParams["FEATURE_SECTION"]['ID']
	, "ACTIVE" => "Y"
	, "IBLOCK_ID" => $arParams["FEATURE_IBLOCK"]["ID"]
	);
	//	new dBug($arParams);
	//	new dBug($arFilter);

	$rsIBlockElementList = CIBlockElement::GetList($arOrder, $arFilter);
	while ($rsIBlockElementList && $objIBlockElement = $rsIBlockElementList->GetNextElement())
	{
		$arIBlockElement = array
		(
		'FIELDS' => $objIBlockElement->GetFields()
		, 'PROPS' => $objIBlockElement->GetProperties()
		);
		$arIBlockElement['FIELDS']['DETAIL_PAGE_URL'] = str_replace(
		array("#RANGE_CODE#", "#MODEL_ID#")
		, array($arParams["RANGE_CODE"], $model)
		, $arIBlockElement['FIELDS']['DETAIL_PAGE_URL']
		);
		$arResult['ITEM_LIST'][$arIBlockElement['FIELDS']['ID']] = $arIBlockElement;
		$arResult['ITEM_LIST_ID_SORT'][] = $arIBlockElement['FIELDS']['ID'];
		if($arParams["FEATURE_SECTION"]["UF_MARGIN_LEFT"])
		{
			$arResult['MARGIN_LEFT'] = $arParams["FEATURE_SECTION"]["UF_MARGIN_LEFT"];
		}
	}

	/**
	 * Проверим может быть есть "Обзор 360" для этого раздела
	 */	
	
	$arOrder = array("SORT" => "ASC", "NAME" => "ASC");
	
	/**
	 * Быть может "Обзор 360" в свойстве подсекции особенностей
	 */	
	if($arParams["FEATURE_SECTION"]["UF_VIS360"])
	{
		$arFilter = array(
			"IBLOCK_CODE" => $arParams["IBLOCK_VIEW360_CODE"]
			, "ID" => $arParams["FEATURE_SECTION"]["UF_VIS360"]
			, "ACTIVE" => "Y"
		);
	}
	else
	{
		$arFilter = array(
			"IBLOCK_CODE" => $arParams["IBLOCK_VIEW360_CODE"]
			, "PROPERTY_MODEL_SECTION_ID" => $arParams["FEATURE_SECTION"]["ID"]
			, "ACTIVE" => "Y"
		);
	}
	
	
	$rsIBlockElementList = CIBlockElement::GetList($arOrder, $arFilter, false, false, array("DETAIL_PAGE_URL", "NAME", "PREVIEW_TEXT", "PROPERTY_FEW_PREVIEW_TEXT", "PROPERTY_PRESENTATION", "PROPERTY_LAST", "PROPERTY_NAME_FOR_SEC", "PROPERTY_BLANK"));
	if ($rsIBlockElementList && $objIBlockElement = $rsIBlockElementList->GetNext())
	{
		$arIBlockElement['FIELDS']['DETAIL_PAGE_URL']=$objIBlockElement["DETAIL_PAGE_URL"];
		$arIBlockElement['FIELDS']['NAME']=$objIBlockElement["NAME"];
		$arIBlockElement['FIELDS']['PREVIEW_TEXT']=$objIBlockElement["PREVIEW_TEXT"];
		$arIBlockElement['PROPS']['DETAIL_PAGE_URL']['~VALUE']=$objIBlockElement["PROPERTY_FEW_PREVIEW_TEXT_VALUE"];
		$arIBlockElement['PROPS']['PRESENTATION']['VALUE']=$objIBlockElement["PROPERTY_PRESENTATION_VALUE"];
		$arIBlockElement['PROPS']['LAST']['VALUE']=$objIBlockElement["PROPERTY_LAST_VALUE"];
		$arIBlockElement['PROPS']['NAME_FOR_SEC']['VALUE']=$objIBlockElement["PROPERTY_NAME_FOR_SEC_VALUE"];
		$arIBlockElement['PROPS']['BLANK']['VALUE']=$objIBlockElement["PROPERTY_BLANK_VALUE"];
		$arIBlockElement['DETAIL_PAGE_URL'] = "/" . $arParams["SEF_FOLDER"] . "/" . str_replace
		(
		array('#RANGE_CODE#', '#MODEL_ID#' , '#FEATURE_SECTION_CODE#')
		, array($arParams["RANGE_CODE"], $model, $arResult['FEATURE_SECTION']['CODE'])
		, $arParams["URL_TEMPLATES"]['model_view360']
		);
		$arResult['VIEW_360'] = $arIBlockElement;
	}


	/**
	 * Получим список презентаций от этих особенностей
	 */
	/*if (count($arResult['ITEM_LIST_ID_SORT']))
	{
		$arOrder = array();
		$arFilter = array(
		"IBLOCK_CODE" => $arParams["IBLOCK_PRESENTATION_CODE"]
		, "PROPERTY_LINK_ELEMENT" => $arResult['ITEM_LIST_ID_SORT']
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


			$intersect = array_intersect($arResult['ITEM_LIST_ID_SORT'], $arIBlockElement['PROPS']['LINK_ELEMENT']['VALUE']);
			$LINK_ELEMENT_VALUE = null;
			if(!empty($intersect)){
				$LINK_ELEMENT_VALUE = current($intersect);
				$arCurFeature = $arResult['ITEM_LIST'][$LINK_ELEMENT_VALUE];
				//$arCurFeature = $arResult['ITEM_LIST'][$arIBlockElement['PROPS']['LINK_ELEMENT']['VALUE']];
			}		

			$arIBlockElement['FIELDS']['DETAIL_PAGE_URL'] = '/'.$arParams['SEF_FOLDER'] . '/'.str_replace(
			array('#RANGE_CODE#', '#MODEL_ID#', '#FEATURE_SECTION_CODE#', '#FEATURE_CODE#')
			, array($arParams["RANGE_CODE"], $model, $arResult['FEATURE_SECTION']['CODE'], $arCurFeature['FIELDS']['CODE'])
			, $arParams['URL_TEMPLATES']['feature_presentation']
			);
			if(null !== $LINK_ELEMENT_VALUE){
				$arResult['PRESENTATION'][$LINK_ELEMENT_VALUE] = $arIBlockElement;
			}
			
		}
	}*/
	
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
	$APPLICATION->SetPageProperty("description", $arParams['DESCRIPTION']);
}

if($arParams['KEYWORDS'])
{
	$APPLICATION->SetPageProperty("keywords", $arParams['KEYWORDS']);
}


$APPLICATION->SetPageProperty("pagetitle", $arParams["FEATURE_SECTION"]['NAME'] . ' - ' . $arResult['MODEL']['NAME'] . ' - официальный дилер Независимость BMW');

$this->IncludeComponentTemplate();


//new dBug($arResult['PRESENTATION']);
