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
									<li><a class="arrow" rel="nofollow" href="/cars/<?=$section_id?>/<?=(!empty($arElement['CODE']) ? $arElement['CODE'] : $arElement['ID'])?>/"><img alt="" src="/images/1x1_trans.gif">�����</a></li>
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
							<h5 style="font-size:11px;line-height:12px;padding-bottom:0;color:#000000;font-weight:bold;margin:0;">���������� BMW � ��������</h5>
							<img height="3" width="1" src="/images/1x1_trans.gif"><br>
							<ul class="linkList" style="font-size:11px; line-height:12px; list-style-type:none; margin:0; padding:0;">   
								<li><a class="arrow" rel="nofollow" href="/used/premium_selection/"><img alt="" src="/images/1x1_trans.gif">BMW Premium Selection</a></li>          
								<li><a class="arrow" href="http://www.indepused.ru/cars/bmw"><img alt="" src="/images/1x1_trans.gif">BMW � ��������</a></li>
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
						if(preg_match("~��� �����~", $ar_section["NAME"]))
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
							<a class="arrow" href="/cars/<?=$section_id?>/<?=(!empty($arElement['CODE']) ? $arElement['CODE'] : $arElement['ID'])?>/">�����</a> <br/>
							<?endif;?>
						</li>
<?
if(isset($datalinks[$arElement['ID']])) {
if(isset($datalinks[$arElement['ID']]['foto'])) echo '<li><a class="arrow" href="'.$datalinks[$arElement['ID']]['foto'].'">�����������</a></li>';                        
if($datalinks[$arElement['ID']]['mm']!='') echo '<li><a class="arrow" href="'.$datalinks[$arElement['ID']]['mm'].'">�������������� �����������</a></li>';                        
if($datalinks[$arElement['ID']]['v360']!='') echo '<li><a class="arrow" href="'.$datalinks[$arElement['ID']]['v360'].'">������������ 360�</a></li>';						
if($datalinks[$arElement['ID']]['allf']!='') echo '<li><a class="arrow" href="'.$datalinks[$arElement['ID']]['allf'].'">��� �����</a></li>';
if($datalinks[$arElement['ID']]['conf']!='0') echo '<li><a class="arrow" href="http://www.bmw.ru/ru/ru/general/carconfigurator/content.html" target="_blank"><img alt="" src="/images/1x1_trans.gif">������������</a></li>';
if($datalinks[$arElement['ID']]['testdrv']!='0') echo '<li><a class="arrow" href="/testdrive/testdrive.php"><img alt="" src="/images/1x1_trans.gif">�������� ����-�����</a></li>';
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
					<h5 style="font-size:11px;line-height:12px;padding-bottom:0;color:#000000;font-weight:bold;margin:0;">���������� BMW � ��������</h5>
					<img height="3" width="1" src="/images/1x1_trans.gif"><br>
					<ul class="linkList" style="font-size:11px; line-height:12px; list-style-type:none; margin:0; padding:0;">   
						<li><a class="arrow" rel="nofollow" href="/used/premium_selection/"><img alt="" src="/images/1x1_trans.gif">BMW Premium Selection</a></li>          
						<li><a class="arrow" href="http://www.indepused.ru/cars/bmw"><img alt="" src="/images/1x1_trans.gif">BMW � ��������</a></li>
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
<b>BMW 1 �����</b> - �������� ����������, ������� ���������� ����� ������� ����� ����� �����������. ����������, ����������� � ���� ������������ ����� ���, � � �� �� ����� ���������� ��� ������ ��������. ����� ������� ����, BMW 1 ���� ��� ���������� - ����������� �������������� ��� �� �� ������ - ������ ��������� ���������� ��� ����������� ���������, ��������� �� 200 ��������. 7-����������� ���������� �������� � ������� ���������� ��� 6-����������� ���������� ���������,  ��������� ������ ������� � ������, ��������������� ������������� ������ ����-5. ��� 1 - ��� ����������, ��������� ��� �������� �����, ������� ����� ������� � ����������. �� ��������� ������ ����� �� ������� ����� �������� ������ � ����������� ���������������, ����� � ������������� ������� BMW.
</p>
<?elseif (ereg('/cars/bmw_3series/', $APPLICATION->GetCurPage())):?>
<p style="position: absolute; top: 113px; width: 800px; margin-left: 50px;">
�� ����� 40 ���, ��� ������������ <b>BMW 3 �����</b>, ���� ������� �������� ��� ����� ������������ � � ���� ���� ���� ������� 6 ��������� ��� 3 (BMW F30). ���������� ������� ������������ ���������� ����� ����������� � ����� ������, �������� � ������������ ���� ���� ����� ������� ������. ��� ���� �� �������� �����������, ���������� � ���� �����������, �����������������, ��������� ������� ��� � ������������. ��������� �������� ���� ����������� � ���� ������ ������������ ������. ���������� ����� BMW 3 ����� �������������� � ������ ������ �� ������� ��������� �� ������� ������. � �� �� ����� ����� ���������� �� ��������� � ���������� ����������, � ���� ������ ����� ����� � ����������� � �������� ���� ��� 5 �����. ��������� ��������� � ���������� �������� ���������� - ������ ����� � ������, ���� �� ������������ ������-������ ���������, ��������� ��������� ������ � ������� �������. ���� �� ������� ���������� ���������� � �������� ����� ������ ���������� � ����������� ���������������, ����� � ������������� ������� BMW, ����������� ������ ����� ����.
</p>
<?elseif (ereg('/cars/bmw_5series/', $APPLICATION->GetCurPage())):?>
<p style="position: absolute; top: 105px; width: 800px; margin-left: 50px;">
<b>BMW 5 �����</b> ���������� �� ��������� ��������� ������������� �������� � ������ ������������� �����, ��� ������� ��� ����������� � ����������� ���. ����������� �������������� ����������� ��� 5 ��� ����� �������� ���� � ��� ����������, ��������� ��� ����������� ���������� ���� � ����� ������ ��������. �� ��� ���� BMW 520 ��� BMW 525 ����� ����� � �������� �����������, � ������� ��� ������� ����������� �� ��������� ��� ������� �� �����. ���� �� ��������� ����� �� ������� ������������� � ������������ ����������������, ������ � �������������� ������� BMW.
</p>
<?elseif (ereg('/cars/bmw_6series/', $APPLICATION->GetCurPage())):?>
<p style="position: absolute; top: 120px; width: 800px; margin-left: 50px;">
����������� ��� � 1975 ���� ���������� <b>BMW 6 �����</b> ������ ���� ���������� ������������ ��������� ������-������. ��� ����� ������ � ���������� �����, ������ ���������, ���������� ����������������� � ���������� � ������� � ���� ����. ��� ���� ����� ����������� �� ������ ������, � ���������� ��� 6 ����� �������� �������������. ������������� � ���������� �� ������ ������ �������� ��� ������������� ���� �������� ������, ����������� ��������, ���������� ������. ���������� ����� ���� ����������� �� ������ ������������ � � 4-�, 6-�� � 8-�� ����������� ���������� ������� �� 4,5 ���. ���. ��., ������ �������� ����� 2-� ���� � ��������� ��������� 320-400 �.�., ��� ��������� �������� �������� 100 ��/� ����� �� 5 ������. ��� ������ ����� ������� ���������� ������� � ����������� ����������������� ������.
</p>
<?elseif (ereg('/cars/bmw_7series/', $APPLICATION->GetCurPage())):?>
<p style="position: absolute; top: 125px; width: 800px; margin-left: 50px;">
����������� ��������������, ���� � ������������ ������� <b>BMW 7 �����</b> ������� ���� �� ���� � ����� ���� ������ �� ������� ����������, ��������� ����, ����� �� ���� ��� ����������. � ���� �������� ��������� ����-������ � ������� ���� �������������. ��������� ���������� ����� ���������� � ����� ��� �������� � ��� ������ � � ����������� �����, ��� 7 ����� ���������� ������� ��������� ����������. ����� ������ ������, ���������� ����� ���������� ��� � ���������� ������������� ������� ������ ���������� BMW 7 ����� ��������� �� �����������, ������� � ����������. � ���������������� �������-�������� �������� ��� ������ ���� � ������ ��������. ����� �� ����� �� ������� ���������� ����������� � ������ ����� ��������� �������������� � ������� ������������ ����������� ��� 7.
</p>
<?elseif (ereg('/cars/bmwmseries/', $APPLICATION->GetCurPage())||ereg('/cars/bmw_mseries/', $APPLICATION->GetCurPage())):?>
<p style="position: absolute; top: 125px; width: 800px; margin-left: 50px;">
���������� <b>BMW M3</b> ������������ ����� ���������� ����������� ������������ <a href="http://www.bmw-indep.ru/cars/bmw_3series/">��� 3 �����</a>. ���������� ��������, ����� ������ � ����������� ���������, ����������� �����, ���������� ������� ��� � ����� ���������� ����������������� � ��� �������� ������� ������ ����������� �� �����������.
<br /><br />
���������� <b>BMW M5</b> ��� ������������ ��������� ������ ������������ <a href="http://www.bmw-indep.ru/cars/bmw_5series/">��� 5 �����</a> � ������� �� ����� ���������� � ����������� ����� ���� � ���������� ������� ����� � ���������� ������.
<br /><br />
���������� <b>BMW M6</b> � ������� ���� ������ <a href="http://www.bmw-indep.ru/cars/bmw_6series/">��� 6</a>. ������ ����������� ���� ����������� ���������� �������������� �������� � � ����������� ���� ����������� � 2005 ����. ������ ��������� ����������� ������������, ��� ��������� �� ���� ����� �� ������ ������� �������������.
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