<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<style type="text/css">
#mainNavigation h1{
	font-size: 1em;
	font-weight: normal;
	margin-top: 27px;
	margin-left: 30px;
}
#horizontal-multilevel-menu2{margin-top: 53px;}
</style>
<script type="text/javascript">
Cufon.replace('h1'); 
Cufon.replace('h2');
var vehicle_navigation_teaser = "r";

   var pageOid = "3316036";
   var saveContentTeaserHTML = "";
   var activeContentTeaser = 0;
   var mediaType = new Array();
   var teaseFlashObject = false;

$(document).ready(function(){
	initStandardPage();
        initContentPage();
});
</script>

<?

$tmpl = <<<EOD
<div id="stage">
	<img src="%1\$s" width="1024" height="634" alt="BMW 3 серии Купе : %2\$s">
</div>
EOD;

printf($tmpl
	, $arParams["FEATURE_SECTION"]["PICTURE_SRC"]
	, $arResult["ELEMENT"]["FIELDS"]["NAME"]
);
?>

<script type="text/javascript">

var activeContentTeaser = 0;

$(function(){
<?/*
	swfobject.embedSWF(
		  "<?=$arResult["ELEMENT"]["PROPS"]["FLASH_FILE"]["SRC"]?>"
		, "mediaStage1"
		, "687"
		, "250"
		, "8.0.0"
	);
*/?>

	
	$("#contentText #moreContent").click(function() {
		$("#downloadDialog" + activeContentTeaser).hide();
		$(this).hide();
		$("#contentPageContainer #contentText").animate({
				top: "10px",
				paddingTop:"23px",
				height: "322px"
			},
			"normal",
			"swing",
			function(){
				$("#contentPageContainer .hiddenLongText").slideDown(
					"normal",
					function(){
					shareUrl = self.location.href;
					shareTitle = document.title;
					$("#lessContent").show();
				});
			}
		);
		$("#contentPageContainer #contentTeaserList").attr("topPos", $("#contentPageContainer #contentTeaserList").css("top"));
		var contentTeaserListTop = "55px";
		if($("#contentTeaserList").hasClass("zeroTeaser")){
			contentTeaserListTop = "46px"
		}
		$("#contentPageContainer #contentTeaserList").animate(
			{top: contentTeaserListTop},
			"normal",
			"swing"
		);
	});
	
	
	$("#contentText #lessContent").click(function(){
		$(this).hide();
		$("#contentPageContainer .hiddenLongText").slideUp(
			"normal",
			function(){
				$("#contentPageContainer #contentText").animate({
						top: "261px",
						paddingTop:"12px",
						height: "100px"
					},
					"normal",
					"swing",
					function() {
						$("#moreContent").show();
						if($("#downloadDialog" + activeContentTeaser + "Layer li").size() != 0){
							$("#downloadDialog" + activeContentTeaser).show();
						}
						shareUrl = self.location.href;
						shareTitle = document.title;
						self.location.href = "#media" + activeContentTeaser;
					}
				);
				$("#contentPageContainer #contentTeaserList").animate({
					top: $("#contentPageContainer #contentTeaserList").attr("topPos")},
					"normal",
					"swing"
				);
			}
		);
	});
})
</script>

<div id="contentPageContainer">

<?if (strlen($arResult["ELEMENT"]["PROPS"]["FLASH_FILE"]["SRC"])) {?>
			
	<div id="mediaStage0" class="mediaStage">
		<div id="mediaStage1">
		<div id="mediaContainer0" class="mediaContainer">
			<div id="mediaContainerNoFlash">
				<br>Для просмотра содержимого этой страницы необходимо установить последнюю версию проигрывателя Flash Player.<br><br>
				<a class="standard" href="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" target="_blank">Загрузить проигрыватель Adobe Flash Player</a>
			</div>
		</div>
		</div>
	</div>
	
<script language="javascript">
	stageFlash = new SWFObject("<?=$arResult["ELEMENT"]["PROPS"]["FLASH_FILE"]["SRC"]?>", "mainFlashMovie", "687", "250", "9.0.115", "#ffffff");
	stageFlash.addParam("quality","autohigh");
	stageFlash.addParam("allowScriptAccess", "sameDomain");
	stageFlash.addParam("wmode", "transparent");
	teaseFlashObject = stageFlash.write("mediaContainer" + activeContentTeaser);
</script>
	
<?} else {?>
        <div id="mediaStageSingle" class="mediaStage" >
<div id="mediaContainer0" class="mediaContainer">
     <div class="animationContainer">
		<?if($arResult["ELEMENT"]["HAS_DOUBLE_GALL"]=="Y")
		{?>
			<div id="content_teaser" style="position: absolute; top: 100px; z-index: 5; background-color: white; right: 100px;">
				<?foreach($arResult["ELEMENT"]["DOUBLE_GALL"] as $gid=>$gall)
				{?>
					<a href="#c=<?=($gid+1)?>&t=s"><img src="<?=$gall["PREVIEW_PICTURE"]?>"><span><?=$gall["NAME"]?></span></a></br>
				<?}?>
			</div>
		<?}?>
          <img class="animationImage first" src="<?=$arResult["ELEMENT"]["FIELDS"]["DETAIL_PICTURE_SRC"]?>" width="687" height="250"> 
<? if(!empty($arResult['ELEMENT']['PROPS']['PHOTO_SLIDE']['VALUE'])): ?>


<? foreach($arResult['ELEMENT']['PROPS']['PHOTO_SLIDE']['VALUE'] as $file):?>
    <img class="animationImage" src="<?= $file ?>" width="687" height="250" />
<? endforeach; ?>

<div class="animationControl" style="top: 260px; ">
                <a href="" class="animationPlay"></a>
                <a href="" class="animationPause" style="display: none; "></a>
                <div class="animationCounter">05 / 06</div>
                <a href="" class="animationNext"></a>
                <a href="" class="animationPrevious"></a>
</div>
<script type="text/javascript">
  mediaType[0] = new Array();
  mediaType[0]["type"] = "ani";
</script>
<? endif ?>
</div>
</div>
</div> 
<?}?>
	
	<?php
        if (trim($arResult['ELEMENT']['PROPS']['HEADLINE']['VALUE']) != "") {
            $_HEADLINE = $arResult['ELEMENT']['PROPS']['HEADLINE']['VALUE'];
        } else {
            $_HEADLINE = $arResult["ELEMENT"]["FIELDS"]["NAME"];
        }
        ?>
	<div id="contentText">
	<div class="wrapContentText" style="width: 440px; height: 322px; overflow: auto;">
		<h2><?=$_HEADLINE;?></h2>
		<p><?=$arResult["ELEMENT"]["FIELDS"]["PREVIEW_TEXT"]?></p>
		<?if (strlen($arResult["ELEMENT"]["FIELDS"]["DETAIL_TEXT"])) {?>
		<p class="hiddenLongText"><?=$arResult["ELEMENT"]["FIELDS"]["DETAIL_TEXT"]?></p>
		<a id="moreContent" class="standard" href="#more">Больше</a>
		<?}?>
		<a id="lessContent" class="standard" href="javascript:void(0);">Закрыть</a>
	</div>
	</div>
	<div id="contentTeaserList" class="zeroTeaser">
