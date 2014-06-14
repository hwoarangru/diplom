<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Автомобили BMW с пробегом");
?>
<table cellspacing=0 cellpadding=0 style='border:none;'>
<tr><td valign=top style='width:336px;'> 
  <div style="float: left; width: 278px;"> 
    <h1>Автомобили BMW с пробегом.</h1>
   Независимость предлагает Вам услуги по покупке и продаже автомобилей любых марок. У нас большой выбор автомобилей с пробегом. С нами Вы можете чувствовать себя спокойно. Все автомобили прошли предпродажную сервисную подготовку, а их юридическая чистота не подлежит никакому сомнению. 
<!--Попробуйте сами - просто воспользуйтесь ссылкой в правой части экрана.-->
 
    <br />
   
    <br />
   
    <p>За подробной информацией по обращайтесь к менеджерам отдела трейд-ин по тел. 933 66 99</p>
   
    <br />
   </div>
 </td><td style="padding-left:58px;">

<style>
.inputtext {
width:150px;
}
</style>
<?$APPLICATION->IncludeComponent("bitrix:catalog.element", "used_auto", Array(
	"IBLOCK_TYPE"	=>	"models",
	"IBLOCK_ID"	=>	"200",
	"ELEMENT_ID"	=>	$_REQUEST["ID"],
	"SECTION_ID"	=>	"",
	"PROPERTY_CODE"	=>	array(
		0	=>	"prodYear",
		1	=>	"mileage",
		2	=>	"salon_car",
		3	=>	"salon_type",
		4	=>	"color",
		5	=>	"price",
		6	=>	"pics",
		7	=>	"",
	),
	"SECTION_URL"	=>	"section.php?IBLOCK_ID=#IBLOCK_ID#&SECTION_ID=#SECTION_ID#",
	"DETAIL_URL"	=>	"element.php?IBLOCK_ID=#IBLOCK_ID#&SECTION_ID=#SECTION_ID#&ELEMENT_ID=#ELEMENT_ID#",
	"BASKET_URL"	=>	"/personal/basket.php",
	"ACTION_VARIABLE"	=>	"action",
	"PRODUCT_ID_VARIABLE"	=>	"id",
	"SECTION_ID_VARIABLE"	=>	"SECTION_ID",
	"CACHE_TYPE"	=>	"N",
	"CACHE_TIME"	=>	"3600",
	"META_KEYWORDS"	=>	"-",
	"META_DESCRIPTION"	=>	"-",
	"DISPLAY_PANEL"	=>	"N",
	"SET_TITLE"	=>	"Y",
	"ADD_SECTIONS_CHAIN"	=>	"Y",
	"PRICE_CODE"	=>	array(
	),
	"USE_PRICE_COUNT"	=>	"N",
	"SHOW_PRICE_COUNT"	=>	"1",
	"PRICE_VAT_INCLUDE"	=>	"Y",
	"PRICE_VAT_SHOW_VALUE"	=>	"N",
	"LINK_IBLOCK_TYPE"	=>	"",
	"LINK_IBLOCK_ID"	=>	"",
	"LINK_PROPERTY_SID"	=>	"",
	"LINK_ELEMENTS_URL"	=>	"link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#"
	)
);?></td></tr></table>

<?
$res = CIBlockElement::GetByID($_REQUEST["ID"]);
$ob = $res->GetNext();
$_SESSION["bmodel"] = $ob["NAME"];
?>
<br><br><br>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>