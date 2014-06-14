<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?><?

$arParams["SEF_MODE"] = $arParams["SEF_MODE"] == "N" ? "N" : "Y" ;
$arParams["CACHE_TIME"] = isset($arParams["CACHE_TIME"])?intval($arParams["CACHE_TIME"]):600;
$arParams["IBLOCK_FEATURE_TYPE"] = "models";
$arParams["IBLOCK_FEATURE_CODE"] = "param";
$arParams["IBLOCK_MODEL_CODE"] = "models";
$arParams["IBLOCK_PHOTO_CODE"] = "photo";
$arParams["IBLOCK_VIDEO_CODE"] = "video";
$arParams["IBLOCK_VIEW360_CODE"] = "view360";
$arParams["IBLOCK_PRESENTATION_CODE"] = "presentation";

$arDefaultUrlTemplates404 = array(
      "model_index" => "#RANGE_CODE#/#MODEL_ID#/"
	, "model_media" => "#RANGE_CODE#/#MODEL_ID#/media/"
	, "model_view360" => "#RANGE_CODE#/#MODEL_ID#/#FEATURE_SECTION_CODE#/view360/"
	, "feature_list" => "#RANGE_CODE#/#MODEL_ID#/#FEATURE_SECTION_CODE#/"
	, "feature_detail" => "#RANGE_CODE#/#MODEL_ID#/#FEATURE_SECTION_CODE#/#FEATURE_CODE#/"
	, "feature_presentation" => "#RANGE_CODE#/#MODEL_ID#/#FEATURE_SECTION_CODE#/#FEATURE_CODE#/presentation/"
);
$arDefaultVariableAliases404 = array();
$arDefaultVariableAliases = array();
$arComponentVariables = array("RANGE_CODE", "MODEL_ID", "FEATURE_SECTION_CODE", "FEATURE_CODE");

$SEF_FOLDER = "";
$arUrlTemplates = array();

if (!CModule::IncludeModule("iblock"))
{
	return false;
}

if ($arParams["SEF_MODE"] == "Y")
{
	$arVariables = array();
	$arUrlTemplates = CComponentEngine::MakeComponentUrlTemplates($arDefaultUrlTemplates404, $arParams["SEF_URL_TEMPLATES"]);
	$arVariableAliases = CComponentEngine::MakeComponentVariableAliases($arDefaultVariableAliases404, $arParams["VARIABLE_ALIASES"]);
	
	$componentPage = CComponentEngine::ParseComponentPath(
		$arParams["SEF_FOLDER"],
		$arUrlTemplates,
		$arVariables
	);
	
	if (StrLen($componentPage) <= 0)
	{
		$componentPage = "404";
	}
	
	CComponentEngine::InitComponentVariables($componentPage, 
		$arComponentVariables, 
		$arVariableAliases, 
		$arVariables
	);
	
	$SEF_FOLDER = $arParams["SEF_FOLDER"];
}
else
{
	$arVariables = array();
	
	$arVariableAliases = CComponentEngine::MakeComponentVariableAliases($arDefaultVariableAliases, $arParams["VARIABLE_ALIASES"]);
	CComponentEngine::InitComponentVariables(false, $arComponentVariables, $arVariableAliases, $arVariables);
	
	$componentPage = "";
	if (IntVal($arVariables["MODEL_ID"]) > 0)
	{
		$componentPage = "index";
	}
	else
	{
		$componentPage = "404";
	}
}


