<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
?>
	<table cellpadding="5px" cellspacing="0" border="0" width="100%">
		<thead  class="car-list-head">
			<td>Автомобиль</td>
			<td>Комплектация</td>
			<td>Описание</td>
			<td>Цвет</td>
			<td>Цена</td>
		</thead>
		<?foreach ($arResult as $arItem){?>
			<tr class="car-list-item">
				<td style="font-weight:bold;font-size:120%;color:#000;"><?=$arParams['BRAND_NAME'];?> <?=$arItem['NAME']?></td>
				<td><?=$arItem['PROPERTY_COMPL_VALUE']?></td>
				<td><?=$arItem['DETAIL_TEXT']?></td>
				<td><?=$arItem['PROPERTY_COLOR_VALUE']?></td>
				<td style="font-weight:bold;font-size:120%;"><?=$arItem['PROPERTY_PRICE_VALUE']?> руб.</td>
			</tr>
		<?}?>
	</table>