<?
error_reporting(E_ALL ^ E_NOTICE);
ini_set ('display_errors', 'stdout');

$_SERVER["DOCUMENT_ROOT"]="/adv/vhosts/www.bmw-autokraft.ru/htdocs";

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if (!CModule::includeModule('iblock'))
	die ();

set_time_limit(10000);
ini_set("memory_limit", "512M");
/////////////////

$arr['IBLOCK_ID_POST'] = '222';
	
if(isset($arr['IBLOCK_ID_POST']))
	$iBlockEnabled = (int)$arr['IBLOCK_ID_POST'];

if(!isset($iBlockEnabled))
	die('Access deny');
else {
	$STORE_NUM = 2;

	$arFilter = Array("IBLOCK_ID"=>(int)$iBlockEnabled);
	$arSelect = Array("ID");
	$res_main = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
	while ($ob_main = $res_main->GetNextElement()) {
		$DB->StartTransaction();
		$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1000000), $arSelect);
		while($ob = $res->GetNextElement()) {
			$ID = (int)$ob->fields['ID'];
			if(!CIBlockElement::Delete($ID))
				echo 'error for delete element ID="'.$ID.'"';
		}
		$DB->Commit();
		$res_main = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
	}

	echo "done";
}
?>
