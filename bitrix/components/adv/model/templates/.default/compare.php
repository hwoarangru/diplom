<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
?>

<script type="text/javascript" src="/bitrix/templates/.default/js/datasheet.js"></script>

<style type="text/css">

#horizontal-multilevel-menu2 {
    margin-top: 53px;
    z-index: 10000;
    margin-left: 30px;
}

#compare_innertable {
	overflow: auto;
}

#compare_table {
	width: 705px;
	z-index: 95;
}
</style>

<?if (!empty($arResult["MORE_PROPS"]) && $arResult["MORE_PROPS"] == "Y"):?><style  type="text/css">
#sales_navigation ul a {
	background-image: url(/bitrix/components/adv/model/templates/.default/images/sales_navigation_carbon_button_bg.png);
	color: #606060;
}
#vehicle_navigation ul a {
	background-image: url(/bitrix/components/adv/model/templates/.default/images/vehicle_navigation_button_bg_dark_vehicle_nav.gif);
	border-top: 1px solid #505050;
	color: white;
}
.teaser_cont {
	background-image: url(/bitrix/components/adv/model/templates/.default/images/vehicle_navigation_button_bg_dark.gif);
}
.teaser_cont .teaser_text {
	color: white;
}
.teaser_cont .teaser_text a{
	background-position: 0 -81px;
	color: white;
}
.teaser_cont .teaser_text a:hover{
	background-position: 0 -551px;
	color: #1D6AD4;
}
</style>
<?endif;?>

<div id="stage">
	<?if($arResult['FON'])
	{?>
		<img src="<?=$arResult['FON']?>" width="1024" height="634" alt="<?=$arResult['NAME']?>" />
	<?}?>
