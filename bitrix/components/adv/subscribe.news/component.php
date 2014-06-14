<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$SUBSCRIBE_TEMPLATE_RESULT=false;
if (CModule::IncludeModule('subscribe') <> true)
{
	$APPLICATION->ThrowException("Не удалось подключить модуль рассылок");
	return;
}
if (CModule::IncludeModule('iblock') <> true)
{
	$APPLICATION->ThrowException("Не удалось подключить модуль инфоблоков");
	return;
}

global $SUBSCRIBE_TEMPLATE_RUBRIC;


$arParams["IBLOCK_ID"] = (int) $arParams["IBLOCK_ID"];

$arParams["BOTTOM_TITLE"] = trim($arParams["BOTTOM_TITLE"]);

if (strlen($arParams["BOTTOM_TITLE"]) > 0)
	$arResult["BOTTOM_TITLE"] = $arParams["BOTTOM_TITLE"];

$SITE_ID = (!empty($arParams["SITE_ID"]))? trim($arParams["SITE_ID"]) : $SUBSCRIBE_TEMPLATE_RUBRIC["SITE_ID"];

$rsSites = CSite::GetByID($SITE_ID);

if ($arSite = $rsSites->Fetch())
{	
	if (empty($arParams["SITE_NAME"]))
		$arResult["SITE_NAME"] = ($arSite["SITE_NAME"])? $arSite["SITE_NAME"] : $arSite["NAME"];
	else
		$arResult["SITE_NAME"] = trim($arParams["SITE_NAME"]);

	$arResult["SITE_URL"] = "http://".$_SERVER["SERVER_NAME"];

	if(!empty($arParams["ADDITIONAL_SITE_URL"]))
		$arResult["ADDITIONAL_SITE_URL"] = $arParams["ADDITIONAL_SITE_URL"];
	else
		$arResult["ADDITIONAL_SITE_URL"] = $arResult["SITE_URL"];
}

$obPostring = new CPosting();
$rsPostring = $obPostring->GetList(
	array("DATE_SENT" => "DESC"),
	array("STATUS" => "S")
);

$rsPostring->NavStart(1);
$el = $rsPostring->Fetch();
$date = date($DB->DateFormatToPHP(CLang::GetDateFormat("SHORT")), strtotime(&$el['DATE_SENT']));
unset($el);

$arResult['ITEMS'] = array();

$obResult = CIBlockElement::GetList(
	array(
		"ACTIVE_FROM" => "DESC"
	),
	array(
		"IBLOCK_ID" => 203,
		">=DATE_ACTIVE_FROM" => $date
	),
	false,
	false,
	array('ID','DATE_ACTIVE_FROM','NAME','DETAIL_TEXT','IBLOCK_SECITON_ID'/* чтобы можно было url выставлять на основании пренадлежности к секции */,'PREVIEW_TEXT','PREVIEW_PICTURE','DETAIL_PAGE_URL')
);
while ($arElement = $obResult->GetNext())
{
	$arElement['DETAIL_PAGE_URL'] = $arResult["SITE_URL"] . $arElement["DETAIL_PAGE_URL"];

	if (strLen($arElement['PREVIEW_PICTURE']) > 0)
	{
		$arPicture = CFile::GetByID( $arElement['PREVIEW_PICTURE'] )->Fetch();
		//    допускаем превышение размера на 100px
		if ($arPicture['WIDTH'] > 186 || $arPicture['HEIGHT'] > 148)
		{
			$resize = CFile::ResizeImageGet($arPicture, array('width'=>86,'height'=>48), BX_RESIZE_IMAGE_PROPORTIONAL, true, array());
			$arElement['PREVIEW_PICTURE'] = $resize['src'];
		}
		else
		{
			$arElement['PREVIEW_PICTURE'] = CFile::GetPath( $arElement['PREVIEW_PICTURE'] );
		}
	}

	$arResult['ITEMS'][] = $arElement;
}

$arResult['TITLE_TEXT'] = $arParams["TITLE_TEXT"];

if (count($arResult['ITEMS']))
{
	$this->IncludeComponentTemplate();
	$SUBSCRIBE_TEMPLATE_RESULT=count($arResult['ITEMS']);
}

return $SUBSCRIBE_TEMPLATE_RESULT;

?>