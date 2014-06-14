<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>


<?

ob_start();
$APPLICATION->IncludeComponent("adv:model.feature_list", "", array(
	  "MODEL_ID" => $arResult['VARIABLES']['MODEL_ID']
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
	<h2 style="color: #%4\$s">%3\$s</h2>
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