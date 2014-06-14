<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
global $APPLICATION;
$arResult['CUR_DIR'] = $APPLICATION->GetCurDir();

if(empty($arParams['URL_REDIRECT']))
	$arParams['IMAGE_PATH'] = '/bitrix/components/adv/adv_promo_popup/templates/.default/images/baner.jpg';

if(empty($arParams['URL_REDIRECT']))
	$arParams['URL_REDIRECT'] = '/index.php';

if(!$APPLICATION->get_cookie("SHOW_PROMO_HOL")){
	//$APPLICATION->AddHeadScript('https://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js');
	$this->IncludeComponentTemplate();
}

?>