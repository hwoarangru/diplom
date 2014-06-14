<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<script type="text/javascript">
Cufon.replace('h1'); 
Cufon.replace('h2');
var vehicle_navigation_teaser = "r";
$(document).ready(function(){
	initStandardPage();
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
        <div id="mediaStageSingle" class="mediaStage">
          <img src="<?=$arResult["ELEMENT"]["FIELDS"]["DETAIL_PICTURE_SRC"]?>" width="687" height="250" alt=""> 

<?
/*
if(isset($_GET['qqq3'])){
echo '<pre>';
print_r($arResult["ELEMENT"]["FIELDS"]);
echo '</pre>';}
*/
?>

        </div> 
<?}?>
	
	
	<div id="contentText">
		<h2><?=$arResult["ELEMENT"]["FIELDS"]["NAME"]?></h2>
		<p><?=$arResult["ELEMENT"]["FIELDS"]["PREVIEW_TEXT"]?></p>
		<?if (strlen($arResult["ELEMENT"]["FIELDS"]["DETAIL_TEXT"])) {?>
		<p class="hiddenLongText"><?=$arResult["ELEMENT"]["FIELDS"]["DETAIL_TEXT"]?></p>
		<a id="moreContent" class="standard" href="#more">Больше</a>
		<?}?>
		<a id="lessContent" class="standard" href="javascript:void(0);">Закрыть</a>
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
	<li><a href="%1\$s" target="_self" class="standard highlight_link">%2\$s</a></li>
EOD;
$tmplPopupItemTitle = <<<EOD
	<li><a id="%1\$sReopenLink" href="" onclick="$('#%1\$s').toggle(); return false;" class="standard">%2\$s</a></li>      
EOD;
$tmplPopupItemText = <<<EOD
    <div id="%1\$s" class="hide MFDFeaturePopup">
		<div class="wrapper">
			<a href="" onclick="$('#%1\$s').hide(); return false;" class="close">&nbsp;</a>
			<h4>%2\$s</h4>
			<div class="content">
				%3\$s
			</div>
		</div>
    </div>	
EOD;
$tmplDirectLinkItem = <<<EOD
    <li><a href="%1\$s" target="_self" class="standard highlight_link">%2\$s</a></li>
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
				$arLinkElementItemHTML[] = sprintf($tmplDirectLinkItem
					, $arItem['NAME']
					, $arItem['VALUE']
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