<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$x = strtotime($arParams['DEADLINE']);
$y = time();
$time = $x - $y;
$date = list($days,$hours,$minutes) = explode(':',date('d:H:i:s', $time));
?>
<script type="text/javascript" src="/bitrix/components/adv/auto.offers.client/templates/.default/jquery.cookie.js"></script>
<div style="width:660px;">
	<div id="dateafter" style="display:none;"><?=date('M,d,Y,H:i:s', strtotime($arParams['DEADLINE']));?></div>
	<div class="counter_box">
		<table width="100%">
			<tr>
				<td class="counterSlicesBox">
					<h1 style="width:auto !important;color:#000;">Дни горячих предложений в БМВ Независимость</h1>
					<div class="slicesLine"> 
						<div class="daySlice"><span><?=$days?></span><div>Дни</div></div>
						<div class="hourSlice"><span><?=$hours?></span><div>Часы</div></div>
						<div class="minutsSlice"><span><?=$minutes?></span><div>Минуты</div></div>
					</div>
					<div style="clear:both;padding-top:25px;"><p>Успей купить до конца акции!<br />Количество автомобилей ограничено.<br />Полный список предложений уточняйте по телефону.</p></div>
				</td> 
				<td class="counterDescBox"> 
					<span style="font-size:12px;">Подробности акции</span>
					<h3 style="font-weight:100;padding-top:15px;">БМВ Независимость</h3>
					<h3><span class="ya-phone">+7 (495) 797-90-90</span></h3>
					<p>
						Хорошевское шоссе,<br />
						д. 70, корп. 1<br />
						123007 Москва
					</p>
				</td>
			</tr>
		</table>
	</div>
	<div class="filter_headline">Выберите модель:</div>
	<div class="outlet_mark_box">
		<?$APPLICATION->IncludeComponent("adv:auto.offers.client", "menu",
			Array('BRAND_CODE'=>$arParams['BRAND_CODE'],'CITY'=>$arParams['CITY'], 'DEADLINE'=>$arParams['DEADLINE']),
			false
		);?>
	</div>
	<h1 style="width:660px;margin-top:21px;">Дни горячих предложений в БМВ Независимость</h1>
	<?$i=0;foreach ($arResult['CARS']['ITEMS'] as $arItem){$i++;
		$model = str_replace('&nbsp;','',strtolower(trim(str_replace(' ','',htmlentities($arItem['NAME'], null, 'utf-8')))));?>
		<div class="outlet_car_box carFilt_<?=$model;?>" style="background:#<?=($i%2==0?"eee":"fff");?>;padding:15px 0px;">
			<table class="outlet_table" data-id="<?=$arItem['ID'];?>" id="car_<?=$arItem['ID'];?>">
				<tr>
					<td class="image_box">
						<img src="http://outlet.indep.ru/<?=$arItem['PREVIEW_PICTURE'];?>" width="176" height="98" alt="">
						<p class="detlink"><strong>Подробности по телефону<br /><span class="ya-phone">+7 (495) 797-90-90</span></strong></p>
					</td>
					<td class="car_desc_box" data-carline="BMW <?=trim(str_replace('Audi', '', $arItem['NAME']));?>(<?=$arItem['ID'];?>)">
						<div>
							BMW <span class="colormark"><?=trim(str_replace('Audi', '', $arItem['NAME']));?></span>
							<p>
							Цвет: <?=$arItem['PROPERTY_COLOR_VALUE'];?><br />
							<span class="detlink" style="padding-top:10px;display:block;">Комплектация: <a href="#detail" class="detailLink" style="text-decoration:underline;">Подробнее</a></span>
							</p>
						</div>
					</td>
					<td class="buttons_box">
						<bprice><?echo number_format(intVal(str_replace(' ','',$arItem['PROPERTY_OFFER_PRICE_VALUE'])),0,'',' ');?> р.</bprice>
						<price><?echo $arItem['PROPERTY_PRICE_VALUE'];?> р.</price>
						<a class="button-silver td_outlet td_res_btn" style="width:70px;" title="" href="#" data-car="<?=$arItem['ID'];?>">Тест-драйв</a>
						<a class="button-silver bk_outlet" style="width:90px;" title="" href="#" data-car="<?=$arItem['ID'];?>">Забронировать</a>
						<a class="button-silver cr_outlet" style="width:50px;" title="" href="#" data-car="<?=$arItem['ID'];?>">Кредит</a>
					</td>
				<tr>
			</table>
			<div class="detail_outlet_car_box">
				<table width="100%">
					<tr>
						<td class="image_box outlet_detail_pic" style="vertical-align:top;">
							<img src="http://outlet.indep.ru/<?=$arItem['PREVIEW_PICTURE'];?>" width="176" height="98" alt="">
							<p class="detlink"><strong>Подробности по телефону<br /> <span class="ya-phone">+7 (495) 797-90-90</span></strong></p>
						</td>
						<td class="car_desc_box outlet_detail_desc" style="vertical-align:top;">
							BMW <span class="colormark"><?=trim(str_replace('Audi', '', $arItem['NAME']));?></span>
							<div class="buttons_box" style="padding-top:25px;text-align:left;">
								<span style="font-size:14px;">Цвет: <?=$arItem['PROPERTY_COLOR_VALUE'];?></span><br />
							</div>
							<a href="#detail" class="detailLinkclose" style="color:#000;text-decoration:underline;font-size:12px;padding-top:21px;"><br />Свернуть</a>
						</td>
						<td class="buttons_box" style="text-align:center;">
							<bprice><?echo number_format(intVal(str_replace(' ','',$arItem['PROPERTY_OFFER_PRICE_VALUE'])),0,'',' ');?> р.</bprice>
							<price><?echo $arItem['PROPERTY_PRICE_VALUE'];?> р.</price>
						</td>
					<tr>
				</table>
				<div class="outlet_detail_opts_desc" style="font-size:13px;padding:11px 0px;">
					<?=htmlspecialchars_decode($arItem['DETAIL_TEXT']);?><br />
				</div>
				<p style="padding-left:30px;" class="outlet_buttons_detail_box">
					<a class="button-silver td_outlet td_res_btn" style="width:70px;" title="" href="#" data-car="<?=$arItem['ID'];?>">Тест-драйв</a>
					<a class="button-silver bk_outlet" style="width:90px;" title="" href="#" data-car="<?=$arItem['ID'];?>">Забронировать</a>
					<a class="button-silver cr_outlet" style="width:50px;" title="" href="#" data-car="<?=$arItem['ID'];?>">Кредит</a>
				</p>
			</div>
		</div>
	<?}?>
