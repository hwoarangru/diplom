<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
global $DB;
$sqlStr = "SELECT * FROM `adv_action` WHERE `ACTIVE_TO` >= curdate() AND `ACTIVE_FROM` <= curdate() AND `ACTIVE` = 'Y'";
$dbAction = $DB->Query($sqlStr);// 
if($arAction= $dbAction->Fetch())
{
	$rsFile = CFile::GetByID($arAction["PICTURE"]);
	$arAction["PICTURE_PROP"] = $rsFile->Fetch();
	$arAction["PICTURE"] = CFile::GetPath($arAction["PICTURE"]);
	$arResult = $arAction;	
	$this->IncludeComponentTemplate();
}
?>