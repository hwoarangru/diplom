<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();?>
<?if (!CModule::IncludeModule("iblock"))
{
    return false;
}

global $APPLICATION;
$arParams["IS_SEF"] = 'Y';
$arParams["SEF_BASE_URL"] = '/cars/';
$arParams['DefaultUrlTemplates404'] = array(
    "model_index" => "#RANGE_CODE#/#MODEL_ID#/"
    , "model_media" => "#RANGE_CODE#/#MODEL_ID#/media/"
    , "feature_list" => "#RANGE_CODE#/#MODEL_ID#/#FEATURE_SECTION_CODE#/"
    , "feature_detail" => "#RANGE_CODE#/#MODEL_ID#/#FEATURE_SECTION_CODE#/#FEATURE_CODE#/"
    //, "feature_presentation" => "#RANGE_CODE#/#MODEL_ID#/#FEATURE_SECTION_CODE#/#FEATURE_CODE#/presentation/"
    , "technical_character" => "#RANGE_CODE#/#MODEL_ID#/tech_character/"
);
$arParams["CACHE_TIME"] = 86400;
$arParams["IBLOCK_ID"] = ADV_IBLOCK_PARAM_ID;
$arParams["IBLOCK_FEATURE_TYPE"] = "models";
$arParams["IBLOCK_FEATURE_CODE"] = "param";
$arParams["IBLOCK_MODEL_CODE"] = "models";
$arParams["IBLOCK_PHOTO_CODE"] = "photo";
$arParams["IBLOCK_VIDEO_CODE"] = "video";
$arParams["IBLOCK_PRESENTATION_CODE"] = "presentation";


//if($arParams["IS_SEF"] === "Y")
//{
$componentPage = CComponentEngine::ParseComponentPath(
                $arParams["SEF_BASE_URL"], $arParams['DefaultUrlTemplates404'], $arVariables
);
CComponentEngine::InitComponentVariables(
        $componentPage, array("RANGE_CODE", "MODEL_ID"), $arParams['DefaultUrlTemplates404'], $arVariables
);
//}


if ($componentPage == 'feature_presentation')
{
    return array();
}



$aMenuLinksExt = array();

$CACHE_ID = md5(serialize(array(
            __FILE__,
            $arParams,
            $arVariables,
			"left_menu" //соль
        )));
