<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die(); ?><?

if (!CModule::IncludeModule("iblock"))
    {
    return false;
    }

global $APPLICATION;

$arParams["IS_SEF"] = 'Y';
$arParams["SEF_BASE_URL"] = '/model/';
$arParams['DefaultUrlTemplates404'] = array(
    "model_index" => "#RANGE_CODE#/#MODEL_ID#/"
    , "model_media" => "#RANGE_CODE#/#MODEL_ID#/media/"
    , "feature_list" => "#RANGE_CODE#/#MODEL_ID#/#FEATURE_SECTION_CODE#/"
    , "feature_detail" => "#RANGE_CODE#/#MODEL_ID#/#FEATURE_SECTION_CODE#/#FEATURE_CODE#/"
    , "feature_presentation" => "#RANGE_CODE#/#MODEL_ID#/#FEATURE_SECTION_CODE#/#FEATURE_CODE#/presentation/"
    , "technical_character" => "#RANGE_CODE#/#MODEL_ID#/tech_character/"
);

$arParams["CACHE_TIME"] = 3600;
$arParams["IBLOCK_ID"] = ADV_IBLOCK_PARAM_ID;
$arParams["IBLOCK_FEATURE_TYPE"] = "models";
$arParams["IBLOCK_FEATURE_CODE"] = "param";
$arParams["IBLOCK_MODEL_CODE"] = "models";
$arParams["IBLOCK_PHOTO_CODE"] = "photo";
$arParams["IBLOCK_VIDEO_CODE"] = "video";
$arParams["IBLOCK_PRESENTATION_CODE"] = "presentation";

$arParams["RANDOM"] = 'asaggdddsssd';

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
            $arVariables
        )));
