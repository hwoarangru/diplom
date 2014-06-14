<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="outlet_ex_title">Эксклюзивно для клиентов BMW Независимость</div>
<div class="outlet_ex_subtitle">Три шага до мечты до 31 марта! Подробности уточняйте у менеджеров.</div>
<div class="outlet_ex_slider">
	<div class="outlet_ex_left_arrow"></div>
	<div class="outlet_ex_right_arrow"></div>
	<div class="outlet_ex_sliderBox">
		<table class="outlet_ex_sliderTable"><tr>
			<?foreach($arResult['CARS_SLIDER'] as $arItem){
				if($arItem['DETAIL_PICTURE']){?>
				<td class="outlet_ex_slider_item">
					<div class="outlet_ex_slider_item_image"><img src="<?=$arItem['DETAIL_PICTURE'];?>" alt="<?=$arItem['NAME']?>" /></div>
					<div class="outlet_ex_slider_item_textBox">
						<div class="outlet_ex_slider_item_textBox_title">BMW <span><?=$arItem['NAME']?></span></div>
						<div class="outlet_ex_slider_item_textBox_priceline"><nobr style="font-size:36px;">Осталось <?=number_format($arItem['PROPERTY_SALE_VALUE'], 0, '', ' ');?> автомобилей!</nobr></div>
						<div class="outlet_ex_slider_item_textBox_btn bk_outelt_ex" data-car="BMW <?=$arItem['NAME']?>(<?=$arItem['ID']?>)"><span><?=$arItem['PROPERTY_BUTTON_TEXT_VALUE']?></span></div>
					</div>
				</td>
				<?}?>
			<?}?>
		</tr></table>
	</div>
</div>
<div class="outlet_ex_infoLine">
	<div class="outlet_ex_infoLine_phoneBox">Звоните нам: <span class="ya-phone">8 (495) 787-80-08</span></div>
	<div class="outlet_ex_infoLine_callBack"><a href="#" class="callbackFormShow">Заказать обратный звонок</a></div>
</div>
<div class="outlet_ex_carBox">
	<?foreach($arResult['CARS'] as $arItem){?>
		<div class="outlet_ex_carItem">
			<div class="outlet_ex_carItem_title">BMW <span><?=$arItem['NAME']?></span></div>
			<div class="outlet_ex_carItem_priceline">Осталось <span><?=number_format($arItem['PROPERTY_SALE_VALUE'], 0, '', ' ');?> автомобилей!</span></div>
			<div class="outlet_ex_carItem_preview"><img src="<?=$arItem['PREVIEW_PICTURE'];?>" alt="<?=$arItem['NAME']?>" /></div>
			<div class="outlet_ex_carItem_btn bk_outelt_ex" data-car="BMW <?=$arItem['NAME']?>(<?=$arItem['ID']?>)"><span><?=$arItem['PROPERTY_BUTTON_TEXT_VALUE']?></span></div>
		</div>
	<?}?>
</div>

<?$CurrentPage = $APPLICATION->GetCurPage();?>
<div class="callback_hidden_box popScrolled">
	<div class="outlet_ex_popForm_title">Обратный звонок</div>
	<?
	$APPLICATION->IncludeComponent("bitrix:form.result.new", "outlet_ex_form", Array(
		"SEF_MODE" => "N",	// Включить поддержку ЧПУ
		"WEB_FORM_ID" => $arResult['CALLBACK_FORM'],	// ID веб-формы
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

<div class="offer_hidden_box popScrolled">
	<div class="outlet_ex_popForm_title">Индивидуальное предложение</div>
	<?
	$APPLICATION->IncludeComponent("bitrix:form.result.new", "outlet_ex_form", Array(
		"SEF_MODE" => "N",	// Включить поддержку ЧПУ
		"WEB_FORM_ID" => $arResult['OFFER_FORM'],	// ID веб-формы
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