$obMenuCache = new CPHPCache;
if ($obMenuCache->StartDataCache($arParams["CACHE_TIME"], $CACHE_ID))
{
	$gallery_name = '';
	$show_under = false;
	if (preg_match('/[A-Za-z]/', $arVariables['MODEL_ID']))
	{
		$arFilter = Array('IBLOCK_ID' => 192, 'CODE' => $arVariables['MODEL_ID']);
		$db_list = CIBlockElement::GetList(Array('sort'=>'asc'), $arFilter, false, false, array("CODE", "ID", "PROPERTY_GALLERY", "PROPERTY_FEATURE", "PROPERTY_SHOW_MEDIA_UNDER_TEC", "PROPERTY_NAME_MEDIA_FOR_MENU", "PROPERTY_SHOW_MAIN", "PROPERTY_TTX", "IBLOCK_SECTION_ID"));
		$db_res = $db_list->GetNext();
		   $arVariables['CODE'] = $arVariables['MODEL_ID'];
		$model = $arVariables['MODEL_ID'] = $db_res['ID'];
		$model_photo = $db_res['PROPERTY_GALLERY_VALUE']; //есть ли прив€зка к фото
		$model_video = $db_res['PROPERTY_GALLERY_VALUE']; //есть ли прив€зка к видео
		$model_feature = $db_res['PROPERTY_FEATURE_VALUE']; //есть ли прив€зка к особенност€м
		$model_ttx = $db_res['PROPERTY_TTX_VALUE']; //есть ли технические хар-ки
		$show_main = $db_res['PROPERTY_SHOW_MAIN_VALUE']; //показывать ли "главна€"
		$section_code = $db_res["IBLOCK_SECTION_ID"];
		if($show_main=='Y')
		{
			$dir = explode("/", $APPLICATION->GetCurDir());
			$section_code_m = $dir[2];
		}
		if($db_res['CODE'] != '')
		{
			$model = $db_res['CODE'];
			$model_code = $db_res['CODE'];
			$model_id = $db_res['ID'];
			
			if($db_res["PROPERTY_NAME_MEDIA_FOR_MENU_VALUE"])
			{
				$gallery_name = $db_res["PROPERTY_NAME_MEDIA_FOR_MENU_VALUE"];
			}
			if ($db_res["PROPERTY_SHOW_MEDIA_UNDER_TEC_VALUE"])
			{
				$show_under = true;
			}
		}
	}



	if(!$model_feature)
	{
		$arSections = array();
		/**
		 * ѕолучим секцию первого уровн€ »Ѕ "ќсобенности"
		 */
		$arOrder = array();
		$arFilter = array(
			"CODE" => $arVariables['MODEL_ID']
			, "DEPTH_LEVEL" => 1
			, "IBLOCK_CODE" => $arParams['IBLOCK_FEATURE_CODE']
			, "IBLOCK_TYPE" => $arParams['IBLOCK_FEATURE_TYPE']
		);

		$rsRangeSectionList = CIBlockSection::GetList($arOrder, $arFilter, false, array("ID"));
		if ($rsRangeSectionList && $arRangeSection = $rsRangeSectionList->GetNext())
		{
			$feature_section=$arRangeSection['ID'];
		}
	}
	else
	{
		$feature_section=$model_feature;
	}
	/**
	 * ѕолучим "особенности"
	 */
	$arOrder = array(
		'SORT' => 'ASC'
		, 'NAME' => 'ASC'
	);
	$arFilter = array(
		"ACTIVE" => "Y"
		, "SECTION_ID" => $feature_section
		, "DEPTH_LEVEL" => 2
		, "IBLOCK_ID" => $arParams["IBLOCK_ID"]
	);

	$rsSectionList = CIBlockSection::GetList($arOrder, $arFilter, false, array("ID", "DEPTH_LEVEL", "NAME", "SECTION_PAGE_URL", "UF_OPEN"));
	while ($rsSectionList && $arSection = $rsSectionList->GetNext())
	{
		if($arSection["UF_OPEN"])
		{
			$arOrder = array("SORT" => "ASC");
			$arFilter = array(
			"SECTION_ID" => $arSection["ID"]
			, "ACTIVE" => "Y"
			, "IBLOCK_ID" => $arParams["IBLOCK_ID"]
			);
			$rsIBlockElementList = CIBlockElement::GetList($arOrder, $arFilter);
			if($IBlockElement = $rsIBlockElementList->GetNext())
			{
				$arSection["~SECTION_PAGE_URL"] = $arSection["~SECTION_PAGE_URL"].$IBlockElement["CODE"]."/";
			}
		}
		$arSections[] = array
			(
			"ID" => $arSection["ID"]
			, "DEPTH_LEVEL" => $arSection["DEPTH_LEVEL"]
			, "~NAME" => $arSection["~NAME"]
			, "~SECTION_PAGE_URL" => str_replace
					(
					array("#RANGE_CODE#", "#MODEL_ID#")
					, array($arVariables['RANGE_CODE'], $model)
					, $arSection["~SECTION_PAGE_URL"]
			)
		);
	}



    /**
     * ѕроверим есть ли изображени€
     */
	
   /* $bPhoto = false;
    $arOrder = array("SORT" => "ASC", "NAME" => "ASC");
    $arFilter = array("ID" => $arVariables['MODEL_ID'], 'IBLOCK_CODE' => $arParams['IBLOCK_MODEL_CODE']);
    $arSelect = array('ID', 'PROPERTY_GALLERY');
    $rsIBlockElementList = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);

    if ($rsIBlockElementList && $arModel = $rsIBlockElementList->Fetch())
    {
        if ($arModel['PROPERTY_GALLERY_VALUE'])*/
		if($model_photo)
        {
            $arOrder = array("SORT" => "ASC", "NAME" => "ASC");
            $arFilter = array(
                "IBLOCK_CODE" => $arParams["IBLOCK_PHOTO_CODE"]
                , "SECTION_ID" => $model_photo
                , "ACTIVE" => "Y"
            );
            $rsIBlockElementList = CIBlockElement::GetList($arOrder, $arFilter, false, Array("nPageSize"=>1), array("ID"));
            $iPhotoCnt = intval($rsIBlockElementList->SelectedRowsCount());
            $bPhoto = (bool) $iPhotoCnt;
        }
    //}

    /**
     * ѕроверим есть ли видео
     */
    $bVideo = false;
    $arOrder = array();
    $arFilter = array(
        "IBLOCK_CODE" => $arParams["IBLOCK_VIDEO_CODE"]
        , "IBLOCK_TYPE" => $arParams["IBLOCK_FEATURE_TYPE"]
        , "PROPERTY_MODEL_ID" => $arVariables['MODEL_ID']
        , "ACTIVE" => "Y"
    );

    $rsIBlockElementList = CIBlockElement::GetList($arOrder, $arFilter, false, false, array("PROPERTY_FILE_IMG_ID", "NAME"));
    if ($rsIBlockElementList && $objIBlockElement = $rsIBlockElementList->GetNextElement())
    {
        $bVideo = true;
        $arFelds = $objIBlockElement->GetFields();
        //$arPropFILE_IMG = $objIBlockElement->GetProperty('FILE_IMG_ID');
        //if ($arPropFILE_IMG['VALUE'])
		if($arFelds['PROPERTY_FILE_IMG_ID_VALUE'])
        {
            $arVideoItem = array(
                'IMG' => CFile::GetFileArray($arFelds['PROPERTY_FILE_IMG_ID_VALUE'])
                , 'NAME' => $arFelds['NAME']
                //, 'CNT' => $iPhotoCnt
            );
        }
    }

    $obMenuCache->EndDataCache(Array(
        "arSections" => $arSections
        , 'bPhoto' => $bPhoto
        , 'bVideo' => $bVideo
        , 'arVideoItem' => $arVideoItem
        , 'arVariables' => $arVariables
		, 'gallery_name' => $gallery_name
		, 'show_under' => $show_under
		, 'show_main' => $show_main
		, 'model' => $model
		, 'model_ttx' => $model_ttx
		, 'section_code' => $section_code
		, 'section_code_m' => $section_code_m
    ));
}
else
{
    $arVars = $obMenuCache->GetVars();
    $arSections = $arVars["arSections"];
    $bPhoto = $arVars["bPhoto"];
    $bVideo = $arVars["bVideo"];
    $arVideoItem = $arVars["arVideoItem"];
    $arVariables = $arVars["arVariables"];
	$gallery_name = $arVars["gallery_name"];
	$show_under = $arVars["show_under"];
	$show_main = $arVars["show_main"];
	$model = $arVars["model"];
	$model_ttx = $arVars["model_ttx"];
	$section_code = $arVars["section_code"];
	$section_code_m = $arVars["section_code_m"];
}

