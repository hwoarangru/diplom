<style type="text/css">
#mainNavigation h1{
	font-size: 1em;
	margin-top: 27px;
	margin-left: 30px;
}
</style>
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?//print_r($arResult);?>
<?if ($arResult["FEATURE_SECTION"]["UF_DONT_OPEN"]):?>
<style type="text/css">
div.overviewLinkWide a.overview_white:focus, div.overviewLinkWide a.overview_white:hover, div.overviewLinkWide a.overview_white:active, div.overviewLinkWide a.overview_black:focus, div.overviewLinkWide a.overview_black:hover, div.overviewLinkWide a.overview_black:active {
background-image: url("<?=SITE_TEMPLATE_PATH?>/img/standard_elements/arrow_big_right_blue.gif") !important;
color: #04C;
}
</style>
	<?
$tmplItem = <<<EOD
	<div class="overview_indent_wide" %9\$s>
		<div class="overviewLinkWide"><a href="%1\$s" %10\$s class="%6\$s">%2\$s</a></div>
		<div class="overview_link_layer">
				%7\$s
				%5\$s
		</div>
	</div>
EOD;
	?>
<?else:?>
	<?
$tmplItem = <<<EOD
	<div class="overview_indent" %9\$s>
		<div class="overviewLink %8\$s"><a href="%1\$s" %10\$s class="%6\$s" style="color: #%4\$s">%2\$s</a></div>
		<div class="overview_link_layer">
			<strong>%2\$s</strong>
			<p>%3\$s</p>
			<div class="overview_links">
				%7\$s
				%5\$s
			</div>
		</div>
	</div>
EOD;
	?>
