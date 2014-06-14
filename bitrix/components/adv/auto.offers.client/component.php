<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$cache = new CPHPCache();
$cache_time = 3600*3;
$cache_id = 'outlet_cars'.$arParams['BRAND_CODE'].$arParams['CITY'];
$cache_path = '/OutletDir/';

if ($cache_time > 0 && $cache->InitCache($cache_time, $cache_id, $cache_path)){
	$res = $cache->GetVars();
	if (is_array($res["arResult"]) && (count($res["arResult"]) > 0))
		$arResult = $res["arResult"];
}

if (count($arResult)==0){
	CModule::IncludeModule('form');
	$ObjForm = new CForm;
	
	$rsForm = $ObjForm->GetBySID($arParams['FORMS']['TEST_DRIVE']);
	$arForm = $rsForm->Fetch();
	$arResult['TEST_DRIVE'] = $arForm['ID'];
	
	$rsForm = $ObjForm->GetBySID($arParams['FORMS']['BOOKING']);
	$arForm = $rsForm->Fetch();
	$arResult['BOOKING'] = $arForm['ID'];
	
	$rsForm = $ObjForm->GetBySID($arParams['FORMS']['CREDIT']);
	$arForm = $rsForm->Fetch();
	$arResult['CREDIT'] = $arForm['ID'];
	
	
	$PostArray = Array();
	$PostArray['KEY'] = md5('give me outlet cars now');
	$PostArray['MARK'] = $arParams['BRAND_CODE'];
	$PostArray['CITY'] = $arParams['CITY'];
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://outlet.indep.ru/");
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_POST, TRUE); 
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $PostArray);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);
	$result = curl_exec($ch);
	curl_close($ch);
	// IF SITE UTF=8 ENCODING
		$arResult['CARS'] = unserialize(stripslashes($result));
		/*foreach($arResult['ITEMS'] as $ariKey => $arItem){
			foreach($arItem as $arsKey => $arisVal){
				if($arsKey!='PHOTOS'){ 
					$arResult['ITEMS'][$ariKey][$arsKey] = iconv('WINDOWS-1251', 'UTF-8', $arisVal);
				}
			}
		}*/
	// ENDIF

	//////////// end cache /////////
	if ($cache_time > 0){
		$cache->StartDataCache($cache_time, $cache_id, $cache_path);
		$cache->EndDataCache(array("arResult"=>$arResult));
	}
}
$this->IncludeComponentTemplate();
?>