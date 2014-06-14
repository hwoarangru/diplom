<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
foreach($arResult['CARS']['ITEMS'] as $arItem){
	$model = str_replace('&nbsp;','',strtolower(trim(str_replace(' ','',htmlentities($arItem['NAME'], null, 'utf-8')))));
	$arFilt[$model] = $arItem['NAME'];
}
foreach($arFilt as $modelKey => $arVal){?>
	<div class="button_silver">
		<a title="" href="#" data-model="<?=$modelKey;?>">
			<span><?=$arVal;?></span>
		</a>
	</div>
<?}?>
	<div class="button_silver" style="float:right;margin-top:11px;margin-rigth:10px;">
		<a data-model="all" title="" href="#">
			<span>Показать все</span>
		</a>
	</div>