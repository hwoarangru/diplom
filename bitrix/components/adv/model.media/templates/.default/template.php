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
$tmplCssItem = <<<CSS
    div#mediaGalleryThumbnailsMouseoverLayer%1\$s {
      position: absolute;
      width: 118px;
      visibility: hidden;
      z-index: 100;
    }
CSS;
$tmplPreviewPhoto = <<<HTML
	<img class='thumbImage' src='%1\$s' width='%2\$s' height='%3\$s' border='0' /> 
HTML;
$tmplPreviewVideo = <<<HTML
	<img class='thumbImage' src='%1\$s' width='%2\$s' height='%3\$s' border='0' /> 
HTML;
$tmplIncreaseItem = <<<HTML
      <div id='mediaGalleryThumbnailsMouseoverLayer%1\$s' class='dialogbox'> 
        <div class='content'> 
          %2\$s
        </div> 
      </div>
HTML;
$tmplLinkPhoto = <<<HTML
            <div class='downloadLayer'> 
              <strong>���������</strong> 
              <ul class='linklist'> 
                %1\$s
              </ul> 
              <br style='clear:both;'> 
            </div>
HTML;
$tmplLinkVideo = <<<HTML
          <div class='downloadLayer'> 
              <strong>���������</strong> 
              	%1\$s 
              <br style='clear:both;'> 
            </div> 
HTML;




$arPhotoPreviewHTML = array();
$arItemCssHTML = array();
$arLBJSItem = array();

//$iCounter = 0;
foreach ($arResult['PHOTO'] as $arPhoto) 
{
	$arItemCssHTML[] = sprintf($tmplCssItem, $iCounter);
	$arPhotoPreviewHTML[] = sprintf($tmplPreviewPhoto
		, $arPhoto['PREVIEW_PICTURE']['RES']
		, 110
		, 62
	);
	$arItemIncreaseHTML[] = sprintf($tmplIncreaseItem, $iCounter, "���������");

	$arr = array();
	if ($arPhoto['WP_1600x1200']['PATH'])
	{
		$arr[] = sprintf("<li><a href='%1\$s' class='standard'>�����������: %2\$s x %3\$s</a></li>"
			, $arPhoto['WP_1600x1200']['PATH']
			, 1600
			, 1200
		);
	}
	if ($arPhoto['WP_1920x1200']['PATH'])
	{
		$arr[] = sprintf("<li><a href='%1\$s' class='standard'>��������������: %2\$s x %3\$s</a></li>"
			, $arPhoto['WP_1920x1200']['PATH']
			, 1920
			, 1200
		);
	}

	$arPhotoItemLinkHTML[] = sprintf($tmplLinkPhoto, implode("\n", $arr));
	$arLBJSItem[] = array(
		  'category' => 0
		, 'type' => 'image'
		, 'parameter' => '#mediaID-' . $iCounter
		, 'hoverText' => '���������'
		, 'subheadline' => ''
		, 'width' => $arPhoto['DETAIL_PICTURE']['WIDTH']
		, 'height' => $arPhoto['DETAIL_PICTURE']['HEIGHT']
		, 'src' => $arPhoto['DETAIL_PICTURE']['PATH']
		, 'isVisible' => false
	);
	$iCounter++;
}


//$iCounter = 0;
foreach ($arResult['VIDEO'] as $arVideo) 
{
	$arVideoPreviewHTML[] = sprintf($tmplPreviewVideo
		, $arVideo['PREVIEW_PICTURE']['PATH']
		, 110
		, 62
	);
	
	$arr = array();
	if ($arVideo['FILE']['WMV']['PATH'])
	{
		$arr[] = sprintf("<ul class='linklist'><li><a href='%1\$s' class='standard'>%2\$s</a></li></ul>"
			, $arVideo['FILE']['WMV']['PATH']
			, 'WMV'
		);
	}
	if ($arVideo['FILE']['IPOD']['PATH'])
	{
		$arr[] = sprintf("<ul class='linklist'><li><a href='%1\$s' class='standard'>%2\$s</a></li></ul>"
			, $arVideo['FILE']['IPOD']['PATH']
			, 'iPod'
		);
	}
	if ($arVideo['FILE']['MOV']['PATH'])
	{
		$arr[] = sprintf("<ul class='linklist'><li><a href='%1\$s' class='standard'>%2\$s</a></li></ul>"
			, $arVideo['FILE']['MOV']['PATH']
			, 'MOV'
		);
	}
	
	
	$arVideoItemLinkHTML[] = sprintf($tmplLinkVideo, implode("\n", $arr));
	$arLBJSItem[] = array(
		  'category'	=> '1'
		, 'type'		=> 'flash'
		, 'parameter'	=> '#mediaID-'.$iCounter
		, 'hoverText'	=> '���������������'
		, 'subheadline'	=> ''
		, 'width'		=> 482
		, 'height'		=> 264
		, 'src'			=> $this->GetFolder() . '/swf/flv_player.swf'
		, 'flashParameter'	=> $arVideo['FILE']['FLV']['PATH']
//		, 'flashParameter'	=> "/upload/video/3seriescoupe/001/_flv/video_preview_en.flv"
		, 'isVisible'	=>	false
	);
	$arItemIncreaseHTML[] = sprintf($tmplIncreaseItem, $iCounter, "���������������");
	$iCounter++;
}


