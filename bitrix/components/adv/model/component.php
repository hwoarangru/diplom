<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?><?

$arParams["SEF_MODE"] = $arParams["SEF_MODE"] == "N" ? "N" : "Y" ;
$arParams["CACHE_TIME"] = isset($arParams["CACHE_TIME"])?intval($arParams["CACHE_TIME"]):86400;
$arParams["IBLOCK_FEATURE_TYPE"] = "models";
$arParams["IBLOCK_FEATURE_CODE"] = "param";
$arParams["IBLOCK_MODEL_CODE"] = "models";
$arParams["IBLOCK_PHOTO_CODE"] = "photo";
$arParams["IBLOCK_VIDEO_CODE"] = "video";
$arParams["IBLOCK_VIEW360_CODE"] = "view360";
//$arParams["IBLOCK_PRESENTATION_CODE"] = "presentation";

$arDefaultUrlTemplates404 = array(
      "model_index" => "#RANGE_CODE#/#MODEL_ID#/"
	, "model_media" => "#RANGE_CODE#/#MODEL_ID#/media/"
	, "model_view360" => "#RANGE_CODE#/#MODEL_ID#/#FEATURE_SECTION_CODE#/view360/"
	, "feature_list" => "#RANGE_CODE#/#MODEL_ID#/#FEATURE_SECTION_CODE#/"
	, "feature_detail" => "#RANGE_CODE#/#MODEL_ID#/#FEATURE_SECTION_CODE#/#FEATURE_CODE#/"
	//, "feature_presentation" => "#RANGE_CODE#/#MODEL_ID#/#FEATURE_SECTION_CODE#/#FEATURE_CODE#/presentation/"
        , "technical" => "#RANGE_CODE#/#MODEL_ID#/tech_character/"
);
$arDefaultVariableAliases404 = array();
$arDefaultVariableAliases = array();
$arComponentVariables = array("RANGE_CODE", "MODEL_ID", "FEATURE_SECTION_CODE", "FEATURE_CODE");

$SEF_FOLDER = "";
$arUrlTemplates = array();

$full_title = "";

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
		define("ERROR_404","Y");
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
		define("ERROR_404","Y");
		$componentPage = "404";
	}
}

$CACHE_ID = md5(serialize(array(
	$arVariables,
	"model" //соль
)));
$objPHPCache = new CPHPCache;

if($objPHPCache->StartDataCache($arParams["CACHE_TIME"], $CACHE_ID))
{

	if (preg_match('/[A-Za-z]/', $arVariables['MODEL_ID']))
	{
		$arVariables['CODE'] = $arVariables['MODEL_ID'];
		$arFilter = Array('IBLOCK_ID' => 192, 'CODE' => $arVariables['MODEL_ID']);
		$db_list = CIBlockElement::GetList(Array('sort'=>'asc'), $arFilter, false, false, array("ID", "NAME", "CODE", "PROPERTY_FEATURE", "PROPERTY_IS_BLACK_STYLE", "PROPERTY_TTX", "PROPERTY_DESCRIPTION", "PROPERTY_KEYWORDS", "PROPERTY_PAGETITLE", "PROPERTY_SHOW_BANNER_EFF"));
		$_ = $db_list->GetNext();
		$arVariables['CODE'] = $_['CODE'];
		$arVariables['MODEL_ID'] = $_['ID'];
		$arVariables['PROPERTY_FEATURE_VALUE'] = $_['PROPERTY_FEATURE_VALUE'];
		$arVariables['MORE_PROPS'] = $_['PROPERTY_IS_BLACK_STYLE_VALUE'];
		$arVariables['TTX'] = $_['PROPERTY_TTX_VALUE'];
		$arVariables['NAME'] = $_['NAME'];
		$arVariables['DESCRIPTION'] = $_['PROPERTY_DESCRIPTION_VALUE'];
		$arVariables['KEYWORDS'] = $_['PROPERTY_KEYWORDS_VALUE'];
		$arVariables['PAGETITLE'] = $_['PROPERTY_PAGETITLE_VALUE'];
		$arVariables['SHOW_BANNER_EFF'] = $_['PROPERTY_SHOW_BANNER_EFF_VALUE'];
		
		/*$arMoreProps = array();
		$res = CIBlockElement::GetList(array("SORT"=>"ASC"),array("IBLOCK_CODE"=>"models_more","CODE"=>$arVariables['CODE']),false,false,array());
		while ($arRes = $res->GetNextElement()) {
			$arMoreProps = $arRes->GetProperties();
		}*/
	}
	
	$objPHPCache->EndDataCache(Array(
		"props" => $props,
		"arVariables" => $arVariables
	));
}
else
{
	$arVars = $objPHPCache->GetVars();
	$props = $arVars["props"];
	$arVariables = $arVars["arVariables"];
}


