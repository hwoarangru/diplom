<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>


<?if (!empty($arResult["MORE_PROPS"]) && $arResult["MORE_PROPS"] == "Y"):?>
<style  type="text/css">
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


ob_start();
$APPLICATION->IncludeComponent("adv:model.feature_list", "", array(
	  "MODEL_ID" => $arResult['VARIABLES']['MODEL_ID']
	, "CODE" => $arResult['VARIABLES']['CODE']
	, "MODEL_NAME" => $arResult['VARIABLES']['NAME']
	, "RANGE_CODE" => $arResult['VARIABLES']["RANGE_CODE"]
	, "FEATURE_IBLOCK" => $arResult["FEATURE_IBLOCK"]
	, "CACHE_TIME" => $arParams['CACHE_TIME']
	, "RANGE_SECTION" => $arResult['RANGE_SECTION']
	, "FEATURE_SECTION" => $arResult['FEATURE_SECTION']
	, "TITLE_COLOR" => $arResult["FEATURE_SECTION"]["UF_TITLE_COLOR"]["XML_ID"]
	, "IBLOCK_PRESENTATION_CODE" => $arParams["IBLOCK_PRESENTATION_CODE"]
	, "IBLOCK_VIEW360_CODE" => $arParams["IBLOCK_VIEW360_CODE"]
	, "URL_TEMPLATES" => $arResult['URL_TEMPLATES']
	, "SEF_FOLDER" => $arResult['FOLDER']
));
$strFeatureListHTML = ob_get_contents();
ob_end_clean();

$tmpl = <<<EOD
<div id="stage">
	<img src="%1\$s" width="1024" height="634" alt="%2\$s : %3\$s" />
<div id="facebook_like">
<iframe src="//www.facebook.com/plugins/like.php?href=%8\$s&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe>
</div>
</div>

<div id="overview_linklist" style="position:absolute; top:%5\$spx; left:%6\$spx;">
	<h2 style="white-space:nowrap; color: #%4\$s">%3\$s</h2>
	%7\$s
</div>
EOD;

printf($tmpl
	/* 1 */, $arResult["FEATURE_SECTION"]["PICTURE_SRC"]
	/* 2 */, "BMW 3 серии Купе "
	/* 3 */, ToUpper($arResult["FEATURE_SECTION"]["DESCRIPTION"])
	/* 4 */, $arResult["FEATURE_SECTION"]["UF_TITLE_COLOR"]["XML_ID"]
	/* 5 */, 117 + $arResult["FEATURE_SECTION"]["UF_TOP_MARGIN"]
	/* 6 */, 246 + $arResult["FEATURE_SECTION"]["UF_LEFT_MARGIN"]
	/* 7 */, $strFeatureListHTML
        /* 8 */, urlencode("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])

);
?>


<?
//new dBug($arResult);
?>
<?if ($arResult['FEATURE_SECTION']['UF_FLASH_FILE']):?>
<div id="stage_flash"></div>
<style  type="text/css">
	#overview_linklist {z-index:100}
	#facebook_like {z-index:100}
</style>
<script type="text/javascript">
  if(highbandUser) {
    var stageFlash = new SWFObject("<?=CFile::GetPath($arResult['FEATURE_SECTION']['UF_FLASH_FILE'])?>", "mainFlashMovie", "1024", "634", "9.0.115", "#ffffff");
    stageFlash.addParam("quality","autohigh");
    stageFlash.addParam("allowScriptAccess", "sameDomain");
    stageFlash.addParam("wmode", "transparent");
    stageFlash.addVariable("prm_corelib","<?=$this->GetFolder()?>/flash/bmw_as3_corelib_1_1.swf");
    stageFlash.addVariable("prm_components","<?=$this->GetFolder()?>/flash/bmw_as3_components_2_0.swf");
    userHasFlash = stageFlash.write("stage_flash");
  }
</script>
<?endif;?>
<?if ($arResult["FEATURE_SECTION"]["UF_HOTSPOTS"]):?>
	<script src="<?=SITE_TEMPLATE_PATH?>/js/hotspots.js"></script>
	<link type="text/css" rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/hotspots.css">
	<div id="hotspotsOverviewLayer">
		<?foreach($arResult["FEATURE_SECTION"]["UF_HOTSPOTS"] as $hotspot):?>
			<?$arHotspot = explode('#',$hotspot);
			$pos = strpos($arHotspot[0], 'http://');
			if(!($pos === false))
			{
				$arHotspot = explode('^',$hotspot);
			}?>
			<?if(count($arHotspot) == 7):?>
				<div class="hotspotLayer bright" style="left: <?=$arHotspot[0]?>px; top: <?=$arHotspot[1]?>px;">
					<a class="hotspotLink" href="<?=$arHotspot[2]?>" target="_blank"><img class="hotspotImage" src="<?=SITE_TEMPLATE_PATH?>/img/hotspots/1x1_trans.gif" width="28" height="26" border="0" alt="" /></a>
					<div class="content <?=$arHotspot[3]?>" style="width: <?=$arHotspot[4]?>px;">
						<strong><?=$arHotspot[5]?></strong>
						<a class="standard" href="<?=$arHotspot[2]?>"  onclick="trackingCookie('hotspot_navi',this);" target="_blank"><?=$arHotspot[6]?></a>
						<div class="arrow"></div>
					</div>
				</div>
			<?endif;?>
		<?endforeach;?>
	</div>
<?endif;?>