<?/*
		<div id="contentTeaser0" class="contentTeaser">
			<img src="../../../../../../../../PoweredBy.gif" width="70" height="45">
			<span><a href="#media0" class="standard"></a></span>
		</div>
*/?>	

<?
/*******************************************************************
 		"ССЫЛКИ ПО ТЕМЕ" - BEGIN
 *******************************************************************/
$tmplFeatureItem = <<<EOD
	<li><a href="%1\$s" target="%3\$s" class="standard highlight_link">%2\$s</a></li>
EOD;
$tmplPopupItemTitle = <<<EOD
	<li><a id="%1\$sReopenLink" href="" onclick="$('#%1\$s').toggle(); return false;" class="standard">%2\$s</a></li>      
EOD;
$tmplPopupItemText = <<<EOD
    <div id="%1\$s" class="hide MFDFeaturePopup" style="display: block;">
		<div class="wrapper">
			<a href="" onclick="$('#%1\$s').hide(); return false;" class="close">&nbsp;</a>
			<!-- h4>%2\$s</h4 ---->
			<div class="content">
				%3\$s
			</div>
		</div>
    </div>	
EOD;
$tmplDirectLinkItem = <<<EOD
    <li><a href="%1\$s" target="%3\$s" class="standard highlight_link">%2\$s</a></li>
EOD;
$arLinkElementItemHTML = array();
if (count($arResult['LINK_ELEMENT']))
{
	foreach ($arResult['LINK_ELEMENT'] as $arItem) 
	{
		switch ($arItem['TYPE']) {
			case 'FEATURE':
				$arLinkElementItemHTML[] = sprintf($tmplFeatureItem
					, $arItem['DETAIL_PAGE_URL']
					, $arItem['NAME']
				);
				break;
			case 'POPUP':
				$id = rand(1000, 9999) . 'popup';
				$arLinkElementItemHTML[] = sprintf($tmplPopupItemTitle
					, $id
					, $arItem['NAME']
				);
				$arLinkElementTextHTML[] = sprintf($tmplPopupItemText
					, $id
					, $arItem['NAME']
					, $arItem['VALUE']
				);
				break;
			case 'DIRECT_LINK':
				$pos = strpos($arItem['NAME'], "http://");
				if($pos === false)
				{
					$target = "_self";
				}
				else
				{
					$target = "_blank";
				}
				$arLinkElementItemHTML[] = sprintf($tmplDirectLinkItem
					, $arItem['NAME']
					, $arItem['VALUE']
					, $target
				);
				break;
			default:
				break;
		}
	}
?>

		<div id="relatedLinks">
			<strong>Ссылки по теме</strong>
			<ul class="linklist">
				<?=implode("\n", $arLinkElementItemHTML);?>
			</ul>
		</div>

<?
}
/*******************************************************************
 		"ССЫЛКИ ПО ТЕМЕ" - END
 *******************************************************************/
?>

		
		
	</div>
<?=implode("\n", $arLinkElementTextHTML)?>
	<div id="closeContentContainer">
		<a id="closeContent" href="../">&nbsp;</a>
	</div>
</div>
<div id="contentDialogButtons">
	<a class="dialogButtonShare" id="shareDialog" href="" onclick="return false;"></a>
	<a class="dialogButtonFavorite" id="favoriteDialog" href="" onclick="return false;"></a>
</div>
<div id="favoriteDialogLayer" class="dialogbox">
	<div class="content">
		<div id="favoriteNotActive">Добавить в избранное</div>
		<div id="favoriteActive">Добавлено в избранное</div>
		<div id="favoriteNoCookie">Файлы cookies отключены</div>
	</div>
</div>
<div id="downloadDialog0Layer" class="dialogbox">
	<div class="content">
		<strong class="downloadDialogHeadline"></strong>
			<ul class="linklist">
		</ul>
	</div>
</div>

<?
//new dBug($arResult);
?>