<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
/*echo "<pre>";
print_r($arResult);
echo "</pre>";*/
?>
<?if(count($arResult)>0):?>

<script type="text/javascript" src="/bitrix/templates/.default/js/swfobject.js"></script>
<script type="text/javascript" src="/bitrix/templates/bmw_inner_2/js/configuration.js"></script>
<script type="text/javascript" src="/bitrix/templates/bmw_inner/js/models.js"></script>

<script type="text/javascript">
  var oneTextOnly = false;
  
  highbandUser = true;

  function onLoadFunctions(){
    
	if (confBrowserCheckEnabled) {
      checkBrowser(confIncompatibleBrowserUrl);
    }
    var moduleNavigation = false;
  
    //highlightNavigations(false, moduleNavigation);
	
	if (highbandUser) {
      wrapperSwf = /* VIPURL */"/_common/flash/wrapper_modules.swf";
      var slideShowSwf = new SWFObject(wrapperSwf, "imageSlideShowSwf", "1024", "303", "8", "#ffffff");
      slideShowSwf.addParam("allowScriptAccess", "sameDomain");
      slideShowSwf.addParam("wmode", "transparent");
      slideShowSwf.addVariable("prm_contentgetter", "imageSlideShowGetFlashContent");

      flashDetected = slideShowSwf.write("mainImage");
     
	 if(flashDetected) {
        document.getElementById("mainImage").style.left = "-225px";
        document.getElementById("mainImage").style.width = "1024px";
      }
    }
    setVisibility("mainImage",1);
    displaySlide(0);

    setImgBorderPermanent(0);


    checkWindowSize();
  }

  var slideCount = <?=count($arResult)?>;
</script>

<script>
$(document).ready(function(){
    setImgBorderPermanent(0);
    setVisibility("mainImage",1);
    //displaySlide(0);
	onLoadFunctions();
});
//var slideCount = <?=count($arResult)?>;
</script>

<?
/*---------------ОТОБРАЖЕНИЕ ИНФОРМАЦИИ ( в зависимости от гет переменных )---------------*/
$content_style="";
$style="";
if (!IsIE()) $content_style="padding-left:60px;";

//$complete_style="top:288px;";
//$content_style="left:0px;padding-top:40px;";
//$complete_style="top:8px;padding-left:0px;";
//$content_style="left:5px;padding-top:4px;";
$complete_style="margin: 10px 0 0 35px;";
?>
<script>
    imageDatabase = {};
    imageDatabase.swfurl = '/_common/flash/slideshow.swf';
    imageDatabase.images = [];
    <?
    $count=0;
    foreach ($arResult as $tmp_page):?>
        imageDatabase.images[<?=$count?>] = '<?=$tmp_page["DETAIL"]?>';
    <?
        $count++;
    endforeach;?>
</script>

<div id="mainImage" style="margin-top: -91px;">
    <img id="displayedImage" src="">
</div>

<div class="divSlider">
<div id="imagebar">
<?
$count=0;
foreach ($arResult as $tmp_page):if (!strlen($tmp_page["PREVIEW"])) continue;?>
    <a href="javascript:displaySlide(<?=$count?>);" onmouseover="setImgBorder(<?=$count?>);" class="thumbLink"><img src="<?=$tmp_page["PREVIEW"]?>" width="33" height="23"></a>
    <?
    $count++;
endforeach;?>
</div>

<div id="imgBorder"></div>

<div id="imgBorderPermanent">
    <img src="/images/sedan/highlight_box_37x29.gif" border="0" width="37" height="29"><br />
</div>
</div>

<div style="<?=$complete_style?>">
    <?$count=0;
    foreach ($arResult as $tmp_page):?>
        <div id="completeText<?=$count?>" class="completeText" <?if (strlen($tmp_page["NAME"])==0):?>style="top:10px;"<?endif?>>
            <?if (strlen($tmp_page["NAME"])>0):?>
                <div id="headlines">
                    <h3><?=$tmp_page["NAME"]?></h3>
                </div>
            <?endif?>
            <div id="copyText">
                <p id="copyTextP<?=$count?>" onMouseover="setElementClass('a','TLcontextlink','TLcontextlinkHigh');" onMouseout="setElementClass('a', 'TLcontextlinkHigh', 'TLcontextlink');" ><?=$tmp_page["TEXT"]?></p>
            </div>
            <div class="divWidth514">
                <?if ($count<(count($arResult)-1)):?><a href="javascript:displaySlide(<?=($count+1)?>)" class="arrow">Продолжение: <?=$arResult[$count+1]["NAME"]?></a><br/><?endif?>
                <?if ($count>0):?><a href="javascript:displaySlide(<?=($count-1)?>)" class="arrow">Назад:  <?=$arResult[$count-1]["NAME"]?></a><?endif?>
            </div>
            <div class="noOfPages">Страница <?=($count+1)?> из <?=count($arResult)?></div>
        </div>

        <?$count++;
    endforeach;?>
</div>    
      
<?endif?>