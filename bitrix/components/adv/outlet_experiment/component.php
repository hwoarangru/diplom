<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$cache = new CPHPCache();
$cache_time = 3600*3;
$cache_id = 'outlet_experiment';
$cache_path = '/OutletExDir/';

if ($cache_time > 0 && $cache->InitCache($cache_time, $cache_id, $cache_path)){
	$res = $cache->GetVars();
	if (is_array($res["arResult"]) && (count($res["arResult"]) > 0))
		$arResult = $res["arResult"];
}

if (count($arResult)==0){
	CModule::IncludeModule('form');
	$ObjForm = new CForm;
	
	$rsForm = $ObjForm->GetBySID($arParams['FORMS']['OFFER']);
	$arForm = $rsForm->Fetch();
	$arResult['OFFER_FORM'] = $arForm['ID'];
	
	$rsForm = $ObjForm->GetBySID($arParams['FORMS']['CALLBACK']);
	$arForm = $rsForm->Fetch();
	$arResult['CALLBACK_FORM'] = $arForm['ID'];
	
	$arSelect = Array("ID", "NAME", "PROPERTY_SALE", "PROPERTY_BUTTON_TEXT", "PREVIEW_PICTURE", "DETAIL_PICTURE");
	$arFilter = Array("IBLOCK_TYPE"=>"news", "IBLOCK_CODE"=>"offer_days", "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
	$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, $arSelect);
	while($ob = $res->GetNext()){
		$arResult['CARS'][$ob['ID']] = $ob;
		$arResult['CARS'][$ob['ID']]['PREVIEW_PICTURE'] = CFile::GetPath($ob['PREVIEW_PICTURE']);
		if($arResult['CARS'][$ob['ID']]['DETAIL_PICTURE']!=''){
			$arResult['CARS'][$ob['ID']]['DETAIL_PICTURE'] = CFile::GetPath($ob['DETAIL_PICTURE']);
		}else{
			unset($arResult['CARS'][$ob['ID']]['DETAIL_PICTURE']);
		}
	}

	$arSelect = Array("ID", "NAME", "PROPERTY_SALE", "PROPERTY_BUTTON_TEXT", "PREVIEW_PICTURE", "DETAIL_PICTURE");
		$arFilter = Array("IBLOCK_TYPE"=>"news", "IBLOCK_CODE"=>"offer_days", "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
		$res = CIBlockElement::GetList(Array("PROPERTY_SLIDER_SORT"=>"ASC"), $arFilter, false, false, $arSelect);
		while($ob = $res->GetNext()){
			$arResult['CARS_SLIDER'][$ob['ID']] = $ob;
			$arResult['CARS_SLIDER'][$ob['ID']]['PREVIEW_PICTURE'] = CFile::GetPath($ob['PREVIEW_PICTURE']);
			if($arResult['CARS_SLIDER'][$ob['ID']]['DETAIL_PICTURE']!=''){
				$arResult['CARS_SLIDER'][$ob['ID']]['DETAIL_PICTURE'] = CFile::GetPath($ob['DETAIL_PICTURE']);
			}else{
				unset($arResult['CARS_SLIDER'][$ob['ID']]['DETAIL_PICTURE']);
			}
		}

	//////////// end cache /////////
	if ($cache_time > 0){
		$cache->StartDataCache($cache_time, $cache_id, $cache_path);
		$cache->EndDataCache(array("arResult"=>$arResult));
	}
}
$this->IncludeComponentTemplate();
?>