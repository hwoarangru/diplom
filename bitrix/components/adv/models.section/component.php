<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

CPageOption::SetOptionString("main", "nav_page_in_session", "N");

$arParams["IBLOCK_PHOTO_CODE"] = "photo";
$arParams["IBLOCK_VIDEO_CODE"] = "video";
$arParams["IBLOCK_PRESENTATION_CODE"] = "presentation";

/*************************************************************************
	Processing of received parameters
*************************************************************************/
if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 36000000;

$arParams["IBLOCK_TYPE"] = trim($arParams["IBLOCK_TYPE"]);
$arParams["IBLOCK_ID"] = intval($arParams["IBLOCK_ID"]);

$arParams["SECTION_ID"] = intval($arParams["~SECTION_ID"]);
if($arParams["SECTION_ID"] > 0 && $arParams["SECTION_ID"]."" != $arParams["~SECTION_ID"])
{
	define("ERROR_404","Y");
	$componentPage = "404";
	//CHTTP::SetStatus("404 Not Found");
}


$arParams["INCLUDE_SUBSECTIONS"] = $arParams["INCLUDE_SUBSECTIONS"]!="N"? "Y": "N";
$arParams["SHOW_ALL_WO_SECTION"] = $arParams["SHOW_ALL_WO_SECTION"]==="Y";

if(strlen($arParams["ELEMENT_SORT_FIELD"])<=0)
	$arParams["ELEMENT_SORT_FIELD"]="sort";

if(!preg_match('/^(asc|desc|nulls)(,asc|,desc|,nulls){0,1}$/i', $arParams["ELEMENT_SORT_ORDER"]))
	 $arParams["ELEMENT_SORT_ORDER"]="asc";

if(strlen($arParams["FILTER_NAME"])<=0 || !preg_match("/^[A-Za-z_][A-Za-z01-9_]*$/", $arParams["FILTER_NAME"]))
{
	$arrFilter = array();
}
else
{
	global $$arParams["FILTER_NAME"];
	$arrFilter = ${$arParams["FILTER_NAME"]};
	if(!is_array($arrFilter))
		$arrFilter = array();
}

$arParams["SECTION_URL"]=trim($arParams["SECTION_URL"]);
$arParams["DETAIL_URL"]=trim($arParams["DETAIL_URL"]);


$arParams["PRODUCT_ID_VARIABLE"]=trim($arParams["PRODUCT_ID_VARIABLE"]);
if(strlen($arParams["PRODUCT_ID_VARIABLE"])<=0|| !preg_match("/^[A-Za-z_][A-Za-z01-9_]*$/", $arParams["PRODUCT_ID_VARIABLE"]))
	$arParams["PRODUCT_ID_VARIABLE"] = "id";

$arParams["PRODUCT_PROPS_VARIABLE"]=trim($arParams["PRODUCT_PROPS_VARIABLE"]);
if(strlen($arParams["PRODUCT_PROPS_VARIABLE"])<=0|| !preg_match("/^[A-Za-z_][A-Za-z01-9_]*$/", $arParams["PRODUCT_PROPS_VARIABLE"]))
	$arParams["PRODUCT_PROPS_VARIABLE"] = "prop";

$arParams["SECTION_ID_VARIABLE"]=trim($arParams["SECTION_ID_VARIABLE"]);
if(strlen($arParams["SECTION_ID_VARIABLE"])<=0|| !preg_match("/^[A-Za-z_][A-Za-z01-9_]*$/", $arParams["SECTION_ID_VARIABLE"]))
	$arParams["SECTION_ID_VARIABLE"] = "SECTION_ID";

$arParams["SET_TITLE"] = $arParams["SET_TITLE"]!="N";

$arParams["PAGE_ELEMENT_COUNT"] = intval($arParams["PAGE_ELEMENT_COUNT"]);
if($arParams["PAGE_ELEMENT_COUNT"]<=0)
	$arParams["PAGE_ELEMENT_COUNT"]=20;
