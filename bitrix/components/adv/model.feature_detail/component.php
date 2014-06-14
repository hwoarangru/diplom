<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?

$arParams["CACHE_TIME"] = isset($arParams["CACHE_TIME"])?intval($arParams["CACHE_TIME"]):86400;
$arParams["FEATURE_CODE"] = trim($arParams["FEATURE_CODE"]);
$arParams["MODEL_ID"] = intval($arParams["MODEL_ID"]);
$arParams["RANGE_CODE"] = trim($arParams["RANGE_CODE"]);
$arParams["FEATURE_IBLOCK"] = (array)($arParams["FEATURE_IBLOCK"]);
$arParams["FEATURE_SECTION"] = (array)($arParams["FEATURE_SECTION"]);
$arParams["RANGE_SECTION"] = (array)($arParams["RANGE_SECTION"]);


if (!CModule::IncludeModule("iblock"))
{
	return false;
}

$CACHE_ID = md5(serialize(array(
	$arParams,
	"feature_detail" //соль
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
	 * Получим элемент ИБ "Особенности"
	 */
	$arOrder = array();
	$arFilter = array(
		  "IBLOCK_ID" => $arParams["FEATURE_SECTION"]["IBLOCK_ID"]
		, "SECTION_ID" => $arParams["FEATURE_SECTION"]["ID"]
		, "CODE" => $arParams["FEATURE_CODE"]
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

		if ($arIBlockElement["PROPS"]["FLASH_FILE"]["VALUE"]) 
		{
			$arIBlockElement["PROPS"]["FLASH_FILE"]["SRC"] = CFile::GetPath($arIBlockElement["PROPS"]["FLASH_FILE"]["VALUE"]);
		}
		elseif ($arIBlockElement["FIELDS"]["DETAIL_PICTURE"])
		{
			$arIBlockElement["FIELDS"]["DETAIL_PICTURE_SRC"] = CFile::GetPath($arIBlockElement["FIELDS"]["DETAIL_PICTURE"]);
		}
		
		if($arIBlockElement["PROPS"]["DOUBLE_GALL"]["VALUE"]=="Y")//двойная галлерея
		{/*//пока ненужна
			$arFilter_double = array(
				  "IBLOCK_ID" => $arParams["FEATURE_SECTION"]["IBLOCK_ID"]
				, "SECTION_CODE" => $arParams["FEATURE_CODE"]
				, "ACTIVE" => "Y"
			);
			$rsIBlockElementList_double = CIBlockSection::GetList(array(), $arFilter_double, false, array("ID"));//секция с нужными элементами
			if($ar_result_double = $rsIBlockElementList_double->GetNext())
			{
				$arIBlockElement["HAS_DOUBLE_GALL"]="Y";
				
				$arFilter_double_elem = array(
					  "IBLOCK_ID" => $arParams["FEATURE_SECTION"]["IBLOCK_ID"]
					, "SECTION_CODE" => $arParams["FEATURE_CODE"]
					, "ACTIVE" => "Y"
				);
				$rsIBlockElementList_double_elem = CIBlockElement::GetList(array("SORT"=>"ASC"), $arFilter_double_elem, false, false, array("NAME", "PROPERTY_PHOTO_SLIDE", "DETAIL_TEXT", "PREVIEW_TEXT", "PREVIEW_PICTURE"));//элементы двойной галлереи
				while($gall = $rsIBlockElementList_double_elem->GetNext())
				{
					$gall["PREVIEW_PICTURE"] = CFile::GetPath($gall["PREVIEW_PICTURE"]);
					$arIBlockElement["DOUBLE_GALL"][]=$gall;
				}
			}*/
		
		}
		
		$arResult["ELEMENT"] = $arIBlockElement;
		
		/*******************************************************************
		 		Получим "ссылки по теме" - BEGIN
		 *******************************************************************/

		// краткие описания в "ссылки по теме"
		if (is_array($arResult['ELEMENT']['PROPS']['FEW_LINK_ELEMENT']['VALUE']) && count($arResult['ELEMENT']['PROPS']['FEW_LINK_ELEMENT']['VALUE']))
		{
			foreach ($arResult['ELEMENT']['PROPS']['FEW_LINK_ELEMENT']['VALUE'] as $k=>$arItem) 
			{
				$arResult['LINK_ELEMENT'][] = array(
					  'TYPE' => 'POPUP'
					, 'NAME' => $arResult['ELEMENT']['PROPS']['FEW_LINK_ELEMENT']['DESCRIPTION'][$k]
					, 'VALUE' => $arResult['ELEMENT']['PROPS']['FEW_LINK_ELEMENT']['~VALUE'][$k]
				);
			}
		}
		
		// ссылки на описания особенностей
		if (is_array($arResult['ELEMENT']['PROPS']['LINK_ELEMENT']['VALUE']) && count($arResult['ELEMENT']['PROPS']['LINK_ELEMENT']['VALUE']))
		{
			$arOrder = array("SORT" => "ASC", "NAME" => "ASC");
			$arFilter = array(
				  "ID" => array_values($arResult['ELEMENT']['PROPS']['LINK_ELEMENT']['VALUE'])
				, "IBLOCK_ID" => $arParams["FEATURE_SECTION"]["IBLOCK_ID"]
				, "ACTIVE" => "Y"
			);
//			new dBug($arResult['ELEMENT']['PROPS']['LINK_ELEMENT']['VALUE']);
			$rsIBlockElementList = CIBlockElement::GetList($arOrder, $arFilter);
			while ($rsIBlockElementList && $objIBlockElement = $rsIBlockElementList->GetNextElement()) 
			{
				$arIBlockElement = array
				(
					  'FIELDS' => $objIBlockElement->GetFields()
					, 'PROPS' => $objIBlockElement->GetProperties()
				);
				/*
				$arIBlockElement['FIELDS']['DETAIL_PAGE_URL'] = str_replace(
					  array('model',"#RANGE_CODE#", "#MODEL_ID#")
					, array('cars', $arParams["RANGE_CODE"], $arParams["CODE"])
					, $arIBlockElement['FIELDS']['DETAIL_PAGE_URL']
				);
				*/
				
				$arIBlockElement['FIELDS']['DETAIL_PAGE_URL'] = str_replace(
					  array('model', "#RANGE_CODE#", "#MODEL_ID#")
					, array('cars',$arParams["RANGE_CODE"], $arParams["CODE"])
					, $arIBlockElement['FIELDS']['DETAIL_PAGE_URL']
				);
				
				$arResult['LINK_ELEMENT'][] = array(
					  'TYPE' => 'FEATURE'
					, 'NAME' => $arIBlockElement['FIELDS']['NAME']
					, 'DETAIL_PAGE_URL' => $arIBlockElement['FIELDS']['DETAIL_PAGE_URL']
					, 'ELEMENT' => $arIBlockElement
				);
			}
		}
		

		
		// "жестко" заданные ссылки
		if (is_array($arResult['ELEMENT']['PROPS']['DIRECT_LINK']['VALUE']) && count($arResult['ELEMENT']['PROPS']['DIRECT_LINK']['VALUE']))
		{
			foreach ($arResult['ELEMENT']['PROPS']['DIRECT_LINK']['VALUE'] as $k=>$arItem) 
			{
				$arResult['LINK_ELEMENT'][] = array(
					  'TYPE' => 'DIRECT_LINK'
					, 'NAME' => $arResult['ELEMENT']['PROPS']['DIRECT_LINK']['DESCRIPTION'][$k]
					, 'VALUE' => $arResult['ELEMENT']['PROPS']['DIRECT_LINK']['~VALUE'][$k]
				);
			}
		}
		/*******************************************************************
		 		Получим "ссылки по теме" - END
		 *******************************************************************/
		
/****
Фотографии для слайдера
****/

		if(is_array($arResult['ELEMENT']['PROPS']['PHOTO_SLIDE']['VALUE']) && !empty($arResult['ELEMENT']['PROPS']['PHOTO_SLIDE']['VALUE'])){
			foreach($arResult['ELEMENT']['PROPS']['PHOTO_SLIDE']['VALUE'] as &$file){
				$file = CFile::GetPath($file);

			}
		}

	}
	else 
	{
		ShowError("Не удалось получить описание");
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
$APPLICATION->SetPageProperty("pagetitle", $arResult["ELEMENT"]["FIELDS"]["NAME"] . ' - ' . $arParams["FEATURE_SECTION"]['NAME'] . ' - ' . $arResult['MODEL']['NAME'] . ' - официальный дилер Независимость BMW');

$this->IncludeComponentTemplate();

//$APPLICATION->SetPageProperty("pagetitle", $arResult['MODEL']['NAME'] . ': ' . $arResult["ELEMENT"]["FIELDS"]["NAME"]);
?>