//new dBug($arElementLinks);

$menuIndex = 0;
$previousDepthLevel = 1;

if($show_main=="Y")
{
	$aMenuLinksExt[$menuIndex++] = array
        (
        '√лавна€',
        '/cars/'.$section_code_m.'/'.$model_code.'/',
        array(),
        array
            (
            "FROM_IBLOCK" => true,
            "IS_PARENT" => false,
            "DEPTH_LEVEL" => 1,
        ),
    );
}


foreach ($arSections as $arSection)
    {
    if ($menuIndex > 0)
        $aMenuLinksExt[$menuIndex - 1][3]["IS_PARENT"] = $arSection["DEPTH_LEVEL"] > $previousDepthLevel;
    $previousDepthLevel = $arSection["DEPTH_LEVEL"];
    $aMenuLinksExt[$menuIndex++] = array
        (
        $arSection["~NAME"],
        $arSection["~SECTION_PAGE_URL"],
        array(),
        array
            (
            "FROM_IBLOCK" => true,
            "IS_PARENT" => false,
            "DEPTH_LEVEL" => $arSection["DEPTH_LEVEL"],
        ),
    );
    }













 if (!$show_under) {   
	if ($bPhoto || $bVideo)
		{

		$ar = array();
		if ($bPhoto)
			$ar[] = "изображени€";
		if ($bVideo)
			$ar[] = "видеоролики";
		$strTitle = implode(" и ", $ar);
		$strTitle = ToUpper($strTitle[0]) . substr($strTitle, 1);
		if ($gallery_name) $strTitle = $gallery_name;

		$arItemParams = array
			(
			"FROM_IBLOCK" => false
			, "IS_PARENT" => false
			, "DEPTH_LEVEL" => 1
		);
		if (is_array($arVideoItem))
		{
			$arItemParams['IMG'] = $arVideoItem['IMG'];
			$arItemParams['LINK'] = $arParams["SEF_BASE_URL"] . str_replace(
							array("#RANGE_CODE#", "#MODEL_ID#")
							, array($arVariables['RANGE_CODE'], $model)
							, $arParams['DefaultUrlTemplates404']["model_media"]
					) . '?media_id=mediaID-' . $arVideoItem['CNT'];
			$arItemParams['NAME'] = $arVideoItem['NAME'];
		}
		else
		{
			//попробуем найти блок под левое меню в элементе
			$arOrder = array("SORT" => "ASC", "NAME" => "ASC");
			$arFilter = array("ID" => $model, 'IBLOCK_CODE' => $arParams['IBLOCK_MODEL_CODE']);
			$arSelect = array('ID', 'PROPERTY_MENU_PIC', 'PROPERTY_MENU_SLOGAN', 'PROPERTY_MENU_LINKTEXT', 'PROPERTY_MENU_UNDERLINK',);
			$rsIBlockElementList = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);
			if ($rsIBlockElementList && $arModel = $rsIBlockElementList->Fetch())
			{
				$arItemParams['IMG'] = CFile::GetFileArray($arModel['PROPERTY_MENU_PIC_VALUE']);
				$arItemParams['LINK'] = $arModel['PROPERTY_MENU_UNDERLINK_VALUE'];
				$arItemParams['NAME'] = $arModel['PROPERTY_MENU_SLOGAN_VALUE'];
				$arItemParams['TEXTLINK'] = $arModel['PROPERTY_MENU_LINKTEXT_VALUE'];
			}
		}

		$aMenuLinksExt[$menuIndex++] = array

			(
			$strTitle,
			$arParams["SEF_BASE_URL"] . str_replace(
					array("#RANGE_CODE#", "#MODEL_ID#")
					, array($arVariables['RANGE_CODE'], $model)
					, $arParams['DefaultUrlTemplates404']["model_media"]

			),
			array(),
			$arItemParams,



		);
	}
}
   

     /**
     * ѕроверим есть ли технические хар-ки
     */
	if($model_ttx)
	{
		$arItemParams = array
        (
        "FROM_IBLOCK" => false
        , "IS_PARENT" => false
        , "DEPTH_LEVEL" => 1
		);
        
        $aMenuLinksExt[$menuIndex++] = array
            (
            '“ехнические характеристики',
            $arParams["SEF_BASE_URL"] . str_replace(
                    array("#RANGE_CODE#", "#MODEL_ID#")
                    , array($arVariables['RANGE_CODE'], $model)
                    , $arParams['DefaultUrlTemplates404']["technical_character"]
            ),
            array(),
            $arItemParams,
        );
	}
    