?>

<style type="text/css"> 
	<?=implode("\n", $arItemCssHTML)?>
</style> 
 
<script type="text/javascript"> 
	var lightboxContent = <?=CUtil::PhpToJsObject($arLBJSItem)?> 
  
	for (i in lightboxContent)
	{
		lightboxContent[i]['width'] = Number(lightboxContent[i]['width'])
		lightboxContent[i]['height'] = Number(lightboxContent[i]['height'])
	}
  
	$(document).ready(function() {
		mediaGalleryInitialise();
	});
 
</script> 

 
      <div id="stage"> 
        <img src="<?if($arResult['MODEL']['PROPS']['GALLERY']['GALLERY_PIC']['SRC']) {echo $arResult['MODEL']['PROPS']['GALLERY']['GALLERY_PIC']['SRC'];} else {echo $this->GetFolder().'/img/background.jpg';}?>" width="1024" height="634" alt="Overview" />
      </div> 
 
<!-- start: media gallery content --> 
      <div id="mediaGalleryCategoriesLayer"> 
        <div class='category'> 
          <span class='headline'>���� ��� �������� �����</span> 
			<?=implode("\n", $arPhotoPreviewHTML)?>
        </div> 
 
<?if(isset($arVideoPreviewHTML)):?>
        <div class='category'> 
          <span class='headline'>�����</span> 
          	<?=implode("\n", $arVideoPreviewHTML)?>
        </div> 
 <?endif;?> 
      </div> 

	<?=implode("\n", $arItemIncreaseHTML)?>
 <?/*?>
      <div id="mediaGalleryDialogButtons"> 
        <img class="shareButton" src="<?=$this->GetFolder()?>/img/1x1_trans.gif" width="15" height="15" border="0" /> 
        <a class="dialogButtonShare" href="" onclick="return false;"></a> 
        <a class="dialogButtonFavorite" id="favoriteDialog" href="" onclick="return false;"></a> 
      </div> 
 <?*/?>
 <?/*?>
      <div id="favoriteDialogLayer" class="dialogbox"> 
        <div class="content"> 
          <div id="favoriteNotActive">�������� � ���������</div> 
		  <div id="favoriteActive">��������� � ���������</div> 
		  <div id="favoriteNoCookie">����� cookies ���������</div> 
        </div> 
      </div> 
 <?*/?>
      <div id="mediaGalleryLightboxLayer"> 
        <a href="#" class="closeLink" onfocus="this.blur();"><div id="blackLayer"></div></a> 
        <div id="lightbox"> 
          <img id="bigImage" src="<?=$this->GetFolder()?>/img/1x1_trans.gif" width="612" height="383" border="0" /> 
          <div id="embedLayer"></div> 
          <div id="flashLayer"></div> 
          <div id="closeButtonLayer"> 
            <a href="#" class="closeLink" onfocus="this.blur();"><img src="<?=$this->GetFolder()?>/img/1x1_trans.gif" width="15" height="15" border="0" /></a> 
          </div> 
          <div id="textLayer"> 
			<?=implode("\n", $arPhotoItemLinkHTML);?>
			<?=implode("\n", $arVideoItemLinkHTML);?>

<?/*?>
            <img class="shareButton" src="<?=$this->GetFolder()?>/img/1x1_trans.gif" width="15" height="15" border="0" /> 
            <a class="dialogButtonShare" href="" onclick="return false;"></a> 
<?*/?>
          </div> 
        </div> 
        <div id="toggleLightboxLayer"> 
          <img class="lightboxArrowLeft leftWhiteArrow" src="<?=$this->GetFolder()?>/img/1x1_trans.gif" width="20" height="48" border="0" /> 
          <img class="lightboxArrowLeft leftBlueArrow" src="<?=$this->GetFolder()?>/img/1x1_trans.gif" width="20" height="48" border="0" /> 
          <img class="lightboxArrowRight rightWhiteArrow" src="<?=$this->GetFolder()?>/img/1x1_trans.gif" width="20" height="48" border="0" /> 
          <img class="lightboxArrowRight rightBlueArrow" src="<?=$this->GetFolder()?>/img/1x1_trans.gif" width="20" height="48" border="0" /> 
        </div> 
      </div> 
      
      
<?
//new dBug($arParams, false, false);
//new dBug($arResult, false, false);
?>