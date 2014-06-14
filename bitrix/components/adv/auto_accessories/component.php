<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
{
	ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
	return 0;
}
$res = CIBlockElement::GetByID($arParams["ID"]);
if($obRes = $res->GetNextElement()) {
	$arResult = $obRes->GetFields();
	$arResult["PROPERTIES"] = $obRes->GetProperties();
}

if (is_array($arResult["PROPERTIES"]["accessories"]["VALUE"])) {
	foreach ($arResult["PROPERTIES"]["accessories"]["VALUE"] as $accID) {
		$res = CIBlockElement::GetByID($accID);
		if ($ar_res = $res->GetNext()) {
			$arResult["ACC_SEC_LIST"][] = $ar_res["IBLOCK_SECTION_ID"];
			$arResult["ACC_EL_LIST"][] = $ar_res["ID"];
		}
	}
	$db_list = CIBlockSection::GetList(array("SORT" => "ASC"),array("ID" => $arResult["ACC_SEC_LIST"]),false);
	$i = 1;
	while ($ar_list = $db_list->GetNext()) {
		$arResult["ACC_SECTIONS"][$i] = $ar_list;
		$db_el = CIBlockElement::GetList(array("SORT"=>"ASC"),array("SECTION_ID"=>$ar_list["ID"],"ID"=>$arResult["ACC_EL_LIST"]),false,false);
		$j = 1;
		while($ob_el = $db_el->GetNextElement()) {
			$arResult["ACC_SECTIONS"][$i]["ITEMS"][$j] = $ob_el->GetFields();
			$arResult["ACC_SECTIONS"][$i]["ITEMS"][$j]["PROPERTIES"] = $ob_el->GetProperties();
			if ($arResult["ACC_SECTIONS"][$i]["ITEMS"][$j]["DETAIL_PICTURE"]) {
				$rsFile = CFile::GetByID($arResult["ACC_SECTIONS"][$i]["ITEMS"][$j]["DETAIL_PICTURE"]);
				$arFile = $rsFile->Fetch();
				$arResult["ACC_SECTIONS"][$i]["ITEMS"][$j]["DETAIL_PICTURE"] = $arFile;
				$arResult["ACC_SECTIONS"][$i]["ITEMS"][$j]["DETAIL_PICTURE"]["SRC"] = CFile::GetPath($arResult["ACC_SECTIONS"][$i]["ITEMS"][$j]["DETAIL_PICTURE"]["ID"]);
			}
			if ($arResult["ACC_SECTIONS"][$i]["ITEMS"][$j]["PREVIEW_PICTURE"]) {
				$rsFile = CFile::GetByID($arResult["ACC_SECTIONS"][$i]["ITEMS"][$j]["PREVIEW_PICTURE"]);
				$arFile = $rsFile->Fetch();				
				$arResult["ACC_SECTIONS"][$i]["ITEMS"][$j]["PREVIEW_PICTURE"] = $arFile;
				$arResult["ACC_SECTIONS"][$i]["ITEMS"][$j]["PREVIEW_PICTURE"]["SRC"] = CFile::GetPath($arResult["ACC_SECTIONS"][$i]["ITEMS"][$j]["PREVIEW_PICTURE"]["ID"]);
			}
			if($arResult["ACC_SECTIONS"][$i]["ITEMS"][$j]["PROPERTIES"]["big_pic"]["VALUE"]) {
				$res = CIBlockElement::GetByID($arResult["ACC_SECTIONS"][$i]["ITEMS"][$j]["PROPERTIES"]["big_pic"]["VALUE"]);
				if($ar_res = $res->GetNext())
					$arResult["ACC_SECTIONS"][$i]["ITEMS"][$j]["PROPERTIES"]["big_pic"]["VALUE"] = $ar_res["CODE"];
			}
			if (is_array($arResult["ACC_SECTIONS"][$i]["ITEMS"][$j]["PROPERTIES"]["more_imgs"]["VALUE"])) {
				foreach ($arResult["ACC_SECTIONS"][$i]["ITEMS"][$j]["PROPERTIES"]["more_imgs"]["VALUE"] as $key=>$value) {
					$rsFile = CFile::GetByID($value);
					$arFile = $rsFile->Fetch();
					$arResult["ACC_SECTIONS"][$i]["ITEMS"][$j]["PROPERTIES"]["more_imgs"]["VALUE"][$key] = $arFile;
					$arResult["ACC_SECTIONS"][$i]["ITEMS"][$j]["PROPERTIES"]["more_imgs"]["VALUE"][$key]["SRC"] = CFile::GetPath($arResult["ACC_SECTIONS"][$i]["ITEMS"][$j]["PROPERTIES"]["more_imgs"]["VALUE"][$key]["ID"]);
				}
			}
			if (is_array($arResult["ACC_SECTIONS"][$i]["ITEMS"][$j]["PROPERTIES"]["more_imgs_sm"]["VALUE"])) {
				foreach ($arResult["ACC_SECTIONS"][$i]["ITEMS"][$j]["PROPERTIES"]["more_imgs_sm"]["VALUE"] as $key=>$value) {
					$rsFile = CFile::GetByID($value);
					$arFile = $rsFile->Fetch();
					$arResult["ACC_SECTIONS"][$i]["ITEMS"][$j]["PROPERTIES"]["more_imgs_sm"]["VALUE"][$key] = $arFile;
					$arResult["ACC_SECTIONS"][$i]["ITEMS"][$j]["PROPERTIES"]["more_imgs_sm"]["VALUE"][$key]["SRC"] = CFile::GetPath($arResult["ACC_SECTIONS"][$i]["ITEMS"][$j]["PROPERTIES"]["more_imgs_sm"]["VALUE"][$key]["ID"]);
				}
			}
			$j++;
		}
		$i++;
	}
}

if ($arResult["DETAIL_PICTURE"]) {
	$rsFile = CFile::GetByID($arResult["DETAIL_PICTURE"]);
	$arFile = $rsFile->Fetch();
	$arResult["DETAIL_PICTURE"] = $arFile;
	$arResult["DETAIL_PICTURE"]["SRC"] = CFile::GetPath($arResult["DETAIL_PICTURE"]["ID"]);
}



$this->IncludeComponentTemplate();
$APPLICATION->SetTitle('Аксессуары '.$arResult["NAME"]);
?>