if ($show_under) {   
	if ($bPhoto || $bVideo)
		{

		$ar = array();
		if ($bPhoto)
			$ar[] = "изображени€";
		if ($bVideo)
			$ar[] = "видеоролики";
		$strTitle = implode(" и ", $ar);
		$strTitle = ToUpper($strTitle[0]) . substr($strTitle, 1);
		if ($gallery_name) $strTitle = $gallery_name;

		$arItemParams = array
			(
			"FROM_IBLOCK" => false
			, "IS_PARENT" => false
			, "DEPTH_LEVEL" => 1
		);
		if (is_array($arVideoItem))
		{
			$arItemParams['IMG'] = $arVideoItem['IMG'];
			$arItemParams['LINK'] = $arParams["SEF_BASE_URL"] . str_replace(
							array("#RANGE_CODE#", "#MODEL_ID#")
							, array($arVariables['RANGE_CODE'], $model)
							, $arParams['DefaultUrlTemplates404']["model_media"]
					) . '?media_id=mediaID-' . $arVideoItem['CNT'];
			$arItemParams['NAME'] = $arVideoItem['NAME'];
		}
		else
		{
			//попробуем найти блок под левое меню в элементе
			$arOrder = array("SORT" => "ASC", "NAME" => "ASC");
			$arFilter = array("ID" => $model, 'IBLOCK_CODE' => $arParams['IBLOCK_MODEL_CODE']);
			$arSelect = array('ID', 'PROPERTY_MENU_PIC', 'PROPERTY_MENU_SLOGAN', 'PROPERTY_MENU_LINKTEXT', 'PROPERTY_MENU_UNDERLINK',);
			$rsIBlockElementList = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);
			if ($rsIBlockElementList && $arModel = $rsIBlockElementList->Fetch())
			{
				$arItemParams['IMG'] = CFile::GetFileArray($arModel['PROPERTY_MENU_PIC_VALUE']);
				$arItemParams['LINK'] = $arModel['PROPERTY_MENU_UNDERLINK_VALUE'];
				$arItemParams['NAME'] = $arModel['PROPERTY_MENU_SLOGAN_VALUE'];
				$arItemParams['TEXTLINK'] = $arModel['PROPERTY_MENU_LINKTEXT_VALUE'];
			}
		}

		$aMenuLinksExt[$menuIndex++] = array
			(
			$strTitle,
			$arParams["SEF_BASE_URL"] . str_replace(
					array("#RANGE_CODE#", "#MODEL_ID#")
					, array($arVariables['RANGE_CODE'], $model)
					, $arParams['DefaultUrlTemplates404']["model_media"]
			),
			array(),
			$arItemParams,
		);
	}
}
    


//new dBug($aMenuLinksExt);
//print_r($aMenuLinks);
$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
/*
  echo '<pre>';
  print_r($aMenuLinks);
  echo '</pre>';
 */
?>