</div>
	<div id="compare_head">
        Выберите комплектацию. 
    </div>
    <div id="compare_select_1" style="display: block;">
		<a href="" onclick="return false" class="select compare_select_link">BMW 3 серии Гран Туризмо 320i</a>
		<div class="configure">
			<a href="" target="_blank" class="standard">Configure</a>
        </div>
        <div class="dropdown" style="display: none;">
			<div class="dropdown_content">
				<?foreach($arResult['technical'] as $tid=>$technical)
				{?>
					<a href="" model="<?=$technical['NAME']?>"><?=$arResult['NAME']?> <?=$technical['NAME']?></a>
				<?}?>
			</div>
        </div>
    </div>
    <div id="compare_select_2" style="display: block;">
		<a href="" onclick="return false" class="select compare_select_link">BMW 3 серии Гран Туризмо 320i</a>
		<div class="configure">
			<a href="" target="_blank" class="standard">Configure</a>
        </div>
        <div class="dropdown" style="display: none;">
			<div class="dropdown_content">
				<?foreach($arResult['technical'] as $tid=>$technical)
				{?>
					<a href="" model="<?=$technical['NAME']?>"><?=$arResult['NAME']?> <?=$technical['NAME']?></a>
				<?}?>
			</div>
        </div>
    </div>
    <div id="compare_table">
		<div id="compare_innertable" style="height: 383px;">
			<table width="687" border="0" cellspacing="0" cellpadding="0">
				<tbody>
					<tr>
						<td width="10"></td>
						<td width="209"></td>
						<td width="15"></td>
						<td width="219"></td>
						<td width="15"></td>
						<td width="219"></td>
					</tr>
					<?if(isset($arResult['technical'][0]["MASS"]["VALUE"][0]))
					{?>               
						<tr class="mc_table_headline">            
							<td></td>            
							<td colspan="5">Масса</td>          
						</tr>   
						<tr class="mc_table_seperator">
							<td colspan="6"></td>
						</tr>
						<?foreach($arResult['technical'][0]["MASS"]["VALUE"] as $pid => $mass)
						{?>
							<tr class="mc_table_entry">            
								<td></td>            
								<td class="leftalign"><?=$mass?><br></td>            
								<td></td>            
								<td><?=$arResult['technical'][0]["MASS"]["DESCRIPTION"][$mass]?><br></td>            
								<td></td>
								<td><?=$arResult['technical'][1]["MASS"]["DESCRIPTION"][$mass]?></td>								
							</tr>    
							<tr class="mc_table_seperator">
								<td colspan="6"></td>
							</tr>
						<?}
					}?>
				</tbody>
			</table>
		</div>

		<div style="margin-top:7px;">
			<a href="" id="openCompareInfoLayer" onclick="return false;" class="standard">* Сведения о приведенных данных</a>
		</div>


		<div style="margin-top:9px;">
			<div class="compare_icon icon_standard_equipment">Стандартное оснащение </div>
			<div class="compare_icon icon_extra_equipment">Специальное оснащение</div>
			<div class="compare_icon icon_original_equipment">Оригинальные аксессуары BMW</div>
			<div class="compare_icon icon_not_available">не предлагается</div>
		</div>

    </div>
	<script type="text/javascript">
        var pageOid = "4224365";
        var vehicle_navigation_teaser = "r";
        var compare_icon_source = new Array();
        compare_icon_source[1] = /* VIPURL */"../../../../../../../_common/files/img/model_compare/icon_standard_equipment.png";
        compare_icon_source[2] = /* VIPURL */"../../../../../../../_common/files/img/model_compare/icon_extra_equipment.png";
        compare_icon_source[3] = /* VIPURL */"../../../../../../../_common/files/img/model_compare/icon_original_equipment.png";
        compare_icon_source[4] = /* VIPURL */"../../../../../../../_common/files/img/model_compare/icon_not_available.png";
        $(document).ready(function(){
          initStandardPage();
          compareInit();
          compareWriteSelectboxes(compare_model_selected[1], compare_model_selected[2]);
          compareWriteTable(compare_model_selected[1], compare_model_selected[2]);
          $(window).resize(function() {
            compareSetTableHeight();
          });
          $("#closeCompareInfoLayer").click(function(){
            $("#compareInfoLayer").hide();
          });
          $("#openCompareInfoLayer").click(function(){
            $("#compareInfoLayer").show();
          });

          $("#compare_select_1 .select").click(function () {
            $("#compare_select_2 .dropdown").hide();
            if($("#compare_select_1 .dropdown").css("display") == "block"){
              $("#compare_select_1 .dropdown").hide();
            }else{
              $("#compare_select_1 .dropdown").show();
            }
          });

          $("#compare_select_2 .select").click(function () {
            $("#compare_select_1 .dropdown").hide();
            if($("#compare_select_2 .dropdown").css("display") == "block"){
              $("#compare_select_2 .dropdown").hide();
            }else{
              $("#compare_select_2 .dropdown").show();
            }
          });

          $(document).click(function (e) {
            if(!$(e.target).hasClass("compare_select_link")){
              $("#compare_select_1 .dropdown").hide();
              $("#compare_select_2 .dropdown").hide();
            }
          });

          $(".dropdown_content a").click(
            function () {
              var currentModel =
              compare_model_selected[$(this).parent().parent().parent().attr("id").charAt($(this).parent().parent().parent().attr("id").length - 1)] = $(this).attr("model");
              compareWriteSelectboxes(compare_model_selected[1], compare_model_selected[2]);
              compareWriteTable(compare_model_selected[1], compare_model_selected[2]);
              $("#compare_select_1 .dropdown").hide();
              $("#compare_select_2 .dropdown").hide();
              return false;
            }
          );

        });

	<?foreach($arResult['technical'] as $technical)
	{
		$i=0;?>
		compare_model['<?=$technical['NAME']?>'] = new Array();
		compare_model['<?=$technical['NAME']?>']['model_name'] = '<?=$arResult["NAME"]?> <?=$technical['NAME']?>';
		compare_model['<?=$technical['NAME']?>']['short_model_name'] = '<?=$arResult['technical']['NAME']?>';
		compare_model['<?=$technical['NAME']?>']['configure_link'] = '';
		<?/////////////////////////////////////////////////////
		if(isset($technical["MASS"]["VALUE"][0]))
		{?>
			compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('Масса','','',false, 0);
			<?$i++;
			foreach($technical["MASS"]["VALUE"] as $pid => $mass)
			{?>
				compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('','<?=$mass?>','<?=$technical["MASS"]["DESCRIPTION"][$pid]?>',false, 0);
				<?$i++;
			}
		}
		////////////////////////////////////////////////////////
		if(isset($technical["ENGINE"]["VALUE"][0]))
		{?>
			compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('Двигатель','','',false, 0);
			<?$i++;
			foreach($technical["ENGINE"]["VALUE"] as $pid => $engine)
			{?>
				compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('','<?=$engine?><br>','<?=$technical["ENGINE"]["DESCRIPTION"][$pid]?>',false, 0);
				<?$i++;
			}
		}
		////////////////////////////////////////////////////////
		if(isset($technical["TTX"]["VALUE"][0]))
		{?>
			compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('Технические характеристики','','',false, 0);
			<?$i++;
			foreach($technical["TTX"]["VALUE"] as $pid => $ttx)
			{?>
				compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('','<?=$ttx?><br>','<?=$technical["TTX"]["DESCRIPTION"][$pid]?>',false, 0);
				<?$i++;
			}
		}
		////////////////////////////////////////////////////////
		if(isset($technical["GAS"]["VALUE"][0]))
		{?>
			compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('Расход топлива','','',false, 0);
			<?$i++;
			foreach($technical["GAS"]["VALUE"] as $pid => $gas)
			{?>
				compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('','<?=$gas?><br>','<?=$technical["GAS"]["DESCRIPTION"][$pid]?>',false, 0);
				<?$i++;
			}
		}
		////////////////////////////////////////////////////////
		if(isset($technical["WHEELS"]["VALUE"][0]))
		{?>
			compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('Колеса','','',false, 0);
			<?$i++;
			foreach($technical["WHEELS"]["VALUE"] as $pid => $wheels)
			{?>
				compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('','<?=$wheels?><br>','<?=$technical["WHEELS"]["DESCRIPTION"][$pid]?>',false, 0);
				<?$i++;
			}
		}
		////!!!!!!!!!!! 1-черный кубик 2-белый кубик 3-ромбик 4-прочерк
		if(isset($technical["SHASSI"]["VALUE"][0]))
		{?>
			compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('Двигатель и шасси','','',false, 0);
			<?$i++;
			foreach($technical["SHASSI"]["VALUE"] as $pid => $shassi)
			{
				if(preg_match("(^\d$)", $technical["SHASSI"]["DESCRIPTION"][$pid]))
				{?>
					compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('','<?=$shassi?><br>','',false, <?=$technical["SHASSI"]["DESCRIPTION"][$pid]?>);
				<?}
				else
				{?>
					compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('','<?=$shassi?><br>','<?=$technical["SHASSI"]["DESCRIPTION"][$pid]?>',false, 0);
				<?}
				$i++;
			}
		}
		////!!!!!!!!!!! 1-черный кубик 2-белый кубик 3-ромбик 4-прочерк
		if(isset($technical["SAFETY"]["VALUE"][0]))
		{?>
			compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('Безопасность и эргономика','','',false, 0);
			<?$i++;
			foreach($technical["SAFETY"]["VALUE"] as $pid => $safety)
			{
				if(preg_match("(^\d$)", $technical["SAFETY"]["DESCRIPTION"][$pid]))
				{?>
					compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('','<?=$safety?><br>','',false, <?=$technical["SAFETY"]["DESCRIPTION"][$pid]?>);
				<?}
				else
				{?>
					compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('','<?=$safety?><br>','<?=$technical["SAFETY"]["DESCRIPTION"][$pid]?>',false, 0);
				<?}
				$i++;
			}
		}
		////!!!!!!!!!!! 1-черный кубик 2-белый кубик 3-ромбик 4-прочерк
		if(isset($technical["OUTSIDE"]["VALUE"][0]))
		{?>
			compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('Внешнее оборудование','','',false, 0);
			<?$i++;
			foreach($technical["OUTSIDE"]["VALUE"] as $pid => $outside)
			{
				if(preg_match("(^\d$)", $technical["OUTSIDE"]["DESCRIPTION"][$pid]))
				{?>
					compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('','<?=$outside?><br>','',false, <?=$technical["OUTSIDE"]["DESCRIPTION"][$pid]?>);
				<?}
				else
				{?>
					compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('','<?=$outside?><br>','<?=$technical["OUTSIDE"]["DESCRIPTION"][$pid]?>',false, 0);
				<?}
				$i++;
			}
		}
		////!!!!!!!!!!! 1-черный кубик 2-белый кубик 3-ромбик 4-прочерк
		if(isset($technical["INSIDE"]["VALUE"][0]))
		{?>
			compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('Оборудование салона','','',false, 0);
			<?$i++;
			foreach($technical["INSIDE"]["VALUE"] as $pid => $inside)
			{
				if(preg_match("(^\d$)", $technical["INSIDE"]["DESCRIPTION"][$pid]))
				{?>
					compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('','<?=$inside?><br>','',false, <?=$technical["INSIDE"]["DESCRIPTION"][$pid]?>);
				<?}
				else
				{?>
					compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('','<?=$inside?><br>','<?=$technical["INSIDE"]["DESCRIPTION"][$pid]?>',false, 0);
				<?}
				$i++;
			}
		}
		////!!!!!!!!!!! 1-черный кубик 2-белый кубик 3-ромбик 4-прочерк
		if(isset($technical["EFFICIENT"]["VALUE"][0]))
		{?>
			compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('EfficientDynamics','','',false, 0);
			<?$i++;
			foreach($technical["EFFICIENT"]["VALUE"] as $pid => $efficient)
			{
				if(preg_match("(^\d$)", $technical["EFFICIENT"]["DESCRIPTION"][$pid]))
				{?>
					compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('','<?=$efficient?><br>','',false, <?=$technical["EFFICIENT"]["DESCRIPTION"][$pid]?>);
				<?}
				else
				{?>
					compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('','<?=$efficient?><br>','<?=$technical["EFFICIENT"]["DESCRIPTION"][$pid]?>',false, 0);
				<?}
				$i++;
			}
		}
		////!!!!!!!!!!! 1-черный кубик 2-белый кубик 3-ромбик 4-прочерк
		if(isset($technical["MEDIA"]["VALUE"][0]))
		{?>
			compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('Мультимедийное, коммуникационное и информационное оборудование','','',false, 0);
			<?$i++;
			foreach($technical["MEDIA"]["VALUE"] as $pid => $media)
			{
				if(preg_match("(^\d$)", $technical["MEDIA"]["DESCRIPTION"][$pid]))
				{?>
					compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('','<?=$media?><br>','',false, <?=$technical["MEDIA"]["DESCRIPTION"][$pid]?>);
				<?}
				else
				{?>
					compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('','<?=$media?><br>','<?=$technical["MEDIA"]["DESCRIPTION"][$pid]?>',false, 0);
				<?}
				$i++;
			}
		}
		////!!!!!!!!!!! 1-черный кубик 2-белый кубик 3-ромбик 4-прочерк
		if(isset($technical["SERV"]["VALUE"][0]))
		{?>
			compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('Обслуживание','','',false, 0);
			<?$i++;
			foreach($technical["SERV"]["VALUE"] as $pid => $serv)
			{
				if(preg_match("(^\d$)", $technical["SERV"]["DESCRIPTION"][$pid]))
				{?>
					compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('','<?=$serv?><br>','',false, <?=$technical["SERV"]["DESCRIPTION"][$pid]?>);
				<?}
				else
				{?>
					compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('','<?=$serv?><br>','<?=$technical["SERV"]["DESCRIPTION"][$pid]?>',false, 0);
				<?}
				$i++;
			}
		}
	}?>
</script>
<div id="facebook_like">
<iframe src="//www.facebook.com/plugins/like.php?href=<?= urlencode("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])?>&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>