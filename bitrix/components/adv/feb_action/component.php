<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
CModule::IncludeModule('iblock');

$cache = new CPHPCache();
$cache_time = 3600*3;
$cache_id = 'feb_action_data';
$cache_path = '/feb_action_data_dir/';

if($cache_time > 0 && $cache->InitCache($cache_time, $cache_id, $cache_path)){
	$res = $cache->GetVars();
	if (is_array($res["arResult"]) && (count($res["arResult"]) > 0))
		$arResult = $res["arResult"];
}
if(count($arResult)==0){
	CModule::IncludeModule('form');
	$rsForm = CForm::GetBySID($arParams['FORM_CODE']);
	$arForm = $rsForm->Fetch();
	$arResult["FORM_ID"] = $arForm['ID'];
	//////////// end cache /////////
	if ($cache_time > 0){
		$cache->StartDataCache($cache_time, $cache_id, $cache_path);
		$cache->EndDataCache(array("arResult"=>$arResult));
	}
}

$this->IncludeComponentTemplate();
?>