<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("image", "/images/tradein.jpg");
$APPLICATION->SetTitle("Автомобили BMW с пробегом");?>
<style type="text/css">
#completeText {
	left:30px;
}

#contentText {
	left:0px;
	padding-left:320px;
}

#copyText {
	width: 600px;
}
.divPanelTop{
	clear:both;
	width:604px;
	position: relative;
	left: 60px;
}

.divPanelTop A.divPanelLink2 {
	color: #4C4C4C;
	background: #FFF top right no-repeat url(/images/table.gif);
	padding-bottom: 6px;
	border-color: #999;
	border-bottom: 0px;
}

.divPanelTop A {
	position: relative;
	color: #4C4C4C;
	background: #FFF url(/images/table.gif) top right no-repeat;
	display: block;
	float: left;
	border: 0;
	padding: 5px 9px;
	border-left: 1px #999 solid;
	border-bottom: 1px #023499 solid;
	height:12px;
	width: 104px;
	-width: 122px;
	min-width: 99px;
	margin-right: 2px;
}

.divPanel{
	width: 604px;
	background-image: url(/images/divPanel.gif);
	background-position: -2px 0px;
	background-repeat: no-repeat;
	position: relative;
	clear: both;
	border: 1px #999 solid;
	left: 60px;
	top: -1px;
	padding: 7px 9px 4px;
	padding-top:0px;
	-moz-box-sizing: border-box;
	border-top:none;
}

