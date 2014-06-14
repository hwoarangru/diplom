<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
if(!empty($arResult['ITEMS'])) {
	?><div class="latest-news-block"><?
		?><b>Последние новости</b><?
		?><br /><?
		?><br /><?

		foreach($arResult['ITEMS'] as $arItem) {
			$sAddClass = $arParams['ELEMENT_ID'] == $arItem['ID'] ? ' active' : '';
			?><div class="news-item<?=$sAddClass?>"><?
				?><span class="date"><?
					echo $arItem['DISPLAY_ACTIVE_FROM'];
				?></span><?
				?><a class="name" href="<?=$arItem['DETAIL_PAGE_URL']?>"><?
					echo '&nbsp; '.$arItem['NAME'];
				?></a><?
			?></div><?
		}
	?></div><?
}
