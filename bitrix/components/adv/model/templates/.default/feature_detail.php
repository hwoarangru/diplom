<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<script type="text/javascript">
	var vehicle_navigation_teaser = "r";
</script>
<style type="text/css">
#mainNavigation h1{
	font-size: 1em;
	font-weight: normal;
	margin-top: 27px;
	margin-left: 30px;
}
#horizontal-multilevel-menu2{margin-top: 53px;}
</style>

<?if (!empty($arResult["MORE_PROPS"]) && $arResult["MORE_PROPS"] == "Y"):?><style  type="text/css">
#sales_navigation ul a {
	background-image: url(/bitrix/components/adv/model/templates/.default/images/sales_navigation_carbon_button_bg.png);
	color: #606060;
}
#vehicle_navigation ul a {
	background-image: url(/bitrix/components/adv/model/templates/.default/images/vehicle_navigation_button_bg_dark_vehicle_nav.gif);
	border-top: 1px solid #505050;
	color: white;
}
.teaser_cont {
	background-image: url(/bitrix/components/adv/model/templates/.default/images/vehicle_navigation_button_bg_dark.gif);
}
.teaser_cont .teaser_text {
	color: white;
}
.teaser_cont .teaser_text a{
	background-position: 0 -81px;
	color: white;
}
.teaser_cont .teaser_text a:hover{
	background-position: 0 -551px;
	color: #1D6AD4;
}
#datasheet_head {
	color: white;
}
</style>
<?endif;?>


<?
$APPLICATION->IncludeComponent("adv:model.feature_detail", "", array(
	  "MODEL_ID" => $arResult['VARIABLES']['MODEL_ID']
	, "CODE" => $arResult['VARIABLES']["CODE"]
	, "MODEL_NAME" => $arResult['VARIABLES']["NAME"]
	, "RANGE_CODE" => $arResult['VARIABLES']["RANGE_CODE"]
	, "FEATURE_CODE" => $arResult['VARIABLES']["FEATURE_CODE"]
	, "FEATURE_IBLOCK" => $arResult["FEATURE_IBLOCK"]
	, "CACHE_TIME" => $arParams['CACHE_TIME']
	, "RANGE_SECTION" => $arResult['RANGE_SECTION']
	, "FEATURE_SECTION" => $arResult['FEATURE_SECTION']
	, "TITLE_COLOR" => $arResult["FEATURE_SECTION"]["UF_TITLE_COLOR"]["XML_ID"]
));
?>