$arParams["LINE_ELEMENT_COUNT"] = intval($arParams["LINE_ELEMENT_COUNT"]);
if($arParams["LINE_ELEMENT_COUNT"]<=0)
	$arParams["LINE_ELEMENT_COUNT"]=3;

if(!is_array($arParams["PROPERTY_CODE"]))
	$arParams["PROPERTY_CODE"] = array();
foreach($arParams["PROPERTY_CODE"] as $k=>$v)
	if($v==="")
		unset($arParams["PROPERTY_CODE"][$k]);

$arNavParams = array(
	"nPageSize" => $arParams["PAGE_ELEMENT_COUNT"],
	"bDescPageNumbering" => $arParams["PAGER_DESC_NUMBERING"],
	"bShowAll" => $arParams["PAGER_SHOW_ALL"],
);

$arParams["CACHE_FILTER"]=$arParams["CACHE_FILTER"]=="Y";
if(!$arParams["CACHE_FILTER"] && count($arrFilter)>0)
	$arParams["CACHE_TIME"] = 0;

/*************************************************************************
			Work with cache
*************************************************************************/
if($this->StartResultCache(false, array($arrFilter, ($arParams["CACHE_GROUPS"]==="N"? false: $USER->GetGroups()), $arNavigation)))
{
	if(!CModule::IncludeModule("iblock"))
	{
		$this->AbortResultCache();
		ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
		return;
	}

	if(preg_match("/^UF_/", $arParams["META_KEYWORDS"])) $arSelect[] = $arParams["META_KEYWORDS"];
	if(preg_match("/^UF_/", $arParams["META_DESCRIPTION"])) $arSelect[] = $arParams["META_DESCRIPTION"];
	if(preg_match("/^UF_/", $arParams["BROWSER_TITLE"])) $arSelect[] = $arParams["BROWSER_TITLE"];

	$arFilter = array(
		"ACTIVE"=>"Y",
		"GLOBAL_ACTIVE"=>"Y",
		"IBLOCK_ID"=>$arParams["IBLOCK_ID"],
		"IBLOCK_ACTIVE"=>"Y",
	);

	$bSectionFound = false;
	//Hidden triky parameter USED to display linked
	//by default it is not set
	if(strlen($arParams["SECTION_CODE"]) > 0)
	{
		$arFilter["CODE"]=$arParams["SECTION_CODE"];
		$rsSection = CIBlockSection::GetList(Array(), $arFilter, false, $arSelect);
		$rsSection->SetUrlTemplates("", $arParams["SECTION_URL"]);
		$arResult = $rsSection->GetNext();
		if($arResult)
			$bSectionFound = true;
	}
	elseif($arParams["SECTION_ID"])
	{
		$arFilter["ID"]=$arParams["SECTION_ID"];
		$rsSection = CIBlockSection::GetList(Array(), $arFilter, false, $arSelect);
		$rsSection->SetUrlTemplates("", $arParams["SECTION_URL"]);
		$arResult = $rsSection->GetNext();
		if($arResult)
			$bSectionFound = true;
	}
	else
	{
		//Root section (no section filter)
		$arResult = array(
			"ID" => 0,
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		);
		$bSectionFound = true;
	}

	if(!$bSectionFound)
	{
		$this->AbortResultCache();
		define("ERROR_404","Y");
		$componentPage = "404";
		//CHTTP::SetStatus("404 Not Found");
	}
	elseif($arResult["ID"] > 0 && $arParams["ADD_SECTIONS_CHAIN"])
	{
		$arResult["PATH"] = array();
		$rsPath = GetIBlockSectionPath($arResult["IBLOCK_ID"], $arResult["ID"]);
		$rsPath->SetUrlTemplates("", $arParams["SECTION_URL"]);
		while($arPath = $rsPath->GetNext())
		{
			$arResult["PATH"][]=$arPath;
		}
	}

	$arResult["PICTURE"] = CFile::GetFileArray($arResult["PICTURE"]);
	$arResult["DETAIL_PICTURE"] = CFile::GetFileArray($arResult["DETAIL_PICTURE"]);

	// list of the element fields that will be used in selection
	$arSelect = array(
		"ID",
		"NAME",
		"CODE",
		"DATE_CREATE",
		"ACTIVE_FROM",
		"CREATED_BY",
		"IBLOCK_ID",
		"IBLOCK_SECTION_ID",
		"DETAIL_PAGE_URL",
		"DETAIL_TEXT",
		"DETAIL_TEXT_TYPE",
		"DETAIL_PICTURE",
		"PREVIEW_TEXT",
		"PREVIEW_TEXT_TYPE",
		"PREVIEW_PICTURE",
		"PROPERTY_*",
	);
	$arFilter = array(
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"IBLOCK_LID" => SITE_ID,
		"IBLOCK_ACTIVE" => "Y",
		"ACTIVE_DATE" => "Y",
		"ACTIVE" => "Y",
		"CHECK_PERMISSIONS" => "Y",
		"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
	);

	if($arResult["ID"])
		$arFilter["SECTION_ID"] = $arResult["ID"];
	elseif(!$arParams["SHOW_ALL_WO_SECTION"])
		$arFilter["SECTION_ID"] = 0;

	$arSort = array(
		$arParams["ELEMENT_SORT_FIELD"] => $arParams["ELEMENT_SORT_ORDER"],
		"ID" => "DESC",
	);
	//EXECUTE
	$rsElements = CIBlockElement::GetList($arSort, array_merge($arrFilter, $arFilter), false, $arNavParams, $arSelect);
	$rsElements->SetUrlTemplates($arParams["DETAIL_URL"]);
	if($arParams["BY_LINK"]!=="Y" && !$arParams["SHOW_ALL_WO_SECTION"])
		$rsElements->SetSectionContext($arResult);
	$arResult["ITEMS"] = array();
	while($obElement = $rsElements->GetNextElement())
	{
		$arItem = $obElement->GetFields();
		$arItem["PROPERTIES"] = $obElement->GetProperties();

		if($arResult["ID"])
			$arItem["IBLOCK_SECTION_ID"] = $arResult["ID"];

		$arButtons = CIBlock::GetPanelButtons(
			$arItem["IBLOCK_ID"],
			$arItem["ID"],
			$arResult["ID"],
			array("SECTION_BUTTONS"=>false, "SESSID"=>false)
		);
		$arItem["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"];
		$arItem["DELETE_LINK"] = $arButtons["edit"]["delete_element"]["ACTION_URL"];

		$arItem["PREVIEW_PICTURE"] = CFile::GetFileArray($arItem["PREVIEW_PICTURE"]);
		$arItem["DETAIL_PICTURE"] = CFile::GetFileArray($arItem["DETAIL_PICTURE"]);

		$arItem["DISPLAY_PROPERTIES"] = array();
		foreach($arParams["PROPERTY_CODE"] as $pid)
		{
			$prop = &$arItem["PROPERTIES"][$pid];
			if(
				(is_array($prop["VALUE"]) && count($prop["VALUE"]) > 0)
				|| (!is_array($prop["VALUE"]) && strlen($prop["VALUE"]) > 0)
			)
			{
				$arItem["DISPLAY_PROPERTIES"][$pid] = CIBlockFormatProperties::GetDisplayValue($arItem, $prop, "catalog_out");
			}
		}
		
		//доп пункты
		$arItem["LINKS"] = array();
		$link = array();
		if($arItem['PROPERTIES']['COMPARISON']['VALUE'])
		{
			$link["URL"] = $arItem['PROPERTIES']['COMPARISON']['VALUE'];
			$link["NAME"] = "Визуализатор 360°";
			$arItem["LINKS"][] = $link;
		}
		if(!$arItem['PROPERTIES']['DOWN_CONF']['VALUE'])
		{
			$link["URL"] = "/choose/";
			$link["NAME"] = "Конфигуратор";
			$arItem["LINKS"][] = $link;
		}
		if($arItem['PROPERTIES']['TEST_DRIVE']['VALUE'])
		{
			$link["URL"] = "/testdrive/";
			$link["NAME"] = "Заказать тест-драйв";
			$arItem["LINKS"][] = $link;
		}

		$arResult["ITEMS"][]=$arItem;
		$arResult["ELEMENTS"][] = $arItem["ID"];
	}

	$this->SetResultCacheKeys(array(
		"ID",
		"NAV_CACHED_DATA",
		$arParams["META_KEYWORDS"],
		$arParams["META_DESCRIPTION"],
		$arParams["BROWSER_TITLE"],
		"NAME",
		"PATH",
		"IBLOCK_SECTION_ID",
	));
	if($componentPage)
	{
		$this->IncludeComponentTemplate($componentPage);
	}
	else
	{
		$this->IncludeComponentTemplate();
	}
}