.tableList { border-collapse: collapse; font-size: 11px;}
.tableList A { color: #000; }
.tableList TH{ white-space: nowrap; font-size: 11px; font-weight: normal; padding: 0 0 13px 15px; text-align: left; border: 0; border-bottom: 1px #999 solid; }
.tableList TD { border: 0; border-bottom: 1px #999 solid; padding: 1px 0px 1px 15px; cursor: pointer; height:34px;padding-top:0px;}
.tableList .first IMG	{ width: 49px; height: 34px; }
.tableList .first { width: 49px; padding-left: 0; height: 36px; }
.tableList TD.paging { border: 0; padding: 6px 0 0px !important; cursor: default; border-bottom: 0px none;}
.tableList DIV.paging { float: right; text-align: right; right: 0; }

.used-car{
	width: 260px;
	position:absolute;
	left:0px;
	top:0px;
	padding-bottom:50px;
	text-align: left;
}
.used-car .used-car-text{
	width: 260px;
}
 </style>
<div id="completeText" style="margin-left:320px;">
	<div id="headlines"> 
		<h1>Автомобили BMW с пробегом.</h1>
	</div>
	<div id="copyText">
		<p>
		Компания "Независимость" предлагает своим клиентам самые выгодные условия покупки и реализации автомобилей с пробегом. Мы всегда располагаем большим количеством автомобилей в наличии.</p>

		<p>Мы ценим время и деньги наших клиентов!</p>

		<p>
		В рамках программы <strong>Trade-in</strong> у Вас появляется реальная возможность поменять свой автомобиль на новый BMW, при этом Вы избавляетесь от забот о поиске покупателей на автомобиль и проблем, связанных с его реализацией. К зачету принимаются автомобили <strong>
		любых марок</strong>. После проведения технического осмотра и диагностики автомобиля, а также согласования цены, Вы уезжаете на новом автомобиле.</p>

		<p>
		Программа Trade-in распространяется на все автомобили, проданные через сеть официальных дилеров, а так же автомобили, ввезенные в Россию, которые прошли полную таможенную очистку.</p>

		<p>
		Компания "Независимость" предлагает услугу <strong>комиссионной продажи</strong> автомобиля. Условия приема не дают повода нашим покупателям сомневаться в честности и юридической чистоте автомобилей с пробегом. На комиссию принимаются автомобили с известной "историей", прошедшие полную диагностику и имеющие соответствующий внешний вид.</p>

		<p>
		На все автомобили распространяется гарантия юридической чистоты.</p>

		<p>
		Всегда в наличии широкий выбор автомобилей в сегменте "Premium".</p>

		<p>
		В нашем салоне Вы всегда можете воспользоваться дополнительными услугами при покупке автомобиля с пробегом:</p>

		<p>– кредит и лизинг;</p>

		<p>– страхование автомобиля в лучших страховых компаниях;</p>

		<p>– установка дополнительного оборудования.</p>

		<p>&nbsp;</p>

		 <!--//<div class="divPanelTop">
			<a class="divPanelLink2">Автомобили</a>
		</div>

	  <div class="divPanel">
	   <table width="100%" cellspacing="0" cellpadding="0" class="tableList">
		  <tbody>
			<tr>
				<th class="first" style="height: 35px; padding-bottom: 0px;"></th>
				<th><a href="?sort=model">Модель </a></th>
				<th><a href="?sort=salon_type">Тип кузова </a></th>
				<th width="100"><a href="?sort=color">Цвет </a></th>
				<th width="100"><a href="?sort=salon_car">Салон </a></th>
				<th><a href="?sort=prodYear">Год </a></th>
				<th><a href="?sort=mileage">Пробег </a></th>
				<th><a href="?sort=price">Цена </a></th>
			</tr>
	<?/*
	if($_GET['sort'] && $_GET['sort'] != '')
		$sortF = "property_".$_GET['sort'];
	else
		$sortF = "sort";?>
	<?$APPLICATION->IncludeComponent("bitrix:catalog.section","used_auto",
			Array(
				"IBLOCK_TYPE" => "models",
				"IBLOCK_ID" => "200",
				"SECTION_ID" => "",
				"ELEMENT_SORT_FIELD" => $sortF,
				"ELEMENT_SORT_ORDER" => "asc",
				"FILTER_NAME" => "arrFilter",
				"INCLUDE_SUBSECTIONS" => "N",
				"PAGE_ELEMENT_COUNT" => "9",
				"LINE_ELEMENT_COUNT" => "1",
				"PROPERTY_CODE" => array(0=>"prodYear",1=>"mileage",2=>"salon_car",3=>"salon_type",4=>"color",5=>"price",6=>"pics",7=>"",),
				"SECTION_URL" => "section.php?IBLOCK_ID=#IBLOCK_ID#&SECTION_ID=#SECTION_ID#",
				"DETAIL_URL" => "element.php?IBLOCK_ID=#IBLOCK_ID#&SECTION_ID=#SECTION_ID#&ELEMENT_ID=#ELEMENT_ID#",
				"BASKET_URL" => "/personal/basket.php",
				"ACTION_VARIABLE" => "action",
				"PRODUCT_ID_VARIABLE" => "id",
				"SECTION_ID_VARIABLE" => "SECTION_ID",
				"AJAX_MODE" => "Y",
				"AJAX_OPTION_SHADOW" => "Y",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "Y",
				"AJAX_OPTION_HISTORY" => "N",
				"CACHE_TYPE" => "N",
				"CACHE_TIME" => "3600",
				"META_KEYWORDS" => "-",
				"META_DESCRIPTION" => "-",
				"DISPLAY_PANEL" => "N",
				"DISPLAY_COMPARE" => "N",
				"SET_TITLE" => "N",
				"CACHE_FILTER" => "N",
				"PRICE_CODE" => array(),
				"USE_PRICE_COUNT" => "N",
				"SHOW_PRICE_COUNT" => "1",
				"PRICE_VAT_INCLUDE" => "Y",
				"DISPLAY_TOP_PAGER" => "N",
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"PAGER_TITLE" => "Товары",
				"PAGER_SHOW_ALWAYS" => "Y",
				"PAGER_TEMPLATE" => "",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000"
			));*/?>
			<tr>
				<td align="right" class="paging" colspan="8">
					<div align="right" class="paging"><?if($APPLICATION->NAVS > 1):?><?=$APPLICATION->PNUM?><?endif;?></div>
			   </td>
			</tr>
		   </tbody>
		</table>
	  </div>//-->
	</div>
	<!-- <div class="used-car">
		<div class="used-car-text">
			Компания "Независимость" предлагает Вам услуги по покупке и продаже автомобилей любых марок.
			У нас большой выбор автомобилей с пробегом. С нами Вы можете чувствовать себя спокойно.
			Все автомобили прошли предпродажную сервисную подготовку, а их юридическая чистота не подлежит никакому сомнению.<br /><br />
			<p>За подробной информацией по обращайтесь к менеджерам отдела трейд-ин по тел. 787 80 08</p><br />
		</div>
	</div> -->
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>