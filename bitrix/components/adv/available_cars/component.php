<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if (!CModule::includeModule('iblock'))die();

$PathBits = explode('?', $_SERVER['REQUEST_URI']);
$PathBits = explode('/', $PathBits[0]);
$cache = new CPHPCache();
$cache_time = 3600;// one hour ajax autos cache
$cache_id = 'available_cars'.$arParams['BRAND_NAME'];
$cache_path = '/AvailableCars/';
if ($cache_time > 0 && $cache->InitCache($cache_time, $cache_id, $cache_path)){
	$res = $cache->GetVars();
	if (is_array($res["arResult"]) && (count($res["arResult"]) > 0))
		$arResult = $res["arResult"];
}
if (count($arResult)<=1){
	$arSelect = Array('ID','NAME','DETAIL_TEXT','PROPERTY_COMPL','PROPERTY_COLOR','PROPERTY_PRICE',);
	$arFilter = Array("IBLOCK_TYPE"=>'available_cars', 'IBLOCK_CODE'=>'av_cars_list', 'ACTIVE_DATE'=>'Y', 'ACTIVE'=>'Y');
	$res = CIBlockElement::GetList(Array(), $arFilter, $arSelect);
	while($ob = $res->GetNext()){
		$arResult[] = $ob;
	}

	// Cache write
	$cache->StartDataCache($cache_time, $cache_id, $cache_path);
    $cache->EndDataCache(array("arResult"=>$arResult));
}
$this->IncludeComponentTemplate();
?>
