<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?

?>
  <script type="text/javascript">
    var bottomNavigationLoaded=false;
    var attributeTitle = "<?=$APPLICATION->ShowTitle()?>";
    confCountryTopic = "com";
    confLanguageTopic = "en";

    $(document).ready(function(){
      initStandardPage();
      mainNavigation.initFolding( 10, 20 );

	if(undefined != window.flashObject || null != window.flashObject){
		flashObject.write("highlightsMainContainer");
	}

      $("#highlightsMainContainer").show();
    });
  </script>

  
  
<?
echo $arResult['ELEMENT']['FIELDS']['~DETAIL_TEXT'];

//new dBug($arResult['ELEMENT']);
?>
  
  

  <div id="highlightsMainContainer">
    <div id="textBlockNoImage">

      <p>
        ��� ��������� ����������� ���� �������� ���������� ���������� ��������� ������ ������������� Flash Player.
        <br>
        <a href="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" target="getflash" class="standard"><img src="<?=$this->GetFolder()?>/1x1_trans.gif" alt="">��������� ������������� Adobe Flash Player</a>
      </p>
    </div>
  </div>

  <div id="highlightDialogButtons">

    <a class="dialogButtonShare" id="shareDialog" href="" onclick="return false;"></a>
    <a class="dialogButtonFavorite" id="favoriteDialog" href="" onclick="return false;"></a>

  </div>

  <div id="favoriteDialogLayer" class="dialogbox">
    <div class="content">
      <div id="favoriteNotActive">�������� � ���������</div>
      <div id="favoriteActive">��������� � ���������</div>

      <div id="favoriteNoCookie">����� cookies ���������</div>
    </div>
  </div>