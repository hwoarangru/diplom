<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
if(!empty($arResult['ITEMS'])) {
	?><div class="archive-news-block"><?
		?><b>�����</b><?
		?><br /><?
		?><br /><?

		foreach($arResult['ITEMS'] as $arItem) {
			$sAddClass = $arParams['YEAR'] == $arItem['YEAR'] ? ' active' : '';
			?><div class="news-item<?=$sAddClass?>"><?
				?><a class="name" href="<?=$arItem['DETAIL_PAGE_URL']?>"><?
					echo '&nbsp; '.$arItem['YEAR'].' ���';
				?></a><?
			?></div><?
		}
	?></div><?
}