$arTitleOptions = null;
if($USER->IsAuthorized())
{
	if(
		$APPLICATION->GetShowIncludeAreas()
		|| $arParams["SET_TITLE"]
		|| isset($arResult[$arParams["BROWSER_TITLE"]])
	)
	{
		if(CModule::IncludeModule("iblock"))
		{
			$UrlDeleteSectionButton = "";
			if($arResult["IBLOCK_SECTION_ID"] > 0)
			{
				$rsSection = CIBlockSection::GetList(
					array(),
					array("=ID" => $arResult["IBLOCK_SECTION_ID"]),
					false,
					array("SECTION_PAGE_URL")
				);
				$rsSection->SetUrlTemplates("", $arParams["SECTION_URL"]);
				$arSection = $rsSection->GetNext();
				$UrlDeleteSectionButton = $arSection["SECTION_PAGE_URL"];
			}

			if(empty($UrlDeleteSectionButton))
			{
				$url_template = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "LIST_PAGE_URL");
				$arIBlock = CIBlock::GetArrayByID($arParams["IBLOCK_ID"]);
				$arIBlock["IBLOCK_CODE"] = $arIBlock["CODE"];
				$UrlDeleteSectionButton = CIBlock::ReplaceDetailURL($url_template, $arIBlock, true, false);
			}

			$arReturnUrl = array(
				"add_section" => (
					strlen($arParams["SECTION_URL"])?
					$arParams["SECTION_URL"]:
					CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_PAGE_URL")
				),
				"delete_section" => $UrlDeleteSectionButton,
			);
			$arButtons = CIBlock::GetPanelButtons(
				$arParams["IBLOCK_ID"],
				0,
				$arResult["ID"],
				array("RETURN_URL" =>  $arReturnUrl)
			);

			if($APPLICATION->GetShowIncludeAreas())
				$this->AddIncludeAreaIcons(CIBlock::GetComponentMenu($APPLICATION->GetPublicShowMode(), $arButtons));

			if($arParams["SET_TITLE"] || isset($arResult[$arParams["BROWSER_TITLE"]]))
			{
				$arTitleOptions = array(
					'ADMIN_EDIT_LINK' => $arButtons["submenu"]["edit_section"]["ACTION"],
					'PUBLIC_EDIT_LINK' => $arButtons["edit"]["edit_section"]["ACTION"],
					'COMPONENT_NAME' => $this->GetName(),
				);
			}
		}
	}
}

if(isset($arResult[$arParams["META_KEYWORDS"]]))
{
	$val = $arResult[$arParams["META_KEYWORDS"]];
	if(is_array($val))
		$val = implode(" ", $val);
	$APPLICATION->SetPageProperty("keywords", $val);
}

if(isset($arResult[$arParams["META_DESCRIPTION"]]))
{
	$val = $arResult[$arParams["META_DESCRIPTION"]];
	if(is_array($val))
		$val = implode(" ", $val);
	$APPLICATION->SetPageProperty("description", $val);
}

if($arParams["SET_TITLE"])
	$APPLICATION->SetTitle($arResult["NAME"], $arTitleOptions);

if(isset($arResult[$arParams["BROWSER_TITLE"]]))
{
	$val = $arResult[$arParams["BROWSER_TITLE"]];
	if(is_array($val))
		$val = implode(" ", $val);
	$APPLICATION->SetPageProperty("pagetitle", $val, $arTitleOptions);
}

?>
