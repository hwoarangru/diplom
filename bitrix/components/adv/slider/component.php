<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if (!CModule::includeModule('iblock'))
	return;

if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 3600;

$arParams['IBLOCK_ID'] = intval($arParams['IBLOCK_ID']);
$arParams['SECTION_ID'] = intval($arParams['SECTION_ID']);

if($this->StartResultCache($arParams['CACHE_TIME'], array($arParams['SECTION_ID'])))
{
    /*echo 'SECTION_ID = '.$arParams['SECTION_ID']."<br>";
    echo 'IBLOCK_ID = '.$arParams['IBLOCK_ID']."<br>";*/
    if($arParams['IBLOCK_ID'] > 0 && $arParams['SECTION_ID'] > 0)
    {
        $res = CIBlockSection::GetByID($arParams['SECTION_ID']);
        if ($section = $res->GetNext()) {
            $db_elts=CIblockElement::GetList(array("SORT"=>"ASC","NAME"=>"ASC"),array("IBLOCK_ID"=>$arParams['IBLOCK_ID'],"SECTION_ID"=>$section["ID"],"ACTIVE"=>"Y"));
            $arResult=array();

            if ($db_elts->SelectedRowsCount()==1) {
                if ($ar_elts=$db_elts->GetNext()) {
                    $tmp_res = CIBlockElement::GetByID($ar_elts["ID"]);
                    if ($ob_element = $tmp_res->GetNextElement()) {
                        $element=$ob_element->GetFields();
                        $element["PROPERTIES"]=$ob_element->GetProperties();
                        $img = CFile::GetByID($element['DETAIL_PICTURE']);
                        $img = $img->Fetch();
                        $img['SRC'] = "/upload/".$img['SUBDIR']."/".$img['FILE_NAME'];
                        $img['ALT'] = $element["PREVIEW_TEXT"];
                        $fact_mode="elt";
                        if ($element["PROPERTIES"]["PHOTO"]["VALUE"]) {
                            $_GET["mode"]="photo";
                            $photo_section_id=$element["PROPERTIES"]["PHOTO"]["VALUE"];
                        }
                        if (is_array($element["PROPERTIES"]["MODIF"]["VALUE"]) && count($element["PROPERTIES"]["MODIF"]["VALUE"])) {
                            $_GET["mode"]="mod";
                            $APPLICATION->MODS = $element["PROPERTIES"]["MODIF"]["VALUE"];
                        }
                    }
                }
            } else {
                $have_preview=false;
                $fact_mode="sect";
                while ($ar_elts=$db_elts->GetNext()) {
                    $preview="";
                    if ($ar_elts["PREVIEW_PICTURE"]) {
                        $preview=CFile::GetByID($ar_elts["PREVIEW_PICTURE"]);
                        $preview=$preview->Fetch();
                        $preview="/upload/".$preview['SUBDIR']."/".$preview['FILE_NAME'];
                        $have_preview=true;
                    }
                    $detail=CFile::GetByID($ar_elts["DETAIL_PICTURE"]);
                    $detail=$detail->Fetch();
                    $detail="/upload/".$detail['SUBDIR']."/".$detail['FILE_NAME'];
                    $arResult[]=array("NAME"=>$ar_elts["NAME"],"PREVIEW"=>$preview,"DETAIL"=>$detail,"TEXT"=>$ar_elts["DETAIL_TEXT"]);
                }
            }
        }
    }//if($arParams['IBLOCK_ID'] > 0 && $arParams['SECTION_ID'] > 0)

    /*echo "<pre>";
    print_r($arResult);
    echo "</pre>";*/

    /*if(!count( $arResult["list"]))
    {
        $this->AbortResultCache();
        if(!$arParams['NOT_SHOW_ERRORS'])
            ShowError("К сожалению, не найдено элементов");
    }*/
    $this->IncludeComponentTemplate();

}
?>