</div>
<?
$CurrentPage = $APPLICATION->GetCurPage();
?>
<div class="TEST_DRIVE_hidden_box popScrolled">
	<div style="padding-bottom:10px;padding-top:15px; text-align:center">
		<center>
			<h2 style="color:#000;font-size:14px;">Для участия в тест-драйве вам понадобятся только паспорт и права</h2>
		</center>
		<hr />
			<div style="width:110px;float:left;">
				<img src="" class="popCarImage" alt="" width="92px" height="60px" />
			</div>
			<div style="font-size:14px;float:left;width:170px;">
				<div>
					<h2 style="color:#000;font-size:14px;padding-bottom:10px;width:auto;" class="popCarName"></h2>
					<bprice class="popCarPrice"></bprice>
					<price class="popCarPriceOld"></price>
				</div>
			</div>
		<hr style="clear:both;" />
		<p style="text-align:center;font-size:14px;margin-bottom:10px">
			<?if($_REQUEST['formresult']=='addok'&&$_REQUEST['WEB_FORM_ID']==$arResult['TEST_DRIVE']){?>
				<b style="color:#000;padding-top:30px;display:block;">В течение часа мы свяжемся с вами для уточнения точного времени и ваших пожеланий</b>
			<?}else{?>
				Записывайтесь на тест-драйв<br />
				по телефону<br />
				<span style="font-size:16px;color:#C60A3A;display:block;textalign:center;padding-top:5px;padding-bottom:5px;"><span class="ya-phone">(495) 797-90-90</span></span>
				Либо выберите день и время онлайн
			<?}?>
		</p>
	</div>
	<?
	$APPLICATION->IncludeComponent("bitrix:form.result.new", "outlet_forms", Array(
		"SEF_MODE" => "N",	// Включить поддержку ЧПУ
		"WEB_FORM_ID" => $arResult['TEST_DRIVE'],	// ID веб-формы
		"LIST_URL" => "",	// Страница со списком результатов
		"EDIT_URL" => "",	// Страница редактирования результата
		"SUCCESS_URL" => $CurrentPage,	// Страница с сообщением об успешной отправке
		"CHAIN_ITEM_TEXT" => "",	// Название дополнительного пункта в навигационной цепочке
		"CHAIN_ITEM_LINK" => "",	// Ссылка на дополнительном пункте в навигационной цепочке
		"IGNORE_CUSTOM_TEMPLATE" => "N",	// Игнорировать свой шаблон
		"USE_EXTENDED_ERRORS" => "N",	// Использовать расширенный вывод сообщений об ошибках
		"CACHE_TYPE" => "N",	// Тип кеширования
		"CACHE_TIME" => "0",	// Время кеширования (сек.)
		"VARIABLE_ALIASES" => array(
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID" => "RESULT_ID",
		)
		),
		false
	);?>
</div>

