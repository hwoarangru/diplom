<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<style type="text/css">
#horizontal-multilevel-menu2 {
    margin-top: 53px;
    z-index: 10000;
    margin-left: 30px;
}
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
div#mediaGalleryCategoriesLayer div.category span.headline {
	color: white;
}
</style>
<?endif;?>

<?
$APPLICATION->IncludeComponent("adv:model.media", "", array(
	  "MODEL_ID" => $arResult['VARIABLES']['MODEL_ID']
	, "RANGE_CODE" => $arResult['VARIABLES']["RANGE_CODE"]
	, "PRESENTATION_CODE" => $arResult['VARIABLES']["PRESENTATION_CODE"]
	, "FEATURE_IBLOCK" => $arResult["FEATURE_IBLOCK"]
	, "CACHE_TIME" => $arParams['CACHE_TIME']
	, "RANGE_SECTION" => $arResult['RANGE_SECTION']
	, "FEATURE_SECTION" => $arResult['FEATURE_SECTION']
	, "IBLOCK_FEATURE_TYPE" => $arParams["IBLOCK_FEATURE_TYPE"]
	, "IBLOCK_PRESENTATION_CODE" => $arParams["IBLOCK_PRESENTATION_CODE"]
	, "IBLOCK_MODEL_CODE" => $arParams["IBLOCK_MODEL_CODE"]
	, "IBLOCK_PHOTO_CODE" => $arParams["IBLOCK_PHOTO_CODE"]
	, "IBLOCK_VIDEO_CODE" => $arParams["IBLOCK_VIDEO_CODE"]
	, "URL_TEMPLATES" => $arResult['URL_TEMPLATES']
));
?>

<div id="facebook_like">
<iframe src="//www.facebook.com/plugins/like.php?href=<?= urlencode("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])
?>&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe>
</div>