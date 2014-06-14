<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<style type="text/css">
.mainNavigation h1 {
margin-top: 26px;
margin-bottom: 0px;
font-size: 1em;
margin-left: 30px;
}
</style>

<script type="text/javascript">
//Cufon.replace('h1');
//Cufon.replace('h2');
var vehicle_navigation_teaser = "r";
$(document).ready(function(){
	initStandardPage();
});
</script>
	<?if (ereg('/cars/bmw_xseries/bmw_x5/', $APPLICATION->GetCurPage())):?>
		<p style="position: absolute; top: 215px; width: 600px; margin-left: 250px;">
		Автомобиль <b>BMW X5</b> – прекрасный выбор для любителей активного отдыха и путешественников. Он обладает высокой мощностью, благодаря новому 8-цилиндровому двигателю и способен разогнаться до 100 км/ч всего за 6,5 сек. Интеллектуальная система xDrive изменяет нагрузку и крутящий момент между передними и задними колесами в зависимости от характеристик дорожного покрытия, что обеспечивает максимальное сцепление м дорогой и устойчивость. Так же БМВ Х5 оборудован усилителем рулевого управления, системой экономии топлива, специальной системой торможения, подушками безопасности и т.д. Покупка БМВ Х5 в официальном сервисном центре дает вам огромное преимущество, так как новая программа обслуживания БМВ позволяет сохранять всю информацию о состоянии автомобиля на ключ машины. 
		</p>
	<?elseif (ereg('/cars/bmw_xseries/bmw_x3/', $APPLICATION->GetCurPage())):?>
		<p style="position: absolute; top: 125px; width: 600px; margin-left: 250px;">
		На сегодня в мире продано около одного миллиона экземпляров автомобилей BMW Х3, что без сомнения является показателем его популярности. Данная модель отлично подойдет для любителей активного образа жизни и путешественников. Интеллектуальная система xDrive идеально адаптирует работу всех систем автомобиля к дорожному покрытию, поэтому БМВ X3 одинаково уверенно чувствует себя и на городских дорогах, и на автомагистралях, и на проселочной «грунтовке». В России автомобиль <b>BMW X3</b> доступен в двух возможных комплектациях: 2х-литровый дизель с 6-ступенчатой МКПП и 3х-литровый бензиновый двигатель (наддувом Twin Power) с 8-стпенчатой коробкой-автоматом и возможностью переключения в ручной режим. 
		</p>
	<?endif?>
      <div id="stage"><??>
        <img src="<?=CFile::GetPath($arResult['RANGE_SECTION']['PICTURE'])?>" width="1024" height="634" alt="<?=$arParams["NAME"]?>">
      </div>
	  <?if ($arParams["SHOW_BANNER_EFF"]):?>
			<img src="/images/effdyn_logo_gray_new.png" style="position:absolute; top:648px; left:25px"/>
	  <?endif;?>

      <div id="stage_flash"></div>
<script type="text/javascript">
  if(highbandUser) {
    var stageFlash = new SWFObject("<?=CFile::GetPath($arResult['RANGE_SECTION']['UF_FLASH_FILE'])?>", "mainFlashMovie", "1024", "634", "9.0.115", "#ffffff");
    stageFlash.addParam("quality","autohigh");
    stageFlash.addParam("allowScriptAccess", "sameDomain");
    stageFlash.addParam("wmode", "transparent");
    stageFlash.addVariable("prm_corelib","<?=$this->GetFolder()?>/flash/bmw_as3_corelib_1_1.swf");
    stageFlash.addVariable("prm_components","<?=$this->GetFolder()?>/flash/bmw_as3_components_2_0.swf");
    userHasFlash = stageFlash.write("stage_flash");
    $("#stage_flash").show();
  }
</script>

<style>
  #start_headlines h1 
, #start_headlines h2 
, #start_headlines h3 
, #start_headlines h4 
, #start_headlines h5 
, #start_headlines h6 {
	color: #<?=$arResult['TITLE_COLOR']?>;
} 
</style>
	

	  <div id="start_headlines"> 
<?=$arResult['RANGE_SECTION']['~DESCRIPTION']?>
      </div>
      
<!--<div id="facebook_like">
<iframe src="//www.facebook.com/plugins/like.php?href='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] %>&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe>
</div>--> 


<?
//new dBug($arParams, false, false);
//new dBug($arResult, false, false);
//print_r($arParams);
//print_r($arResult);
?>
<?if ($arResult["RANGE_SECTION"]["UF_HOTSPOTS"]):?>
	<script src="<?=SITE_TEMPLATE_PATH?>/js/hotspots.js"></script>
	<link type="text/css" rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/hotspots.css">
	<div id="hotspotsOverviewLayer">
		<?foreach($arResult["RANGE_SECTION"]["UF_HOTSPOTS"] as $hotspot):?>
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