<?endif;?>
<?
$count = sizeof($arResult['ITEM_LIST_ID_SORT']);
$I = 1;
if($arResult['MARGIN_LEFT'])
{
	$margin_left = 'style="margin-left:'.$arResult['MARGIN_LEFT'].'px";';
}
else
{
	$margin_left = '';
}
foreach ($arResult['ITEM_LIST_ID_SORT'] as $ID) 
{
        $cssClass = "overview_white";
        if ($arParams['TITLE_COLOR'] != "fff") {$cssClass = "overview_black";}
    
        if ($I == $count) {
            
            if ($arResult["VIEW_360"])
            {
				$target = '';
				if($arResult["VIEW_360"]["PROPS"]["BLANK"]["VALUE"] == 'Да')
				{
					$target = 'target="_blank"';
				}
				if ($arResult["VIEW_360"]["PROPS"]["LAST"]["VALUE"] != 'Да')
				{
					if ($arResult["VIEW_360"]["PROPS"]["NAME_FOR_SEC"]["VALUE"]) {
						$name_for_sec = $arResult["VIEW_360"]["PROPS"]["NAME_FOR_SEC"]["VALUE"];
					}
					else {
						$name_for_sec = "Панорамное изображение 360&deg;";
					}
							$newDetailUrl = str_replace('model','cars',$arResult["VIEW_360"]['DETAIL_PAGE_URL']);
							$newDetailUrl = str_replace('/mw','/bmw',$newDetailUrl);
							$open='open';
							if(strlen($arResult["VIEW_360"]['FIELDS']['PREVIEW_TEXT'])==0)
							{
								$open='';
								//$cssClass.=' standard';
							}
							$arItemListHTML[] = sprintf($tmplItem
									/* 1 */, $newDetailUrl
									/* 2 */, $name_for_sec
									/* 3 */, $arResult["VIEW_360"]['FIELDS']['PREVIEW_TEXT']
									/* 4 */, $arParams['TITLE_COLOR']
									/* 5 */, ''
									/* 6 */, $cssClass
									/* 7 */, $arResult['ITEM_LIST'][$ID]['FIELDS']['PREVIEW_TEXT'] ? '<a href="'.$newDetailUrl.'" class="standard bold">Информация</a>' : ''
									/* 8 */, $open
									/* 9 */, $margin_left
									/* 10 */, $target
							);
				}
            }
            
        }
        $arItem = $arResult['ITEM_LIST'][$ID];
	$newDetailUrl = str_replace('model','cars',$arItem['FIELDS']['DETAIL_PAGE_URL']);
	$newDetailUrl = str_replace('/mw','/bmw',$newDetailUrl);
	$open='open';
	if(strlen($arItem['PROPS']['FEW_PREVIEW_TEXT']['~VALUE'])==0)
	{
		$open='';
		//$cssClass.=' standard';
	}
	$arItemListHTML[] = sprintf($tmplItem
		/* 1 */, $newDetailUrl
		/* 2 */, $arItem['FIELDS']['NAME']
		/* 3 */, $arItem['PROPS']['FEW_PREVIEW_TEXT']['~VALUE']
		/* 4 */, $arParams['TITLE_COLOR']
		/* 5 */, (strlen($arResult['ITEM_LIST'][$ID]['PROPS']['PRESENTATION']['VALUE'])>0) ? '<a class="standard bold highlight_link" target="_blank" href="'.$arResult['ITEM_LIST'][$ID]['PROPS']['PRESENTATION']['VALUE'].'">Презентация</a>':''
        /* 6 */, $cssClass
		/* 7 */, $arResult['ITEM_LIST'][$ID]['FIELDS']['PREVIEW_TEXT'] ? '<a href="'.$newDetailUrl.'" class="standard bold">Информация</a>' : ''
		/* 8 */, $open
		/* 9 */, $margin_left
		/* 10 */, $target
	);
        
        $I++;
        
}


	
    if ($arResult["VIEW_360"])
    {
		$target = '';
		if($arResult["VIEW_360"]["PROPS"]["BLANK"]["VALUE"] == 'Да')
		{
			$target = 'target="_blank"';
		}
		if ($arResult["VIEW_360"]["PROPS"]["LAST"]["VALUE"] == 'Да') {
			if ($arResult["VIEW_360"]["PROPS"]["NAME_FOR_SEC"]["VALUE"]) {
				$name_for_sec = $arResult["VIEW_360"]["PROPS"]["NAME_FOR_SEC"]["VALUE"];
			}
			else {
				$name_for_sec = "Панорамное изображение 360&deg;";
			}
			$newDetailUrl = str_replace('model','cars',$arResult["VIEW_360"]['DETAIL_PAGE_URL']);
			$newDetailUrl = str_replace('/mw','/bmw',$newDetailUrl);
			$open='open';
			if(strlen($arResult["VIEW_360"]['FIELDS']['PREVIEW_TEXT'])==0)
			{
				$open='';
				//$cssClass.=' standard';
			}
			$arItemListHTML[] = sprintf($tmplItem
				/* 1 */, $newDetailUrl
				/* 2 */, $name_for_sec
				/* 3 */, $arResult["VIEW_360"]['FIELDS']['PREVIEW_TEXT']
				/* 4 */, $arParams['TITLE_COLOR']
				/* 5 */, ''
				/* 6 */, $cssClass
				/* 7 */, $arResult['ITEM_LIST'][$ID]['FIELDS']['PREVIEW_TEXT'] ? '<a href="'.$newDetailUrl.'" class="standard bold">Информация</a>' : ''
				/* 8 */, $open
				/* 9 */, $margin_left
				/* 10 */, $target
			);
		}
    }
?>
<script type="text/javascript">
var vehicle_navigation_teaser = "r";
Cufon.replace('h2');
$(document).ready(function() {
	initStandardPage();
	$(".overview_link_layer").mouseleave(
	function () {
		$(this).prev().show();
		$(this).hide();
	})
	//$("#overview_linklist div.overviewLink").mouseover(
	$("#overview_linklist div.open").mouseover(
	function () {
		overviewResetLinklist();
		$(this).hide();
		$(this).next().show();
	})
});
function overviewResetLinklist() {
	$("#overview_linklist a.overview").each(function() {
		$(this).parent().show();
		$(this).parent().next().hide();
	});
}
</script>

<?=implode("\n", $arItemListHTML)?>

<?
//new dBug($arParams);
//new dBug($arResult);
?>