<div class="BOOKING_hidden_box popScrolled">
	<div style="padding-bottom:10px;padding-top:15px; text-align:center">
		<center>
			<h2 style="color:#000;font-size:14px;">Забронируйте свою <span style="color:#C60A3A;font-size:14px;">BMW</span> сейчас<br />по самой лучшей цене</h2>
		</center>
		<hr />
			<div style="width:110px;float:left;">
				<img src="" class="popCarImage" alt="" width="92px" height="60px" />
			</div>
			<div style="font-size:14px;float:left;width:170px;">
				<div>
					<h2 style="color:#000;font-size:14px;padding-bottom:10px;width:auto;" class="popCarName"></h2>
					<bprice class="popCarPrice"></bprice>
					<price class="popCarPriceOld"></price>
				</div>
			</div>
		<hr style="clear:both;" />
		<p style="text-align:center;font-size:14px;margin-bottom:10px">
			<?if($_REQUEST['formresult']=='addok'&&$_REQUEST['WEB_FORM_ID']==$arResult['BOOKING']){?>
				<b style="color:#000;padding-top:30px;display:block;">В течение часа мы свяжемся с вами<br />
				для подтверждения бронирования</b>
			<?}else{?>
				Для предварительного бронирования<br />
				звоните по телефону<br />
				<span style="font-size:16px;color:#C60A3A;display:block;textalign:center;padding-top:5px;padding-bottom:5px;"><span class="ya-phone">(495) 797-90-90</span></span>
				Либо воспользуйтесь онлайн-заявкой
			<?}?>
		</p>
	</div>
	<?
	$APPLICATION->IncludeComponent("bitrix:form.result.new", "outlet_forms", Array(
		"SEF_MODE" => "N",	// Включить поддержку ЧПУ
		"WEB_FORM_ID" => $arResult['BOOKING'],	// ID веб-формы
		"LIST_URL" => "",	// Страница со списком результатов
		"EDIT_URL" => "",	// Страница редактирования результата
		"SUCCESS_URL" => $CurrentPage,	// Страница с сообщением об успешной отправке
		"CHAIN_ITEM_TEXT" => "",	// Название дополнительного пункта в навигационной цепочке
		"CHAIN_ITEM_LINK" => "",	// Ссылка на дополнительном пункте в навигационной цепочке
		"IGNORE_CUSTOM_TEMPLATE" => "N",	// Игнорировать свой шаблон
		"USE_EXTENDED_ERRORS" => "N",	// Использовать расширенный вывод сообщений об ошибках
		"CACHE_TYPE" => "N",	// Тип кеширования
		"CACHE_TIME" => "0",	// Время кеширования (сек.)
		"VARIABLE_ALIASES" => array(
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID" => "RESULT_ID",
		)
		),
		false
	);?>
</div>

<div class="CREDIT_hidden_box popScrolled">
	<div style="padding-bottom:10px;padding-top:15px; text-align:center">
		<center>
			<h2 style="color:#000;font-size:14px;">Оформите кредит на <span style="color:#C60A3A;font-size:14px;">BMW</span> сейчас<br />по самой лучшей цене</h2>
		</center>
		<hr />
			<div style="width:110px;float:left;">
				<img src="" class="popCarImage" alt="" width="92px" height="60px" />
			</div>
			<div style="font-size:14px;float:left;width:170px;">
				<div>
					<h2 style="color:#000;font-size:14px;padding-bottom:10px;width:auto;" class="popCarName"></h2>
					<bprice class="popCarPrice"></bprice>
					<price class="popCarPriceOld"></price>
				</div>
			</div>
		<hr style="clear:both;" />
		<p style="text-align:center;font-size:14px;margin-bottom:10px">
			<?if($_REQUEST['formresult']=='addok'&&$_REQUEST['WEB_FORM_ID']==$arResult['CREDIT']){?>
				<b style="color:#000;padding-top:30px;display:block;">Спасибо! В ближайшее время наш менеджер свяжется с вами</b>
			<?}else{?>
				Для оформления кредита<br />
				звоните по телефону<br />
				<span style="font-size:16px;color:#C60A3A;display:block;textalign:center;padding-top:5px;padding-bottom:5px;"><span class="ya-phone">+7 (495) 797-90-90</span></span>
				Либо воспользуйтесь онлайн-заявкой
			<?}?>
		</p>
	</div>
	<?
	$APPLICATION->IncludeComponent("bitrix:form.result.new", "outlet_forms", Array(
		"SEF_MODE" => "N",	// Включить поддержку ЧПУ
		"WEB_FORM_ID" => $arResult['CREDIT'],	// ID веб-формы
		"LIST_URL" => "",	// Страница со списком результатов
		"EDIT_URL" => "",	// Страница редактирования результата
		"SUCCESS_URL" => $CurrentPage,	// Страница с сообщением об успешной отправке
		"CHAIN_ITEM_TEXT" => "",	// Название дополнительного пункта в навигационной цепочке
		"CHAIN_ITEM_LINK" => "",	// Ссылка на дополнительном пункте в навигационной цепочке
		"IGNORE_CUSTOM_TEMPLATE" => "N",	// Игнорировать свой шаблон
		"USE_EXTENDED_ERRORS" => "N",	// Использовать расширенный вывод сообщений об ошибках
		"CACHE_TYPE" => "N",	// Тип кеширования
		"CACHE_TIME" => "0",	// Время кеширования (сек.)
		"VARIABLE_ALIASES" => array(
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID" => "RESULT_ID",
		)
		),
		false
	);?>
</div>