if('tech_character' == $arVariables['FEATURE_SECTION_CODE'])
{
	$CACHE_ID = md5(serialize(array(
		$arVariables,
		"tech_character" //соль
	)));
	$objPHPCache = new CPHPCache;

	if($objPHPCache->StartDataCache($arParams["CACHE_TIME"], $CACHE_ID))
	{
		//получаем ID ИБ technical_character чтобы вытащить UF_
		$res = CIBlock::GetList(Array(),Array("CODE"=>'technical_character'), false);
		if($ar_res = $res->GetNext())
		{
			$arResult["IBLOCK_ID"]=$ar_res["ID"];
		
		
			//получаем значения фона и сео из раздела (модели)
			$arFilter = Array("IBLOCK_ID" => $ar_res["ID"], "ID" => $arVariables['TTX'], "ACTIVE"=>"Y");
			$db_section = CIBlockSection::GetList(Array(), $arFilter, false, array("UF_TITLE", "UF_KEYWORDS", "UF_DESCRIPTION", "PICTURE", "DESCRIPTION"));
			if($section = $db_section->GetNext())
			{
				$arResult["TEXT"] = $section["DESCRIPTION"];
				$arResult["TITLE"] = $section["UF_TITLE"];
				$arResult["DESCRIPTION"] = $section["UF_DESCRIPTION"];
				$arResult["KEYWORDS"] = $section["UF_KEYWORDS"];
				$arResult["FON"] = CFile::GetPath($section["PICTURE"]);
			
				//получаем характеристики из модификаций
				$arOrder = array("SORT"=>"ASC");
				$arFilter = array(
				  "IBLOCK_CODE" => "technical_character",
				  "SECTION_ID" => $arVariables['TTX'],
				  "ACTIVE" => "Y"
				);
				$rsIBlockElementList = CIBlockElement::GetList($arOrder, $arFilter);
				while($objIBlockElement2 = $rsIBlockElementList->GetNextElement())
				{
					$arIBlockElement = array
					(
						  'FIELDS' => $objIBlockElement2->GetFields()
						, 'PROPS' => $objIBlockElement2->GetProperties()
					);
					$arIBlockElement['PROPS']['NAME']=$arIBlockElement['FIELDS']['NAME'];
					$arIBlockElement_f['DETAIL_PICTURE']=CFile::GetPath($arIBlockElement['FIELDS']['DETAIL_PICTURE']);
					$arIBlockElement_f['PREVIEW_PICTURE'] = CFile::GetPath($arIBlockElement['FIELDS']['PREVIEW_PICTURE']);
					$arResult['technical'][] = $arIBlockElement['PROPS'];
					$arResult['technical_fields'][] = $arIBlockElement_f;
				}
			}
			
		}
			
			

		$arResult["MORE_PROPS"] = $arVariables['MORE_PROPS'];//темный шаблон?
		$arResult['NAME'] = $arVariables['NAME'];
		$objPHPCache->EndDataCache(Array(
			"arResult" => $arResult
		));
	}
	else
	{
		$arVars = $objPHPCache->GetVars();
		$arResult = $arVars["arResult"];
	}
	
	if($arResult['DESCRIPTION'])
	{
		$APPLICATION->SetPageProperty("description", $arResult['DESCRIPTION']);
	}
	
	if($arResult['KEYWORDS'])
	{
		$APPLICATION->SetPageProperty("keywords", $arResult['KEYWORDS']);
	}
	
	
	if($arResult['TITLE'])
	{
		$APPLICATION->SetPageProperty("pagetitle", $arResult['TITLE']);
	}
	else
	{
		$APPLICATION->SetPageProperty("pagetitle", "Технические характеристики - " . $arResult['NAME'] . " - официальный дилер Независимость BMW" );
	}

	
	$this->IncludeComponentTemplate($arVariables['FEATURE_SECTION_CODE']);
	return;
}

$CACHE_ID = md5(serialize(array(
	$arVariables,
	"main"  //соль
)));
$objPHPCache = new CPHPCache;
if($objPHPCache->StartDataCache($arParams["CACHE_TIME"], $CACHE_ID))
{
	
	/**
	 * Получим ID ИБ "Особенности" чтобы вытащить UF_
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
		if($arVariables['PROPERTY_FEATURE_VALUE'])
		{
			$arOrder = array();
			$arFilter = array(
				  "ID"	=>	$arVariables['PROPERTY_FEATURE_VALUE']
				, "DEPTH_LEVEL"	=>	1
				, "IBLOCK_ID"	=>	$arFeatureIBlock['ID']
			);
		}
		elseif($arVariables['MODEL_ID'])
		{
			$arOrder = array();
			$arFilter = array(
				  "CODE"	=>	$arVariables['MODEL_ID']
				, "DEPTH_LEVEL"	=>	1
				, "IBLOCK_ID"	=>	$arFeatureIBlock['ID']
			);
		}
		$rsSectionList = CIBlockSection::GetList($arOrder, $arFilter, false, array("UF_*"));
		if ($rsSectionList && $arSection = $rsSectionList->GetNext())
		{
			$arRangeSection = $arSection;
			$full_title .= $arRangeSection['NAME']." - ";
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
				$full_title .= $arFeatureSection['NAME']." - ";
			}
			else 
			{
				ShowError("Не удалось получить раздел с параметрами");
				@define("ERROR_404", "Y");
				CHTTP::SetStatus("404 Not Found");
				
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
	"TITLE_COLOR" => $arColorPropValue['XML_ID'],
	"MORE_PROPS" => $arVariables['MORE_PROPS']
);

$_DirTitle = "Модельный ряд BMW, каталог автомобилей BMW - официальный дилер Независимость BMW";


if($arVariables['PAGETITLE'])
{
	$_DirTitle = $arVariables['PAGETITLE'];
	$full_title="";
}
elseif($arVariables['NAME'])
{
	$_DirTitle = $arVariables['NAME']." - ".$_DirTitle;
	$full_title="";
}
$APPLICATION->SetPageProperty("modeltitle", $arVariables['NAME']);
$APPLICATION->SetPageProperty("pagetitle", $_DirTitle);

if($full_title)
{
	$APPLICATION->SetPageProperty("full_title", "Модельный ряд- ".$full_title);	
}

$this->IncludeComponentTemplate($componentPage);
?>