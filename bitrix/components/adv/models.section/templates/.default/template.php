<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
$APPLICATION->AddChainItem($arResult["UF_FULLNAME"],"/cars/".$_REQUEST['SECTION_ID']);
$detail_text = '';
$section_id=($arResult["CODE"])?$arResult["CODE"]:$arResult["ID"];
?>

<div style="Z-INDEX: 20; OVERFLOW: hidden; WIDTH: 100%; POSITION: absolute; TOP: 290px; HEIGHT: 15px;left:0px;">
<div style='float:left;border-bottom:1px solid #93908e;width:973px;'>&nbsp;</div>
	<div class="nextteaserbtn" id="nextteaserbtn1" style='margin-left:970px;//margin-left:0px;'>
		<a onmouseover="document.getElementById('nextbtn').src='/images/next-h.gif';" onclick="ch_image();return false;" onmouseout="document.getElementById('nextbtn').src='/images/next.gif';" href="#"><img id="nextbtn" src="/images/next.gif" /></a>
	</div>
</div>

<div id="completeText" style="width:90%; left:20px; top:180px;padding-left:0px !important;">

<table cellspacing="0" cellpadding="0" border="0" style="margin-left: 35px;">
	<tbody>
		<tr>
		<?$i=0;
		foreach($arResult["ITEMS"] as $iid=>$arElement)
		{
			if(($i%$arParams["LINE_ELEMENT_COUNT"]==0) and ($i>0))
			{?>
				</tr><tr>
			<?}?>
			<?if($arElement["PROPERTIES"]["MENU_LINK2SECT"]["VALUE"]!="Y")
			{
				if($arElement["PROPERTIES"]["SERIESIMG"]["VALUE"] != '')
				{	
					$imgs[$iid]["IMG"] = CFile::GetPath($arElement["PROPERTIES"]["SERIESIMG"]["VALUE"]);
					$imgs[$iid]["IMG_ALT"] = ($arElement["PROPERTIES"]["SERIESIMG_ALT"]["VALUE"] != "" ? $arElement["PROPERTIES"]["SERIESIMG_ALT"]["VALUE"]:"");
					
					if($arElement["PROPERTIES"]["SERIESIMG2"]["VALUE"] != '')
					{
						$imgs[$iid]["IMGHOVER"] = CFile::GetPath($arElement["PROPERTIES"]["SERIESIMG2"]["VALUE"]);
						$imgs[$iid]["IMGHOVERLEFT"] = $arElement["PROPERTIES"]["SERIESIMG2LEFT"]["VALUE"];
						$imgs[$iid]["IMGHOVERTOP"] = $arElement["PROPERTIES"]["SERIESIMG2TOP"]["VALUE"];
					}
				}
				$i++;
				$file = CFile::ResizeImageGet($arElement["PROPERTIES"]["MENUIMG"]["VALUE"], array('width'=>162, 'height'=>70), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
				<td>
					<img height="30" width="1" src="/images/1x1_trans.gif"><br>
					<img src="<?=$file["src"];?>"><br>
					<img height="23" width="1" src="/images/1x1_trans.gif">
					<table style="border-collapse: collapse;">
						<tr valign="top">
							<td style="border-left:1px solid #999999;background-color: #fff;" width="0" height="100" valign="top">
							</td>
							<td>
								<h5 style="font-size:11px;line-height:12px;padding-bottom:0;color:#000000;font-weight:bold;margin:0;min-width: 140px;"><?=$arElement["NAME"]?></h5>
								<ul class="linkList" style="font-size:11px; line-height:12px; list-style-type:none; margin:0; padding:0;">
									<li><a class="arrow" rel="nofollow" href="/cars/<?=$section_id?>/<?=(!empty($arElement['CODE']) ? $arElement['CODE'] : $arElement['ID'])?>/"><img alt="" src="/images/1x1_trans.gif">Обзор</a></li>
									<?foreach($arElement["LINKS"] as $link)
									{?>
										<li><a class="arrow" <?=preg_match("~^http://~", $link["URL"]) ? 'target="_blank"' : ''?> href="<?=$link["URL"]?>"><?=$link["NAME"]?></a></li> 
									<?}?>
								</ul>
							</td>
						</tr>
					</table>
				</td>       
				<td width="8">
					<img height="1" width="8" src="/images/1x1_trans.gif">
				</td> 
			<?}
			else
			{
				if(strlen($arElement["DETAIL_TEXT"]))
				{
					$detail_text = $arElement["DETAIL_TEXT"];
				}
			}
		}
		if($i%$arParams["LINE_ELEMENT_COUNT"]==0)
		{?>
			</tr>
			<tr>		
		<?}?>
			<td>
				<img height="30" width="1" src="/images/1x1_trans.gif"><br>
				<img height="70" width="162" src="/images/usedvehicles.jpg"><br>
				<img height="23" width="1" src="/images/1x1_trans.gif">
				<table style="border-collapse: collapse;">
					<tr valign="top">
						<td style="border-left:1px solid #999999;background-color: #fff;" width="0" height="100" valign="top">
						</td>
						<td>
							<h5 style="font-size:11px;line-height:12px;padding-bottom:0;color:#000000;font-weight:bold;margin:0;">Автомобили BMW с пробегом</h5>
							<img height="3" width="1" src="/images/1x1_trans.gif"><br>
							<ul class="linkList" style="font-size:11px; line-height:12px; list-style-type:none; margin:0; padding:0;">   
								<li><a class="arrow" rel="nofollow" href="/used/premium_selection/"><img alt="" src="/images/1x1_trans.gif">BMW Premium Selection</a></li>          
								<li><a class="arrow" href="http://www.indepused.ru/cars/bmw"><img alt="" src="/images/1x1_trans.gif">BMW с пробегом</a></li>
							</ul>
							<img height="1" width="135" src="/images/1x1_trans.gif"><br>
						</td>
					</tr>
				</table>
			</td>
			<td width="41">
				<img height="1" width="41" src="/images/1x1_trans.gif">
			</td>	
			<?$i++;
			while($i%$arParams["LINE_ELEMENT_COUNT"]>0)
			{
				$i++;?>
				<td>
				</td>
				<td>
				</td>
			<?}?>
		</tr>
	</tbody>
</table>






<?/*$count=0;
while ($count<=count($arResult["ITEMS"])):
	
	$i=0;
	$j=0;?>
	
	<table cellspacing="0" cellpadding="0" border="0" style="margin-left: 35px;">
		<tbody>
			<tr>
			
		<?while (($i<5) && (($count+$j)<count($arResult["ITEMS"])))
		{?>
	
			<?$arElement = $arResult["ITEMS"][$count+$j];?>
	
			<?if($arElement["PROPERTIES"]["MENU_LINK2SECT"]["VALUE"]!="Y")
			{
				
				if($arElement["PROPERTIES"]["SERIESIMG"]["VALUE"] != '') {
					
					$imgs[$count+$i]["IMG"] = CFile::GetPath($arElement["PROPERTIES"]["SERIESIMG"]["VALUE"]);
					$imgs[$count+$i]["IMG_ALT"] = ($arElement["PROPERTIES"]["SERIESIMG_ALT"]["VALUE"] != "" ? $arElement["PROPERTIES"]["SERIESIMG_ALT"]["VALUE"]:"");
					
					if($arElement["PROPERTIES"]["SERIESIMG2"]["VALUE"] != '') {
						$imgs[$count+$i]["IMGHOVER"] = CFile::GetPath($arElement["PROPERTIES"]["SERIESIMG2"]["VALUE"]);
						$imgs[$count+$i]["IMGHOVERLEFT"] = $arElement["PROPERTIES"]["SERIESIMG2LEFT"]["VALUE"];
						$imgs[$count+$i]["IMGHOVERTOP"] = $arElement["PROPERTIES"]["SERIESIMG2TOP"]["VALUE"];
					}
				}
				
				/*if(strlen($arElement["PROPERTIES"]["ALLFACTS"]["VALUE"]))
				{
					$arFilter = Array('IBLOCK_ID'=>193, 'SECTION_ID'=>$arElement["PROPERTIES"]["ALLFACTS"]["VALUE"]);
					$db_list = CIBlockSection::GetList(Array(), $arFilter, true);
					while($ar_section = $db_list->GetNext())
					{
						if(preg_match("~Все факты~", $ar_section["NAME"]))
						{
							$arFilter = Array(
							   "IBLOCK_ID"=>193,
							   "ACTIVE"=>"Y",
							   "SECTION_ID"=>$ar_section["ID"],
							   "INCLUDE_SUBSECTIONS"=>"Y",
							   );
							$res = CIBlockElement::GetList(Array(), $arFilter,false,false, Array("ID","IBLOCK_SECTION_ID"));
							if($ar_els = $res->GetNext())
							{
							  $show_facts[$arElement['ID']]=true;
							  $arElement["FACT_LINK"]="1/cars/".$section_id."/".$arElement['ID']."/".$ar_els["IBLOCK_SECTION_ID"]."/".$ar_els["ID"]."/";
							}
						}
					}
				}*//*?>
	
		   
				<td>
					<img height="30" width="1" src="/images/1x1_trans.gif"><br>
					<img height="70" width="162" src="<?=CFile::GetPath($arElement["PROPERTIES"]["SERIESPREV"]["VALUE"]);?>"><br>
					<img height="23" width="1" src="/images/1x1_trans.gif">
				</td>
				<td>
					<img height="1" width="30" src="/images/1x1_trans.gif">
				</td>		  		
	
				<?$i++;?>
			<?}
			else
			{?>
				<?if(strlen($arElement["DETAIL_TEXT"])):?>
					<?$detail_text = $arElement["DETAIL_TEXT"];?>
				<?endif;?>	
			<?}?>
	
			<?$j++;?>
			
			<?if((($count+$j)>=count($arResult["ITEMS"])) && ($i<5))
			{?>
				
				<td>
					<img height="30" width="1" src="/images/1x1_trans.gif"><br>
					<img height="70" width="162" src="/images/usedvehicles.jpg"><br>
					<img height="23" width="1" src="/images/1x1_trans.gif">
				</td>
				
				<?$i++;
				
				while($i<5)
				{?>
					
					<td>
						<img height="1" width="30" src="/images/1x1_trans.gif">
					</td>
					
					<?$i++;
					
				}?>
				
			<?}
			
		}?>

			</tr>
		</tbody>
	</table>
	
	<?$i=0; $j=0;?>
	
	<table cellspacing="0" cellpadding="0" border="0" style="margin-left: 15px">         
		<tbody>
			<tr>
			
		<?while (($i<5) && (($count+$j)<count($arResult["ITEMS"]))):?>
	
			<?$arElement = $arResult["ITEMS"][$count+$j];?>
	
			<?if($arElement["PROPERTIES"]["MENU_LINK2SECT"]["VALUE"]!="Y"):?>
				<td width="8">
					<img height="1" width="8" src="/images/1x1_trans.gif">
				</td>
				<td bgcolor="#999999" width="1" valign="top">
					<img height="1" width="1" src="/images/1x1_ffffff.gif">
					<img height="107" width="1" src="/images/1x1_trans.gif">
				</td>
				<td width="8">
					<img height="1" width="8" src="/images/1x1_trans.gif">
				</td>
				<td width="135" valign="top">
					<h5 style="font-size:11px;line-height:12px;padding-bottom:0;color:#000000;font-weight:bold;margin:0;"><?=$arElement["NAME"]?></h5>
					<img height="3" width="1" src="/images/1x1_trans.gif"><br>
					<ul class="linkList" style="font-size:11px; line-height:12px; list-style-type:none; margin:0; padding:0;">
						<li>
							<?if(strlen($arElement["PROPERTIES"]["link"]["VALUE"])):?>
							<a class="arrow" <?=preg_match("~^http://~", $arElement["PROPERTIES"]["link"]["VALUE"]) ? 'target="_blank"' : ''?> href="<?=$arElement["PROPERTIES"]["link"]["VALUE"]?>"><?=$arElement["NAME"]?></a> 
							<br/>
							<?elseif(!isset($datalinks[$arElement['ID']]['about']) || $datalinks[$arElement['ID']]['about']!='0'):?>
							<a class="arrow" href="/cars/<?=$section_id?>/<?=(!empty($arElement['CODE']) ? $arElement['CODE'] : $arElement['ID'])?>/">Обзор</a> <br/>
							<?endif;?>
						</li>
<?
if(isset($datalinks[$arElement['ID']])) {
if(isset($datalinks[$arElement['ID']]['foto'])) echo '<li><a class="arrow" href="'.$datalinks[$arElement['ID']]['foto'].'">Фотогалерея</a></li>';                        
if($datalinks[$arElement['ID']]['mm']!='') echo '<li><a class="arrow" href="'.$datalinks[$arElement['ID']]['mm'].'">Мультимедийная презентация</a></li>';                        
if($datalinks[$arElement['ID']]['v360']!='') echo '<li><a class="arrow" href="'.$datalinks[$arElement['ID']]['v360'].'">Визуализатор 360°</a></li>';						
if($datalinks[$arElement['ID']]['allf']!='') echo '<li><a class="arrow" href="'.$datalinks[$arElement['ID']]['allf'].'">Все факты</a></li>';
if($datalinks[$arElement['ID']]['conf']!='0') echo '<li><a class="arrow" href="http://www.bmw.ru/ru/ru/general/carconfigurator/content.html" target="_blank"><img alt="" src="/images/1x1_trans.gif">Конфигуратор</a></li>';
if($datalinks[$arElement['ID']]['testdrv']!='0') echo '<li><a class="arrow" href="/testdrive/testdrive.php"><img alt="" src="/images/1x1_trans.gif">Заказать тест-драйв</a></li>';
}
?>                        
					</ul>
					<img height="1" width="135" src="/images/1x1_trans.gif"><br>
				</td>       
				<td width="41">
					<img height="1" width="41" src="/images/1x1_trans.gif">
				</td>
				
				<?$i++;?>
	
			<?endif;?>
	
			<?$j++;?>
			
			<?if((($count+$j)>=count($arResult["ITEMS"])) && ($i<5)):?>
				
				<td width="8"><img height="1" width="8" src="/images/1x1_trans.gif"></td>
				<td bgcolor="#999999" width="1" valign="top">
					<img height="1" width="1" src="/images/1x1_ffffff.gif">
					<img height="107" width="1" src="/images/1x1_trans.gif"></td>
				<td width="8"><img height="1" width="8" src="/images/1x1_trans.gif"></td>
				<td width="145" valign="top">
					<h5 style="font-size:11px;line-height:12px;padding-bottom:0;color:#000000;font-weight:bold;margin:0;">Автомобили BMW с пробегом</h5>
					<img height="3" width="1" src="/images/1x1_trans.gif"><br>
					<ul class="linkList" style="font-size:11px; line-height:12px; list-style-type:none; margin:0; padding:0;">   
						<li><a class="arrow" rel="nofollow" href="/used/premium_selection/"><img alt="" src="/images/1x1_trans.gif">BMW Premium Selection</a></li>          
						<li><a class="arrow" href="http://www.indepused.ru/cars/bmw"><img alt="" src="/images/1x1_trans.gif">BMW с пробегом</a></li>
					</ul>
					<img height="1" width="135" src="/images/1x1_trans.gif"><br>
				</td>
				<td width="41"><img height="1" width="41" src="/images/1x1_trans.gif"></td>
				
				<?$i++; $j++;?>								
				
			<?endif;?>
	
		<?endwhile;?>
				
			</tr>
		</tbody>
	</table>
	
	<?
	if($j!=0)
	{
	$count+=$j;
	}
	else
	{
	$count++;
	}
	?>
	
<?endwhile;*/?>
<div><?=$detail_text?></div>
<br/> <br/>
<div class="menu-clear-left"></div>
<div style='padding-left:10px;padding-bottom:40px;width:700px;'>
</div>
</div>
<?if (ereg('/cars/bmw_1series/', $APPLICATION->GetCurPage())):?>
<p style="position: absolute; top: 125px; width: 800px; margin-left: 50px;">
<b>BMW 1 серии</b> - стильный автомобиль, который выделяется своим внешним видом среди конкурентов. Элегантный, воплотивший в себе классические формы БМВ, и в то же время выглядящий как машина будущего. Кроме внешних форм, BMW 1 есть чем похвастать - технические характеристики так же на высоте - восемь вариантов дизельного или бензинового двигателя, мощностью до 200 «лошадей». 7-ступенчатый спортивный «автомат» с двойным сцеплением или 6-ступенчатая динамичная «механика»,  сниженный расход топлива и выхлоп, соответствующий экологическим нормам Евро-5. БМВ 1 - это автомобиль, созданный для активных людей, которые ценят комфорт и надежность. На страницах нашего сайта вы сможете более подробно узнать о технических характеристиках, ценах и комплектациях моделей BMW.
</p>
<?elseif (ereg('/cars/bmw_3series/', $APPLICATION->GetCurPage())):?>
<p style="position: absolute; top: 113px; width: 800px; margin-left: 50px;">
За почти 40 лет, что производится <b>BMW 3 серии</b>, авто успешно пережило уже серию рестайлингов и в этом году свет увидело 6 поколение БМВ 3 (BMW F30). Автомобиль недаром неоднократно становился самым продаваемым в своем классе, потеснив с «насиженных» мест даже более дешевые модели. Это один из немногих автомобилей, сочетающих в себе доступность, комфортабельность, эффектный внешний вид и безопасность. Настоящее немецкое авто воплотившее в себе радугу дизайнерских эмоций. Узнаваемый стиль BMW 3 серии прослеживается в каждой детали от решетки радиатора до изгибов кузова. В то же время кузов увеличился по сравнению с предыдущим поколением, а сама модель стала ближе к спортивному и дерзкому виду БМВ 5 серии. Претерпел изменения и внутренний интерьер автомобиля - больше хрома и глянца, упор на классическое красно-черное сочетание, подсветка приборной панели и кожаные сидения. Ниже вы сможете посмотреть фотографии и получить более полную информацию о технических характеристиках, ценах и комплектациях моделей BMW, обновленных весной этого года.
</p>
<?elseif (ereg('/cars/bmw_5series/', $APPLICATION->GetCurPage())):?>
<p style="position: absolute; top: 105px; width: 800px; margin-left: 50px;">
<b>BMW 5 серии</b> отличается от собратьев вытянутым стремительным силуэтом и фарами нестандартной формы, что придает ему агрессивный и современный вид. Технические характеристики автомобилей БМВ 5 под стать внешнему виду – это автомобиль, созданный для агрессивной скоростной езды в самых разных условиях. Но при этом BMW 520 или BMW 525 может стать и семейным автомобилем, в котором так приятно отправиться за покупками или выехать за город. Ниже на страницах сайта вы сможете познакомиться с техническими характеристиками, ценами и комплектациями моделей BMW.
</p>
<?elseif (ereg('/cars/bmw_6series/', $APPLICATION->GetCurPage())):?>
<p style="position: absolute; top: 120px; width: 800px; margin-left: 50px;">
Выпускаемые еще с 1975 года автомобили <b>BMW 6 серии</b> всегда были престижным транспортным средством бизнес-класса. Все самое лучшее – спортивный кузов, мощный двигатель, высочайшая комфортабельность и надежность – собрано в этом авто. При всей своей непохожести на другие модели, в автомобиле БМВ 6 сразу узнается производитель. Стремительный и устойчивый на трассе корпус позволит вам почувствовать себя хозяином дороги, повелителем скорости, оседлавшем молнию. Автомобиль может быть представлен во многих модификациях – с 4-х, 6-ти и 8-ми цилиндровым двигателем объемом до 4,5 тыс. куб. см., массой немногим менее 2-х тонн и мощностью двигателя 320-400 л.с., что позволяет набирать скорость 100 км/ч всего за 5 секунд. Все модели имеют богатую внутреннюю отделку и увеличенную комфортабельность салона.
</p>
<?elseif (ereg('/cars/bmw_7series/', $APPLICATION->GetCurPage())):?>
<p style="position: absolute; top: 125px; width: 800px; margin-left: 50px;">
Технические характеристики, цены и комплектация моделей <b>BMW 7 серии</b> говорят сами за себя – перед вами лучший на сегодня автомобиль, достойный того, чтобы вы были его владельцем. И пять успешных поколений люкс-класса – главное тому подтверждение. Благодаря применению новых материалов – таких как алюминий и его сплавы – в конструкции ходой, БМВ 7 серии отличается высокой точностью управления. Новые обводы кузова, измененная форма ксеноновых фар и применение хромированных деталей делает автомобиль BMW 7 серии непохожим на конкурентов, дерзким и динамичным. А шестиступенчатая коробка-«автомат» позволит вам всегда быть в центре внимания. Далее на сайте вы сможете посмотреть изображения и узнать более подробные характеристики и условия приобретения автомобилей БМВ 7.
</p>
<?elseif (ereg('/cars/bmwmseries/', $APPLICATION->GetCurPage())||ereg('/cars/bmw_mseries/', $APPLICATION->GetCurPage())):?>
<p style="position: absolute; top: 125px; width: 800px; margin-left: 50px;">
Автомобиль <b>BMW M3</b> представляет собой улучшенную модификацию стандартного <a href="http://www.bmw-indep.ru/cars/bmw_3series/">БМВ 3 серии</a>. Улучшенная подвеска, более мощный и оборотистый двигатель, агрессивный кузов, измененный внешний вид и салон повышенной комфортабельности – вот основные отличия данной модификации от стандартной.
<br /><br />
Автомобиль <b>BMW M5</b> это доработанная компанией модель стандартного <a href="http://www.bmw-indep.ru/cars/bmw_5series/">БМВ 5 серии</a> с уклоном на более спортивный и агрессивный стиль езды и улучшенным внешним видом и интерьером салона.
<br /><br />
Автомобиль <b>BMW M6</b> – старший брат модели <a href="http://www.bmw-indep.ru/cars/bmw_6series/">БМВ 6</a>. Данная модификация была разработана спортивным подразделением компании и в современном виде выпускается с 2005 года. Машина буквально нашпигована электроникой, что позволяет ей быть одной из лучших моделей современности.
</p>
<?endif?>
<?$curImg=current($imgs)?>
<div id="largeTeaser">
	<img id='TeaserImg' src='<?=$curImg["IMG"]?>' alt='<?=($curImg["IMG_ALT"] != "" ? $curImg["IMG_ALT"]:"")?>' onmouseover="document.getElementById('imgHoverTeaser').style.display ='block';" onmouseout="document.getElementById('imgHoverTeaser').style.display ='none';"/>
	<div id='imgHoverTeaser' style='position:absolute;left:<?=$curImg["IMGHOVERLEFT"]?>px;top:<?=$curImg["IMGHOVERTOP"]?>px;display:none;'>
		<img id='imgHover'src='<?=$imgs[0]["IMGHOVER"]?>' onmouseover="document.getElementById('imgHoverTeaser').style.display ='block';"/>
	</div>
</div>

<?$cnt = count($imgs)-1;?>
<script>
var imgs = new Array();
var imgs_alt = new Array();
var imgsH = new Array();
var imgsHL = new Array();
var imgsHT = new Array();
<?foreach($imgs as $k=>$img):?>
imgs[<?=$k?>] = '<?=$img["IMG"]?>';
imgs_alt[<?=$k?>] = '<?=$img["IMG_ALT"]?>';
imgsH[<?=$k?>] = '<?=$img["IMGHOVER"]?>';
imgsHL[<?=$k?>]= '<?=$img["IMGHOVERLEFT"]?>';
imgsHT[<?=$k?>]= '<?=$img["IMGHOVERTOP"]?>';
<?endforeach;?>
var showed = 0;

function ch_image() {
	if(showed == <?=$cnt?>) { showed = 0; }else{ showed = showed+1; }
		document.getElementById("TeaserImg").src = imgs[showed];
		document.getElementById("TeaserImg").alt = imgs_alt[showed];
		document.getElementById('imgHoverTeaser').style.top = imgsHT[showed];
		document.getElementById('imgHoverTeaser').style.left = imgsHL[showed];
		document.getElementById('imgHover').src = imgsH[showed];
	}
</script>

<pre><?//print_r($arResult)?></pre>