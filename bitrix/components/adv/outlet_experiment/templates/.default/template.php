<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="outlet_ex_title">����������� ��� �������� BMW �������������</div>
<div class="outlet_ex_subtitle">��� ���� �� ����� �� 31 �����! ����������� ��������� � ����������.</div>
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
						<div class="outlet_ex_slider_item_textBox_priceline"><nobr style="font-size:36px;">�������� <?=number_format($arItem['PROPERTY_SALE_VALUE'], 0, '', ' ');?> �����������!</nobr></div>
						<div class="outlet_ex_slider_item_textBox_btn bk_outelt_ex" data-car="BMW <?=$arItem['NAME']?>(<?=$arItem['ID']?>)"><span><?=$arItem['PROPERTY_BUTTON_TEXT_VALUE']?></span></div>
					</div>
				</td>
				<?}?>
			<?}?>
		</tr></table>
	</div>
</div>
<div class="outlet_ex_infoLine">
	<div class="outlet_ex_infoLine_phoneBox">������� ���: <span class="ya-phone">8 (495) 787-80-08</span></div>
	<div class="outlet_ex_infoLine_callBack"><a href="#" class="callbackFormShow">�������� �������� ������</a></div>
</div>
<div class="outlet_ex_carBox">
	<?foreach($arResult['CARS'] as $arItem){?>
		<div class="outlet_ex_carItem">
			<div class="outlet_ex_carItem_title">BMW <span><?=$arItem['NAME']?></span></div>
			<div class="outlet_ex_carItem_priceline">�������� <span><?=number_format($arItem['PROPERTY_SALE_VALUE'], 0, '', ' ');?> �����������!</span></div>
			<div class="outlet_ex_carItem_preview"><img src="<?=$arItem['PREVIEW_PICTURE'];?>" alt="<?=$arItem['NAME']?>" /></div>
			<div class="outlet_ex_carItem_btn bk_outelt_ex" data-car="BMW <?=$arItem['NAME']?>(<?=$arItem['ID']?>)"><span><?=$arItem['PROPERTY_BUTTON_TEXT_VALUE']?></span></div>
		</div>
	<?}?>
</div>

<?$CurrentPage = $APPLICATION->GetCurPage();?>
<div class="callback_hidden_box popScrolled">
	<div class="outlet_ex_popForm_title">�������� ������</div>
	<?
	$APPLICATION->IncludeComponent("bitrix:form.result.new", "outlet_ex_form", Array(
		"SEF_MODE" => "N",	// �������� ��������� ���
		"WEB_FORM_ID" => $arResult['CALLBACK_FORM'],	// ID ���-�����
		"LIST_URL" => "",	// �������� �� ������� �����������
		"EDIT_URL" => "",	// �������� �������������� ����������
		"SUCCESS_URL" => $CurrentPage,	// �������� � ���������� �� �������� ��������
		"CHAIN_ITEM_TEXT" => "",	// �������� ��������������� ������ � ������������� �������
		"CHAIN_ITEM_LINK" => "",	// ������ �� �������������� ������ � ������������� �������
		"IGNORE_CUSTOM_TEMPLATE" => "N",	// ������������ ���� ������
		"USE_EXTENDED_ERRORS" => "N",	// ������������ ����������� ����� ��������� �� �������
		"CACHE_TYPE" => "N",	// ��� �����������
		"CACHE_TIME" => "0",	// ����� ����������� (���.)
		"VARIABLE_ALIASES" => array(
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID" => "RESULT_ID",
		)
		),
		false
	);?>
</div>

<div class="offer_hidden_box popScrolled">
	<div class="outlet_ex_popForm_title">�������������� �����������</div>
	<?
	$APPLICATION->IncludeComponent("bitrix:form.result.new", "outlet_ex_form", Array(
		"SEF_MODE" => "N",	// �������� ��������� ���
		"WEB_FORM_ID" => $arResult['OFFER_FORM'],	// ID ���-�����
		"LIST_URL" => "",	// �������� �� ������� �����������
		"EDIT_URL" => "",	// �������� �������������� ����������
		"SUCCESS_URL" => $CurrentPage,	// �������� � ���������� �� �������� ��������
		"CHAIN_ITEM_TEXT" => "",	// �������� ��������������� ������ � ������������� �������
		"CHAIN_ITEM_LINK" => "",	// ������ �� �������������� ������ � ������������� �������
		"IGNORE_CUSTOM_TEMPLATE" => "N",	// ������������ ���� ������
		"USE_EXTENDED_ERRORS" => "N",	// ������������ ����������� ����� ��������� �� �������
		"CACHE_TYPE" => "N",	// ��� �����������
		"CACHE_TIME" => "0",	// ����� ����������� (���.)
		"VARIABLE_ALIASES" => array(
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID" => "RESULT_ID",
		)
		),
		false
	);?>
</div>