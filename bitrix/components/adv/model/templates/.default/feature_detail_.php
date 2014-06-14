<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<script type="text/javascript">
	var vehicle_navigation_teaser = "r";
</script>




<?
$APPLICATION->IncludeComponent("adv:model.feature_detail", "", array(
	  "MODEL_ID" => $arResult['VARIABLES']['MODEL_ID']
	, "RANGE_CODE" => $arResult['VARIABLES']["RANGE_CODE"]
	, "FEATURE_CODE" => $arResult['VARIABLES']["FEATURE_CODE"]
	, "FEATURE_IBLOCK" => $arResult["FEATURE_IBLOCK"]
	, "CACHE_TIME" => $arParams['CACHE_TIME']
	, "RANGE_SECTION" => $arResult['RANGE_SECTION']
	, "FEATURE_SECTION" => $arResult['FEATURE_SECTION']
	, "TITLE_COLOR" => $arResult["FEATURE_SECTION"]["UF_TITLE_COLOR"]["XML_ID"]
));
?>