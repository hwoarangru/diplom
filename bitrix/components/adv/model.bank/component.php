<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?><?

$arParams["CACHE_TIME"] = isset($arParams["CACHE_TIME"])?intval($arParams["CACHE_TIME"]):86400;
$arParams["IBLOCK_MODEL_CODE"] = "models";


if (!CModule::IncludeModule("iblock"))
{
	return false;
}
if(!$_REQUEST["vznosProc"])
{
	$_REQUEST["vznosProc"]=100000;
}
if(!$_REQUEST["platProc"])
{
	$_REQUEST["platProc"]=10000;
}
if(!$_REQUEST["srokProc"])
{
	$_REQUEST["srokProc"]=36;
}

$max_price=$_REQUEST["vznosProc"]+($_REQUEST["platProc"]*$_REQUEST["srokProc"]);
//движки, подходящие по цене
$arSelect = array("PROPERTY_PIC", "PROPERTY_PRICE", "ID", "IBLOCK_SECTION_ID", "NAME");
$arOrder = array("IBLOCK_SECTION_ID"=>"ASC", "PROPERTY_PRICE"=>"ASC");
$arFilter = array(
  "IBLOCK_CODE" => "technical_character",
  "ACTIVE" => "Y",
  "<PROPERTY_PRICE" => $max_price
);
$rsIBlockElementList = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);
while($IBlockElement = $rsIBlockElementList->GetNext())
{
	$file = CFile::ResizeImageGet($IBlockElement["PROPERTY_PIC_VALUE"], array('width'=>76, 'height'=>48), BX_RESIZE_IMAGE_PROPORTIONAL, true);
	$IBlockElement["PIC"]=$file;
	$arr[$IBlockElement["IBLOCK_SECTION_ID"]][]=$IBlockElement;
	$section_id[]=$IBlockElement["IBLOCK_SECTION_ID"];
	
}


function compare_price($v1, $v2)
{
   if ($v1['PROPERTY_PRICE_VALUE'] == $v2['PROPERTY_PRICE_VALUE']) return 0;
   return ($v1['PROPERTY_PRICE_VALUE'] < $v2['PROPERTY_PRICE_VALUE'])?-1:1;
}

if(isset($section_id[0]))
{
	//массив моделей выбранных движков
	$arSelect = array("ID", "NAME", "PROPERTY_TTX", "PROPERTY_BANK_URL");
	$arOrder = array("PROPERTY_TTX"=>"ASC");
	$arFilter = array(
	  "IBLOCK_CODE" => "models",
	  "ACTIVE" => "Y",
	  "PROPERTY_TTX" => $section_id
	);
	$rsIBlockElementList = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);
	while($IBlockElement = $rsIBlockElementList->GetNext())
	{
		$arr_sect[]=$IBlockElement;
	}

	//соеденим массив моделей и движков по привязке
	foreach($arr_sect as $mid=>$model)
	{
		$emid=$model["PROPERTY_TTX_VALUE"];
		usort($arr[$emid], 'compare_price');
		$arr_sect[$mid]["ENGINE"]=$arr[$emid];
	}
}


$arResult["MAX_PRICE"]=$max_price;
$arResult["vznosProc"]=$_REQUEST["vznosProc"];
$arResult["platProc"]=$_REQUEST["platProc"];
$arResult["srokProc"]=$_REQUEST["srokProc"];
$arResult["ITEM"]=$arr_sect;


$this->IncludeComponentTemplate();
?>