<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?

$APPLICATION->IncludeComponent("adv:model.feature_presentation", "", array(
	  "MODEL_ID" => $arResult['VARIABLES']['MODEL_ID']
	, "RANGE_CODE" => $arResult['VARIABLES']["RANGE_CODE"]
	, "FEATURE_CODE" => $arResult['VARIABLES']["FEATURE_CODE"]
	, "FEATURE_IBLOCK" => $arResult["FEATURE_IBLOCK"]
	, "CACHE_TIME" => $arParams['CACHE_TIME']
	, "RANGE_SECTION" => $arResult['RANGE_SECTION']
	, "FEATURE_SECTION" => $arResult['FEATURE_SECTION']
	, "IBLOCK_PRESENTATION_CODE" => $arParams["IBLOCK_PRESENTATION_CODE"]
	, "URL_TEMPLATES" => $arResult['URL_TEMPLATES']
));
?>