$obMenuCache = new CPHPCache;
if ($obMenuCache->StartDataCache($arParams["CACHE_TIME"], $CACHE_ID))
    {

    $arSections = array();
    /**
     * Получим секцию первого уровня ИБ "Особенности"
     */
    $arOrder = array();
    $arFilter = array(
        "CODE" => $arVariables['MODEL_ID']
        , "DEPTH_LEVEL" => 1
        , "IBLOCK_CODE" => $arParams['IBLOCK_FEATURE_CODE']
        , "IBLOCK_TYPE" => $arParams['IBLOCK_FEATURE_TYPE']
    );

    $rsRangeSectionList = CIBlockSection::GetList($arOrder, $arFilter);
    if ($rsRangeSectionList && $arRangeSection = $rsRangeSectionList->GetNext())
        {
        /**
         * Получим "особенности"
         */
        $arOrder = array(
            'SORT' => 'ASC'
            , 'NAME' => 'ASC'
        );
        $arFilter = array(
            "ACTIVE" => "Y"
            , "SECTION_ID" => $arRangeSection['ID']
            , "DEPTH_LEVEL" => 2
            , "IBLOCK_ID" => $arRangeSection['IBLOCK_ID']
        );

        $rsSectionList = CIBlockSection::GetList($arOrder, $arFilter);
        while ($rsSectionList && $arSection = $rsSectionList->GetNext())
            {
            $arSections[] = array
                (
                "ID" => $arSection["ID"]
                , "DEPTH_LEVEL" => $arSection["DEPTH_LEVEL"]
                , "~NAME" => $arSection["~NAME"]
                , "~SECTION_PAGE_URL" => str_replace
                        (
                        array("#RANGE_CODE#", "#MODEL_ID#")
                        , array($arVariables['RANGE_CODE'], $arVariables['MODEL_ID'])
                        , $arSection["~SECTION_PAGE_URL"]
                )
            );
            }
        }


 
        
    


    /**
     * Проверим есть ли изображения
     */
    $bPhoto = false;
    $arOrder = array("SORT" => "ASC", "NAME" => "ASC");
    $arFilter = array("ID" => $arVariables['MODEL_ID'], 'IBLOCK_CODE' => $arParams['IBLOCK_MODEL_CODE']);
    $arSelect = array('ID', 'PROPERTY_GALLERY');
    $rsIBlockElementList = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);

    if ($rsIBlockElementList && $arModel = $rsIBlockElementList->Fetch())
        {
        if ($arModel['PROPERTY_GALLERY_VALUE'])
            {
            $arOrder = array("SORT" => "ASC", "NAME" => "ASC");
            $arFilter = array(
                "IBLOCK_CODE" => $arParams["IBLOCK_PHOTO_CODE"]
                , "SECTION_ID" => $arModel['PROPERTY_GALLERY_VALUE']
                , "ACTIVE" => "Y"
            );
            $rsIBlockElementList = CIBlockElement::GetList($arOrder, $arFilter);
            $iPhotoCnt = intval($rsIBlockElementList->SelectedRowsCount());
            $bPhoto = (bool) $iPhotoCnt;
            }
        }

    /**
     * Проверим есть ли видео
     */
    $bVideo = false;
    $arOrder = array();
    $arFilter = array(
        "IBLOCK_CODE" => $arParams["IBLOCK_VIDEO_CODE"]
        , "IBLOCK_TYPE" => $arParams["IBLOCK_FEATURE_TYPE"]
        , "PROPERTY_MODEL_ID" => $arVariables['MODEL_ID']
        , "ACTIVE" => "Y"
    );

    $rsIBlockElementList = CIBlockElement::GetList($arOrder, $arFilter);
    if ($rsIBlockElementList && $objIBlockElement = $rsIBlockElementList->GetNextElement())
        {
        $bVideo = true;
        $arFelds = $objIBlockElement->GetFields();
        $arPropFILE_IMG = $objIBlockElement->GetProperty('FILE_IMG_ID');
        if ($arPropFILE_IMG['VALUE'])
            {
            $arVideoItem = array(
                'IMG' => CFile::GetFileArray($arPropFILE_IMG['VALUE'])
                , 'NAME' => $arFelds['NAME']
                , 'CNT' => $iPhotoCnt
            );
            }
        }

    $obMenuCache->EndDataCache(Array(
        "arSections" => $arSections
        , 'bPhoto' => $bPhoto
        , 'bVideo' => $bVideo
        , 'arVideoItem' => $arVideoItem
        , 'arVariables' => $arVariables
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
    }



//new dBug($arElementLinks);

$menuIndex = 0;
$previousDepthLevel = 1;
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
    

    /**
     * Проверим есть ли технические хар-ки
     */
    $arOrder = array("SORT" => "ASC", "NAME" => "ASC");
    $arFilter = array("IBLOCK_CODE" => "technical_character", 'CODE' => $arVariables['RANGE_CODE'], 'ACTIVE' => 'Y');
    $arSelect = array('NAME');
    $tcIBlockElementList = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);
    $node = $tcIBlockElementList->GetNextElement();
    if (!empty($node))
        {
        $aMenuLinksExt[$menuIndex++] = array
            (
            'Технические характеристики',
            $arParams["SEF_BASE_URL"] . str_replace(
                    array("#RANGE_CODE#", "#MODEL_ID#")
                    , array($arVariables['RANGE_CODE'], $arVariables['MODEL_ID'])
                    , $arParams['DefaultUrlTemplates404']["technical_character"]
            ),
            array(),
            $arItemParams,
        );
        }
    

if ($bPhoto || $bVideo)
    {

    $ar = array();
    if ($bPhoto)
        $ar[] = "изображения";
    if ($bVideo)
        $ar[] = "видео";
    $strTitle = implode(" и ", $ar);
    $strTitle = ToUpper($strTitle[0]) . substr($strTitle, 1);

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
                        , array($arVariables['RANGE_CODE'], $arVariables['MODEL_ID'])
                        , $arParams['DefaultUrlTemplates404']["model_media"]
                ) . '?media_id=mediaID-' . $arVideoItem['CNT'];
        $arItemParams['NAME'] = $arVideoItem['NAME'];
        }
    else
        {
        //попробуем найти блок под левое меню в элементе
        $arOrder = array("SORT" => "ASC", "NAME" => "ASC");
        $arFilter = array("ID" => $arVariables['MODEL_ID'], 'IBLOCK_CODE' => $arParams['IBLOCK_MODEL_CODE']);
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
                , array($arVariables['RANGE_CODE'], $arVariables['MODEL_ID'])
                , $arParams['DefaultUrlTemplates404']["model_media"]
        ),
        array(),
        $arItemParams,
    );
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