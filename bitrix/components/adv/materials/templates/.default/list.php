<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$APPLICATION->IncludeComponent(
	"adv:materials.list",
	"news",
	Array(
		"IBLOCK_TYPE"	=>	$arParams["IBLOCK_TYPE"],
		"IBLOCK_ID"	=>	$arParams["IBLOCK_ID"],
		"SECTION_ID"	=>	$arParams["SECTION_ID"],
		"ELEMENT_COUNT"	=>	$arParams["ELEMENT_COUNT"],
		"SORT_BY1"	=>	$arParams["SORT_BY1"],
		"SORT_ORDER1"     =>	$arParams["SORT_ORDER1"],
		"SORT_BY2"        =>	$arParams["SORT_BY2"],
		"SORT_ORDER2"     =>	$arParams["SORT_ORDER2"],
		"DETAIL_PAGE_URL"	=>	$arResult["FOLDER"]."#ELEMENT_CODE#",
		"DISPLAY_PANEL"   =>	$arParams["DISPLAY_PANEL"],
		"DATE_FORMAT"	=>		$arParams["DATE_FORMAT"],
		"SET_TITLE"       =>	$arParams["SET_TITLE"],
		"CACHE_TYPE"	=>	$arParams["CACHE_TYPE"],
		"CACHE_TIME"	=>	$arParams["CACHE_TIME"],
		"CACHE_FILTER"	=>	$arParams["CACHE_FILTER"],
	),
	$component
);?>