$CACHE_ID = md5(serialize(array(
	$arVariables
)));
$objPHPCache = new CPHPCache;
if($objPHPCache->StartDataCache($arParams["CACHE_TIME"], $CACHE_ID))
{
	
	/**
	 * Получим ID ИБ "Особенности"
	 */
	$arOrder = array();
	$arFilter = array("CODE" => $arParams['IBLOCK_FEATURE_CODE'], "TYPE" => $arParams['IBLOCK_FEATURE_TYPE']);
	$rsIBlock = CIBlock::GetList($arOrder, $arFilter);
	if ($rsIBlock && $arIBlock = $rsIBlock->Fetch()) 
	{
		$arFeatureIBlock = $arIBlock;
	}
	else 
	{
		ShowError("Не удалось получить ИБ \"Особенности\"");
	}

	/**
	 * Получим секцию первого уровня ИБ "Особенности"
	 */
	if ($arVariables['MODEL_ID'] && is_array($arFeatureIBlock))
	{
		$arOrder = array();
		$arFilter = array(
			  "CODE"		=>	$arVariables['MODEL_ID']
			, "DEPTH_LEVEL"	=>	1
			, "IBLOCK_ID"	=>	$arFeatureIBlock['ID']
		);
			
		$rsSectionList = CIBlockSection::GetList($arOrder, $arFilter, false, array("UF_*"));
		if ($rsSectionList && $arSection = $rsSectionList->GetNext())
		{
			$arRangeSection = $arSection;
		}
		else 
		{
			ShowError("Не удалось получить раздел серии");
		}
	}
	
	/**
	 * Получим подсекцию ИБ "Особенностей"
	 */
	if ($arVariables["FEATURE_SECTION_CODE"] && is_array($arRangeSection))
	{
		$arOrder = array();
		$arFilter = array
		(
			  "GLOBAL_ACTIVE"	=>	"Y"
			, "CODE"			=>	$arVariables["FEATURE_SECTION_CODE"]
			, "SECTION_ID"		=>	$arRangeSection['ID']
			, "DEPTH_LEVEL"		=>	2
			, "IBLOCK_ID"		=>	$arFeatureIBlock['ID']
		);
		$rsSectionList = CIBlockSection::GetList($arOrder, $arFilter, false, array("UF_*"));
		if ($rsSectionList && $arSection = $rsSectionList->GetNext())
		{
			// картинко
			$arSection['PICTURE_SRC'] = CFile::GetPath($arSection['PICTURE']); 
			// цвет текста
			$rsColorPropValue = CUserFieldEnum::GetList(
				array(), 
				array('ID' => $arSection["UF_TITLE_COLOR"])
			);
			if ($rsColorPropValue && $arColorPropValue = $rsColorPropValue->Fetch())
			{
				$arColorPropValue['XML_ID'] = str_replace("#", "", $arColorPropValue['XML_ID']);
				$arResult["FEATURE_SECTION"]["UF_TOP_MARGIN"] = intval($arResult["FEATURE_SECTION"]["UF_TOP_MARGIN"]);
				$arResult["FEATURE_SECTION"]["UF_LEFT_MARGIN"] = intval($arResult["FEATURE_SECTION"]["UF_LEFT_MARGIN"]);
				$arSection['UF_TITLE_COLOR'] = $arColorPropValue;
			}
			$arFeatureSection = $arSection;
		}
		else 
		{
			ShowError("Не удалось получить раздел с параметрами");
		}
	}
	
	

	
    $objPHPCache->EndDataCache(Array(
    	  "arRangeSection" => $arRangeSection
    	, "arFeatureSection" => $arFeatureSection
    	, "arFeatureIBlock" => $arFeatureIBlock
    ));
}
else
{
    $arVars = $objPHPCache->GetVars();
	$arRangeSection = $arVars["arRangeSection"];
	$arFeatureSection = $arVars["arFeatureSection"];
}




$arResult = array
(
	"FOLDER" => $SEF_FOLDER,
	"URL_TEMPLATES" => $arUrlTemplates,
	"VARIABLES" => $arVariables,
	"ALIASES" => $arVariableAliases,
	
	"RANGE_SECTION" => $arRangeSection,
	"FEATURE_SECTION" => $arFeatureSection,
	"FEATURE_IBLOCK" => $arFeatureIBlock,
	"TITLE_COLOR" => $arColorPropValue['XML_ID']
);

$this->IncludeComponentTemplate($componentPage);
?>